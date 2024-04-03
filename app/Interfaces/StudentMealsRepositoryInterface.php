<?php

namespace App\Interfaces;

interface StudentMealsRepositoryInterface {
    public function getPlans($userId);
    public function getStudentId($userId);
    public function getSchedule($id, $userId);
}
