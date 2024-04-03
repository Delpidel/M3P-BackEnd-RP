<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface MealPlanScheduleServiceInterface
{
    public function getAll();
    public function findById($id);
    public function create(Request $request);
    public function update($id, Request $request);
    public function delete($id);
}


