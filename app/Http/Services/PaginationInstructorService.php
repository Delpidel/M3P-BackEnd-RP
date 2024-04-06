<?php

namespace App\Http\Services;

class PaginationInstructorService
{
    public function paginate($query, int $perPage = 20, $columns = ['*'])
    {
        return $query->paginate($perPage, $columns);
    }
}
