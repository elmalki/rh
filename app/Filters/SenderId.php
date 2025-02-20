<?php
namespace App\Filters;

class SenderId extends Filter
{
    /**
     * @param $builder
     * @return mixed
     */
    public function applyFilter($builder)
    {
        return $builder->where('sender_id','=',request('sender_id'));
    }
}
