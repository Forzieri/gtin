<?php

namespace Mvdnbrk\Gtin;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;

class GtinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'gtin');

        $this->app['validator']->resolver(function ($translator, $data, $rules) {
            return new ValidatorExtension($translator, $data, $rules, [
                'gtin' => $this->getErrorMessage($rules, 'gtin'),
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->offerPublishing();
        $this->registerBlueprintMacros();
    }

    /**
     * Setup the resource publishing.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/gtin'),
            ], 'gtin-lang');
        }
    }

    /**
     * Register the blueprint macros.
     *
     * @return void
     */
    protected function registerBlueprintMacros()
    {
        if ($this->app->runningInConsole()) {
            Blueprint::macro('gtin', function ($column = 'gtin', $length = 14) {
                /* @var \Illuminate\Database\Schema\Blueprint $this */
                return $this->string($column, $length);
            });

            Blueprint::macro('dropGtin', function ($column = 'gtin') {
                /* @var \Illuminate\Database\Schema\Blueprint $this */
                return $this->dropColumn($column);
            });
        }
    }

    /**
     * Return the matching error message for the key.
     *
     * @param  array  $rules
     * @param  string  $key
     * @return string
     */
    private function getErrorMessage($rules, $key)
    {
        return collect($this->getPackageDefaultErrorMessage($key))
            ->merge($this->getValidationErrorMessage($key))
            ->merge(
                collect($rules)->map(function ($rule, $attribute) use ($key) {
                    return $this->getCustomErrorMessage($attribute, $key);
                })->filter()
            )
            ->last();
    }

    /**
     * Get the default error message for a given key.
     *
     * @param  string  $rule
     * @return string
     */
    private function getPackageDefaultErrorMessage($rule)
    {
        return Lang::get("gtin::validation.{$rule}");
    }

    /**
     * Get the validation error message for a given key.
     *
     * @param  string  $rule
     * @return string|null
     */
    private function getValidationErrorMessage($rule)
    {
        return collect(Lang::get("validation.{$rule}"))
            ->reject("validation.{$rule}")
            ->first();
    }

    /**
     * Get the custom error message for a given key.
     *
     * @param  string  $attribute
     * @param  string  $rule
     * @return string|null
     */
    private function getCustomErrorMessage($attribute, $rule)
    {
        return collect(Lang::get("validation.custom.{$attribute}.{$rule}"))
            ->reject("validation.custom.{$attribute}.{$rule}")
            ->first();
    }
}
