<?php

namespace App\Providers;

use App\Models\Cache\Interfaces\PatientCacheInterface;
use App\Models\Cache\PatientCache;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\PatientRepository;
use App\Services\Interfaces\PatientServiceInterface;
use App\Services\PatientService;
use Illuminate\Support\ServiceProvider;

class PatientServiceProvider extends ServiceProvider
{

    public $bindings = [
        PatientRepositoryInterface::class => PatientRepository::class,
        PatientServiceInterface::class => PatientService::class,
        PatientCacheInterface::class => PatientCache::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
