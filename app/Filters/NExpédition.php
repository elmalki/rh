<?php
namespace App\Filters;


class NExpédition  extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    public function applyFilter($builder)
    {
        return $builder->where($this->filterName(),request($this->filterName()));
    }
}
