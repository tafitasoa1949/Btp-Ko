<?php

namespace App\Repositories;

use App\Models\DetailTravail;
use App\Repositories\BaseRepository;

class DetailTravailRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nom',
        'pu'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DetailTravail::class;
    }
}
