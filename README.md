ixudra/flow
=====================

Custom PHP flow package for the Laravel 5 framework - developed by [Ixudra](http://ixudra.be).

This package can be used by anyone at any given time, but keep in mind that it is optimized for my personal custom workflow. It may not suit your project perfectly and modifications may be in order.



## Installation

Pull this package in through Composer.

```js

    {
        "require": {
            "ixudra/flow": "1.*"
        }
    }

```

Add the service provider to your `config/app.php` file. Additionally, you will also need to include the service providers of the package dependencies:

```php

    providers     => array(

        //...
        'Ixudra\Flow\FlowServiceProvider',

    ),

```

Run package migrations using artisan:

```php

    php artisan migrate --package="ixudra/wizard"

```

Alternatively, you can also publish the migrations using artisan:

```php

    // Publish all resources from all packages
    php artisan vendor:publish
    
    // Publish only the resources of the package
    php artisan vendor:publish --provider="Ixudra\\Wizard\\WizardServiceProvider"
    
    // Or publish one resource of the package resources at a time
    php artisan vendor:publish --provider="Ixudra\\Wizard\\WizardServiceProvider" --tag="migrations"
    php artisan vendor:publish --provider="Ixudra\\Wizard\\WizardServiceProvider" --tag="views"
    php artisan vendor:publish --provider="Ixudra\\Wizard\\WizardServiceProvider" --tag="lang"

```


## Usage

The package provides the key building blocks to easily create wizards and flows in your application. The actual flows need to be built in your application and need to follow a specific pattern for them to fit into this mold. In this document I will describe how to create an example flow called `ExampleFlow` which should provide you with enough information on how to create your own. 

Add the flow controller to your routes file with the prefixes and middleware that you require

```php

    Route::group(array(), function()
    {
        // Flow controller
        Route::get(     'flows/{id}/{step?}',                       array('as' => 'flows.step',                                 'uses' => '\Ixudra\Wizard\Http\Controllers\FlowController@step' ));
        Route::post(    'flows/{id}/{step?}',                       array('as' => 'flows.step.process',                         'uses' => '\Ixudra\Wizard\Http\Controllers\FlowController@processStep' ));
    });

```

Create a new directory for your flow in your app directory

```

    mkdir appRoot/app/Flows
    mkdir appRoot/app/Flows/ExampleFlow
    mkdir appRoot/app/Flows/ExampleFlow/Steps

```

Create a new flow through migrations. For your convenience, you can copy this time from `Ixudra/Wizard/database/CreateExampleFlows.php` to get a head start.

Create a `App\Flows\ExampleFlow\FlowHandler` class that extends the `Ixudra\Wizard\Flows\BaseFlowHandler` class and place it in the `appRoot/app/flows/ExampleFlow` directory. Implement the abstract methods and override the existing ones to match your specific situation. For your convenience, you can copy this file from `Ixudra/Wizard/Flows/ExampleFlow/FlowHandler` to get a head start.

Create a `App\Flows\ExampleFlow\FlowStep` class that extends the `Ixudra\Wizard\Flows\BaseFlowHandler` class and place it in the `appRoot/app/flows/ExampleFlow` directory. Implement the abstract methods and override the existing ones to match your specific situation. For your convenience, you can copy this file from `Ixudra/Wizard/Flows/ExampleFlow/FlowStep` to get a head start.

Create a new `App\Flows\ExampleFlow\Steps\FirstStep` class that extends the `App\Flows\ExampleFlow\FlowStep` class and place it in the `appRoot/app/flows/ExampleFlow/steps` directory. Implement the abstract methods and override the existing ones to match your specific situation. For your convenience, you can copy this file from `Ixudra/Wizard/Flows/ExampleFlow/Steps/FirstStep` to get a head start. This will be the first step that will be shown when accessing the flow through your routes. The path of the flow step must match the path that was specified in your migration file.

Create a new view called `step.php` and place it in the `appRoot/recources/flows/exampleFlow/firstStep/step.blade.php` directory. For your convenience, you can copy this file from `Ixudra/Wizard/resources/views/bootstrap/flows/exampleFlow/firstStep/step.blade.php` to get a head start.

Once this is done, you are good to go and you can access your flow via the url `http://app.dev/flows/1`, which will automatically redirect to the first flow step if no specific step is specified. You can add as many flow steps as you want. To add new flow steps, simply add the necessary `FlowStepHandler` class and `step.blade.php` file and update the flow information through a migration.

Switching between flow steps is easy. This can be done through GET requests (if no processing is needed) or through POST requests (if processing is needed). 


That's all there is to it! Have fun!



## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)




## Contact

Jan Oris (developer)

- Email: jan.oris@ixudra.be
- Telephone: +32 496 94 20 57

