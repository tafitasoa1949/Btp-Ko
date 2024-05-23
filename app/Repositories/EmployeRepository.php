<?php

namespace App\Repositories;

use App\Models\Employe;
use App\Repositories\BaseRepository;

class EmployeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nom'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Employe::class;
    }
}
