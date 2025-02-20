<?php
namespace App\Filters;

class NEnregistrement extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    public function applyFilter($builder)
    {
        return $builder->where('n_enregistrement','=',request('n_enregistrement'));
    }
}
