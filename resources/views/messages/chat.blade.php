<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Chat with {{ $user->name }} - Htc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>tailwind.config={theme:{extend:{colors:{"primary":"#13a4ec"},fontFamily:{"display":["Manrope","sans-serif"]}}}}</script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4 flex items-center justify-between">
<a href="{{ route('messages.index') }}" class="text-primary font-bold">← Back</a>
<h1 class="text-lg font-bold">{{ $user->name }}</h1>
</header>
<main class="max-w-4xl mx-auto px-4 py-8">
<div class="bg-white rounded-lg border">
<div id="messages" class="p-6 space-y-4 h-96 overflow-y-auto">
@foreach($messages as $message)
<div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
<div class="max-w-xs px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-gray-100' }}">
<p class="text-sm">{{ $message->message }}</p>
<p class="text-xs opacity-70 mt-1">{{ $message->created_at->format('h:i A') }}</p>
</div>
</div>
@endforeach
</div>
<form id="messageForm" class="border-t p-4 flex gap-2">
@csrf
<input type="text" id="messageInput" name="message" placeholder="Type a message..." class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" required/>
<button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">Send</button>
</form>
</div>
</main>
<script>
const messagesDiv = document.getElementById('messages');
const form = document.getElementById('messageForm');
const input = document.getElementById('messageInput');
const userId = {{ $user->id }};
const currentUserId = {{ auth()->id() }};

// Scroll to bottom
function scrollToBottom() {
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

scrollToBottom();

// Send message
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const message = input.value.trim();
    if (!message) return;

    const response = await fetch(`/messages/send/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ message })
    });

    if (response.ok) {
        input.value = '';
        fetchMessages();
    }
});

// Fetch new messages
async function fetchMessages() {
    const response = await fetch(`/messages/fetch/${userId}`);
    const data = await response.json();
    
    messagesDiv.innerHTML = '';
    data.messages.forEach(msg => {
        const div = document.createElement('div');
        div.className = `flex ${msg.sender_id === currentUserId ? 'justify-end' : 'justify-start'}`;
        div.innerHTML = `
            <div class="max-w-xs px-4 py-2 rounded-lg ${msg.sender_id === currentUserId ? 'bg-primary text-white' : 'bg-gray-100'}">
                <p class="text-sm">${msg.message}</p>
                <p class="text-xs opacity-70 mt-1">${new Date(msg.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}</p>
            </div>
        `;
        messagesDiv.appendChild(div);
    });
    
    scrollToBottom();
}

// Poll for new messages every 3 seconds
setInterval(fetchMessages, 3000);
</script>
</body>
</html>
