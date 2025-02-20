<?php
namespace App\Filters;

use Closure;

class Menparler 
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (!request('menparler')) {
            return $next($request);
        }
        $builder = $next($request);
        return $this->applyFilter($builder);
    }
    public function applyFilter($builder) 
    {
       return $builder->where('sg',1)->orWhere('gov',1);
    }
}
