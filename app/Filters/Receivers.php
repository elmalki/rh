<?php
namespace App\Filters;

class Receivers extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    public function applyFilter($builder)
    {
        return $builder->whereRelation('receivers', fn($q) => $q->whereIn('entity_id',request('receivers')));
    }
}
