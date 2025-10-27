<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'total_credited',
        'total_debited',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_credited' => 'decimal:2',
        'total_debited' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function hasBalance($amount)
    {
        return $this->balance >= $amount;
    }

    public function debit($amount, $description = null, $referenceType = null, $referenceId = null)
    {
        $balanceBefore = $this->balance;
        $this->balance -= $amount;
        $this->total_debited += $amount;
        $this->save();

        $this->transactions()->create([
            'transaction_type' => 'debit',
            'amount' => $amount,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
        ]);

        return $this;
    }

    public function credit($amount, $description = null, $referenceType = null, $referenceId = null)
    {
        $balanceBefore = $this->balance;
        $this->balance += $amount;
        $this->total_credited += $amount;
        $this->save();

        $this->transactions()->create([
            'transaction_type' => 'credit',
            'amount' => $amount,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
        ]);

        return $this;
    }
}
