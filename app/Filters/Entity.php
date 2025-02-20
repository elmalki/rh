<?php

namespace App\Filters;

class Entity extends Filter
{
    public function applyFilter($builder)
    {
        if (request('entity')) {
            if (in_array(request('type'), ['Départ', 'Cheval'])) {
                return $builder->where('sender_id', request('entity'));
            }
            if (in_array(request('type'), ['Arrivé', 'Cheval'])) {
                if (is_int(request('entity')))
                    $ids = \App\Entity::find(request('entity'))->bordereauxReceived->pluck('id');
                else
                    $ids = \App\Entity::find(request('entity')['id'])->bordereauxReceived->pluck('id');
                $builder->whereIn('id', $ids);
            }
        }
        return $builder;
    }
}
