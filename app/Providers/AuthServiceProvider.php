<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les politiques de l'application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
    ];

    /**
     * Enregistrer tous les services d'authentification et autorisation.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Exemple de règle d'autorisation pour vérifier si un utilisateur est admin
        Gate::define('admin-access', function ($user) {
            return $user->hasRole('admin'); // Si tu utilises Spatie pour la gestion des rôles
        });
    }
}
