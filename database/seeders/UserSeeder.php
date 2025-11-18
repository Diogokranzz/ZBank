<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário de teste principal
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@zbank.com',
            'cpf' => '12345678901',
            'password' => Hash::make('password'),
            'pix_key' => Str::uuid()->toString(),
            'balance' => 5000.00,
        ]);

        // Usuários adicionais
        $users = [
            ['name' => 'Maria Santos', 'email' => 'maria@zbank.com', 'cpf' => '23456789012', 'balance' => 3500.00],
            ['name' => 'Pedro Oliveira', 'email' => 'pedro@zbank.com', 'cpf' => '34567890123', 'balance' => 7200.00],
            ['name' => 'Ana Costa', 'email' => 'ana@zbank.com', 'cpf' => '45678901234', 'balance' => 1500.00],
            ['name' => 'Carlos Souza', 'email' => 'carlos@zbank.com', 'cpf' => '56789012345', 'balance' => 9800.00],
            ['name' => 'Juliana Lima', 'email' => 'juliana@zbank.com', 'cpf' => '67890123456', 'balance' => 4300.00],
            ['name' => 'Roberto Alves', 'email' => 'roberto@zbank.com', 'cpf' => '78901234567', 'balance' => 6100.00],
            ['name' => 'Fernanda Rocha', 'email' => 'fernanda@zbank.com', 'cpf' => '89012345678', 'balance' => 2900.00],
            ['name' => 'Lucas Martins', 'email' => 'lucas@zbank.com', 'cpf' => '90123456789', 'balance' => 8500.00],
            ['name' => 'Patricia Dias', 'email' => 'patricia@zbank.com', 'cpf' => '01234567890', 'balance' => 5700.00],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'cpf' => $userData['cpf'],
                'password' => Hash::make('password'),
                'pix_key' => Str::uuid()->toString(),
                'balance' => $userData['balance'],
            ]);
        }
    }
}
