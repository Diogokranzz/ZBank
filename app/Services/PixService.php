<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PixService
{
    public function generateQrCodePayload(string $pixKey, float $amount, string $description): string
    {
        $payload = [
            'pixKey' => $pixKey,
            'amount' => number_format($amount, 2, '.', ''),
            'description' => substr($description, 0, 140),
            'timestamp' => now()->toIso8601String(),
        ];
        
        return base64_encode(json_encode($payload));
    }

    public function validateBalance(User $user, float $amount): bool
    {
        return $user->balance >= $amount;
    }

    public function processTransaction(User $sender, string $recipientKey, float $amount, string $description): Transaction
    {
        return DB::transaction(function () use ($sender, $recipientKey, $amount, $description) {
            if (!$this->validateBalance($sender, $amount)) {
                throw new \Exception('Saldo insuficiente para realizar a transação.');
            }

            $sender->decrement('balance', $amount);

            $transaction = Transaction::create([
                'user_id' => $sender->id,
                'card_id' => null,
                'type' => 'pix_sent',
                'amount' => $amount,
                'description' => $description,
                'recipient_key' => $recipientKey,
                'status' => 'completed',
            ]);

            return $transaction;
        });
    }
}
