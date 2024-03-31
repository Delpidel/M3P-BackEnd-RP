<?php

namespace App\Interfaces;

interface StudentRepositoryInterface
{
    public function createOne(array $data);
    public function search($name, $email, $cpf);
}