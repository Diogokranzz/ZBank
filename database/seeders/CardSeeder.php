<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\User;
use App\Services\CardService;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cardService = new CardService();
        $users = User::all();
        $types = ['platinum', 'gold', 'black'];

        foreach ($users as $user) {
            // Cada usuário recebe 2-3 cartões aleatórios
            $numberOfCards = rand(2, 3);

            for ($i = 0; $i < $numberOfCards; $i++) {
                $type = $types[array_rand($types)];
                $limit = $cardService->getLimitByType($type);

                Card::create([
                    'user_id' => $user->id,
                    'card_number' => $cardService->generateCardNumber(),
                    'card_holder' => strtoupper($user->name),
                    'cvv' => $cardService->generateCvv(),
                    'expiry_date' => $cardService->calculateExpiryDate(),
                    'type' => $type,
                    'limit' => $limit,
                    'current_bill' => rand(0, (int)($limit * 0.7)), // 0-70% do limite usado
                    'is_blocked' => rand(0, 10) > 8, // 20% de chance de estar bloqueado
                ]);
            }
        }
    }
}
