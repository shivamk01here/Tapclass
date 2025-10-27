<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get unique conversations (users the current user has messaged with)
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver : $message->sender;
            })
            ->unique('id')
            ->values();

        return view('messages.index', compact('conversations'));
    }

    public function chat(User $user)
    {
        $currentUser = Auth::user();
        
        // Get all messages between current user and selected user
        $messages = Message::where(function($q) use ($currentUser, $user) {
            $q->where('sender_id', $currentUser->id)
              ->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($currentUser, $user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $currentUser->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.chat', compact('user', 'messages'));
    }

    public function send(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $request->message,
            'is_read' => false
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    public function fetch(User $user)
    {
        $currentUser = Auth::user();
        
        // Get new messages since last fetch
        $messages = Message::where(function($q) use ($currentUser, $user) {
            $q->where('sender_id', $currentUser->id)
              ->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($currentUser, $user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $currentUser->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $messages
        ]);
    }
}
