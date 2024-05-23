<?php

namespace App\Repositories;

use App\Models\Achat;
use App\Repositories\BaseRepository;

class AchatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'datedebut'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Achat::class;
    }
}
