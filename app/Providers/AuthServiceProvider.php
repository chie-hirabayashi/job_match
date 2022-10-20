<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('ゲート名', 処理);
        // あるUserモデルにcompanyがあるか確認、あればtrueで許可、なければfalseで非許可
        Gate::define('company', function (User $user)
        {
            return isset($user->company);
        });

        Gate::define('user', function (User $user)
        {
            return !(isset($user->company));
        });
    }
}
