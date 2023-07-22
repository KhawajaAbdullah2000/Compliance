<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('unique_combination', function ($attribute, $value, $parameters, $validator) {
            $table = $parameters[0];
            $currentOrganizationName = $validator->getData()['name'];
            $currentDepartment = $validator->getData()['sub_org'];

            $count = DB::table($table)
                ->where('name', $currentOrganizationName)
                ->where('sub_org', $currentDepartment)
                ->where(function ($query) use ($attribute, $value) {
                    $query->where($attribute, '!=', $value);
                })
                ->count();

            return $count === 0;
        });
    }
    
}
