<?php
namespace App\Filters;

class Objet  extends Filter
{
    public function applyFilter($builder)
    {
       return $builder->where($this->filterName(),'like','%'.request($this->filterName()).'%');
    }
}
