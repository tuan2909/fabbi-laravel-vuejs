<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\City;
use App\Models\HealthPatient;
use App\Models\Patient;
use App\Models\QuarantinePatient;
use App\Models\Specimen;
use App\Models\TypePatient;

use App\Repositories\User\UserRepository as CUser;
use App\Repositories\City\CityRepository as CCity;
use App\Repositories\HealthPatient\HealthPatientRepository as CHealthPatient;
use App\Repositories\Patient\PatientRepository as CPatient;
use App\Repositories\QuarantinePatient\QuarantinePatientRepository as CQuarantinePatient;
use App\Repositories\Specimen\SpecimenRepository as CSpecimen;
use App\Repositories\TypePatient\TypePatientRepository as CTypePatient;

use App\Repositories\City\EloquentCityRepository as ECity;
use App\Repositories\HealthPatient\EloquentHealthPatientRepository as EHealthPatient;
use App\Repositories\Patient\EloquentPatientRepository as EPatient;
use App\Repositories\QuarantinePatient\EloquentQuarantinePatientRepository as EQuarantinePatient;
use App\Repositories\Specimen\EloquentSpecimenRepository as ESpecimen;
use App\Repositories\TypePatient\EloquentTypePatientRepository as ETypePatient;
use App\Repositories\User\EloquentUserRepository as EUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRepository();
    }

    private function loadRepository()
    {
        $this->app->bind(CUser::class, function () {
            return new EUser(new User());
        });
        $this->app->bind(CCity::class, function () {
            return new ECity(new City());
        });
        $this->app->bind(CHealthPatient::class, function () {
            return new EHealthPatient(new HealthPatient());
        });
        $this->app->bind(CPatient::class, function () {
            return new EPatient(new Patient());
        });
        $this->app->bind(CQuarantinePatient::class, function () {
            return new EQuarantinePatient(new QuarantinePatient());
        });
        $this->app->bind(CSpecimen::class, function () {
            return new ESpecimen(new Specimen());
        });
        $this->app->bind(CTypePatient::class, function () {
            return new ETypePatient(new TypePatient());
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
