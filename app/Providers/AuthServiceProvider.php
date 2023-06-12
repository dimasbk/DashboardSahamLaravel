<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\PortofolioBeliModel;
use App\Models\PortofolioJualModel;
use App\Models\PostModel;
use App\Models\User;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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
        Gate::define('update-delete-portobeli', function (User $user, PortofolioBeliModel $portoBeli) {
            return $user->id === $portoBeli->user_id;
        });

        Gate::define('update-delete-portojual', function (User $user, PortofolioJualModel $portoJual) {
            return $user->id === $portoJual->user_id;
        });

        Gate::define('update-delete-post', function (User $user, PostModel $post) {
            return $user->id === $post->id_user;
        });
    }
}