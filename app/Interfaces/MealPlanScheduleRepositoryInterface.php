<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface MealPlanScheduleRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}


