<?php

namespace App\Interfaces;

interface UserRepositoryInterface {
    public function getAll($search);

    public function find($id);
    public function deactivateUser($user);
    public function delete($user);
}
