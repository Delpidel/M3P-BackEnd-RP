<?php

namespace App\Interfaces;

interface UserRepositoryInterface {
    public function getAll($search);
}
