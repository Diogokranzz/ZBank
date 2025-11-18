<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditService
{
    public function log(
        string $action,
        ?string $description = null,
        ?int $userId = null,
        ?Request $request = null
    ): AuditLog {
        return AuditLog::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => $request?->ip() ?? request()->ip(),
            'user_agent' => $request?->userAgent() ?? request()->userAgent(),
        ]);
    }

    public function logTransaction(int $userId, string $transactionType, float $amount, int $transactionId): AuditLog
    {
        return $this->log(
            'transaction',
            "Transação {$transactionType} de R$ " . number_format($amount, 2, ',', '.') . " (ID: {$transactionId})",
            $userId
        );
    }

    public function logLogin(int $userId, Request $request): AuditLog
    {
        return $this->log(
            'login',
            'Usuário realizou login no sistema',
            $userId,
            $request
        );
    }

    public function logCardBlock(int $userId, int $cardId, bool $isBlocked): AuditLog
    {
        $action = $isBlocked ? 'bloqueado' : 'desbloqueado';
        
        return $this->log(
            'card_block',
            "Cartão ID {$cardId} foi {$action}",
            $userId
        );
    }

    public function cleanOldLogs(): int
    {
        return AuditLog::where('created_at', '<', now()->subDays(90))->delete();
    }
}
