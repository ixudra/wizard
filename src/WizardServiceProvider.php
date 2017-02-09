<?php namespace Ixudra\Wizard;


use Illuminate\Support\ServiceProvider;

class WizardServiceProvider extends ServiceProvider {

    protected $defer = false;


    public function register()
    {
        // ...
    }

    public function boot()
    {
        $this->loadTranslationsFrom( __DIR__ .'/resources/lang', 'wizard' );
        $this->loadViewsFrom( __DIR__ .'/resources/views', 'wizard' );


        // Publish language files
        $this->publishes(array(
            __DIR__ .'/resources/lang'                  => base_path('resources/lang'),
        ), 'lang');


        // Publish views
        $this->publishes(array(
            __DIR__ .'/resources/views'                 => base_path('resources/views/bootstrap'),
        ), 'views');


        // Publish migrations
        $this->publishes(array(
            __DIR__ .'/database/migrations/'            => base_path('database/migrations')
        ), 'migrations');
    }

    public function provides()
    {
        return array('wizard');
    }

}
