<?php

namespace App\Repositories;

use App\Models\Paiement;
use App\Repositories\BaseRepository;

class PaiementRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'montant',
        'date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Paiement::class;
    }
}
