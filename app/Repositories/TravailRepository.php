<?php

namespace App\Repositories;

use App\Models\Travail;
use App\Repositories\BaseRepository;

class TravailRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'code',
        'nom'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Travail::class;
    }
}
