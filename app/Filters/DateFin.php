<?php
namespace App\Filters;

use Carbon\Carbon;
use Closure;

class DateFin
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (!request('dateFin')) {
            return $next($request);
        }
        $builder = $next($request);
        return $this->applyFilter($builder);
    }
    public function applyFilter($builder)
    {
      return $builder->whereDate('sentReceivedDate', '<=',Carbon::parse(request('dateFin'))->addDay()->format('Y-m-d'));
    }
}
