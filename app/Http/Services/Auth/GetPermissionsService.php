<?php

namespace App\Http\Services\Auth;

class GetPermissionsService
{
    private $permissions = [
        'ADMIN' => [
            'create-users',
            'get-users',
            'delete-users',
            'update-users',
            'get-dashboard',
        ],
        'RECEPCIONISTA' => [
            'create-students',
            'get-students',
            'delete-students',
            'update-students',
            'create-documents-students',
            'get-documents-students',
            'get-avaliations'
        ],
        'INSTRUTOR' => [
            'instrutor-dashboard',
            'create-exercises',
            'get-exercises',
            'delete-exercises',
            'get-students',
            'create-workouts',
            'get-workouts',
            'delete-workouts',
            'update-workouts'
        ],
        'NUTRICIONISTA' => [
            'create-avaliations',
            'get-actives-students',
            'get-avaliations',
            'create-meal-plans',
            'get-meal-plans',
            'delete-meal-plans',
            'update-meal-plans',
            'get-students'
        ],
        'ALUNO' => [
            'get-workout',
            'get-meal-plans'
        ]
    ];

    public function handle($profileName)
    {
        return $this->permissions[$profileName] ?? [];
    }
}
