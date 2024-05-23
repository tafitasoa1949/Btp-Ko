<?php

namespace App\Repositories;

use App\Models\SsDetail;
use App\Repositories\BaseRepository;

class SsDetailRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'quantite',
        'pu'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return SsDetail::class;
    }
}
