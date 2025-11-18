<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $transactionTypes = ['pix_sent', 'pix_received', 'payment', 'withdrawal', 'deposit'];
        $descriptions = [
            'pix_sent' => ['Pagamento de conta', 'Transferência para amigo', 'Compra online', 'Pagamento de serviço'],
            'pix_received' => ['Recebimento de venda', 'Transferência recebida', 'Pagamento recebido', 'Reembolso'],
            'payment' => ['Pagamento de fatura', 'Compra no cartão', 'Assinatura mensal', 'Compra em loja'],
            'withdrawal' => ['Saque em caixa eletrônico', 'Saque no banco', 'Retirada de dinheiro'],
            'deposit' => ['Depósito em conta', 'Transferência recebida', 'Salário', 'Rendimento'],
        ];

        foreach ($users as $user) {
            // Cada usuário recebe 10-20 transações
            $numberOfTransactions = rand(10, 20);

            for ($i = 0; $i < $numberOfTransactions; $i++) {
                $type = $transactionTypes[array_rand($transactionTypes)];
                $amount = rand(10, 5000) + (rand(0, 99) / 100); // Valor entre 10.00 e 5000.99
                
                // Define se a transação usa cartão
                $cardId = null;
                if (in_array($type, ['payment']) && $user->cards->count() > 0) {
                    $cardId = $user->cards->random()->id;
                }

                // Define chave PIX para transações PIX
                $recipientKey = null;
                if (in_array($type, ['pix_sent', 'pix_received'])) {
                    $recipientKey = \Illuminate\Support\Str::uuid()->toString();
                }

                // Cria transação com data aleatória nos últimos 90 dias
                $createdAt = Carbon::now()->subDays(rand(0, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

                Transaction::create([
                    'user_id' => $user->id,
                    'card_id' => $cardId,
                    'type' => $type,
                    'amount' => $amount,
                    'description' => $descriptions[$type][array_rand($descriptions[$type])],
                    'recipient_key' => $recipientKey,
                    'status' => rand(0, 10) > 1 ? 'completed' : 'pending', // 90% completed
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
