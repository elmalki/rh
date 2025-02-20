<?php
namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
       // Bordereau::class => BordereauPolicy::class,
    ];

    public function boot()
    {
        Gate::before(function (User $user, string $ability) {
            if ($user->type=='admin') {
                return true;
            }
        });
        $this->registerPolicies();
    }
}
