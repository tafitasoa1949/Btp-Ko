<?php

namespace App\Repositories;

use App\Models\TarifAchat;
use App\Repositories\BaseRepository;

class TarifAchatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'prix_finition',
        'montant_total'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TarifAchat::class;
    }
}
