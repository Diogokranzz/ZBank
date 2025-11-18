<?php

namespace App\Services;

use App\Models\Card;
use Carbon\Carbon;

class CardService
{
    public function generateCardNumber(): string
    {
        $cardNumber = '';
        for ($i = 0; $i < 15; $i++) {
            $cardNumber .= rand(0, 9);
        }

        $checkDigit = $this->calculateLuhnCheckDigit($cardNumber);
        
        return $cardNumber . $checkDigit;
    }

    private function calculateLuhnCheckDigit(string $number): int
    {
        $sum = 0;
        $length = strlen($number);
        
        for ($i = 0; $i < $length; $i++) {
            $digit = (int) $number[$length - 1 - $i];
            
            if ($i % 2 === 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            
            $sum += $digit;
        }
        
        return (10 - ($sum % 10)) % 10;
    }

    public function generateCvv(): string
    {
        return str_pad((string) rand(0, 999), 3, '0', STR_PAD_LEFT);
    }

    public function calculateExpiryDate(): Carbon
    {
        return Carbon::now()->addYears(5);
    }

    public function getLimitByType(string $type): float
    {
        return match (strtolower($type)) {
            'platinum' => 10000.00,
            'gold' => 5000.00,
            'black' => 20000.00,
            default => 5000.00,
        };
    }

    public function calculateAvailableLimit(Card $card): float
    {
        return $card->limit - $card->current_bill;
    }
}
