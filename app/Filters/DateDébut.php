<?php
namespace App\Filters;

use Carbon\Carbon;
use Closure;

class DateDébut
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (!request('dateDébut')) {
            return $next($request);
        }
        $builder = $next($request);
        return $this->applyFilter($builder);
    }
    public function applyFilter($builder)
    {
       return $builder->whereDate('sentReceivedDate', '>=',Carbon::parse(request('dateDébut'))->addDay()->format('Y-m-d'));
    }
}
