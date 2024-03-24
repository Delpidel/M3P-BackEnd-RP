<?php

namespace App\Http\Services;

class PaginationInstructorService
{
    public function paginate($query, int $perPage = 10, $columns = ['*'])
    {
        return $query->paginate($perPage, $columns);
    }
}
