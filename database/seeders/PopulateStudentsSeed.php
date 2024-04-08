<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PopulateStudentsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Exemplo de criação de registros fictícios na tabela students
        Student::create([
            'id' => 1,
            'name' => 'Fulano de Tal',
            'email' => 'fulano@example.com',
            'date_birth' => '1990-01-01',
            'contact' => '123456789',
            'cpf' => '12345678901',
            'cep' => '12345-678',
            'city' => 'Cidade',
            'neighborhood' => 'Bairro',
            'number' => '123',
            'street' => 'Rua A',
            'state' => 'AA',
            'user_id' => 1,
        ]);

        // Adicione mais registros conforme necessário
    }
}
