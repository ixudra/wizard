ixudra/wizard
=====================

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ixudra/wizard.svg?style=flat-square)](https://packagist.org/packages/ixudra/wizard)
[![license](https://img.shields.io/github/license/ixudra/wizard.svg)]()
[![StyleCI](https://styleci.io/repos/74174078/shield)](https://styleci.io/repos/74174078)
[![Total Downloads](https://img.shields.io/packagist/dt/ixudra/wizard.svg?style=flat-square)](https://packagist.org/packages/ixudra/wizard)

Custom PHP wizard package for the Laravel 5 framework - developed by [Ixudra](http://ixudra.be).

This package can be used by anyone at any given time, but keep in mind that it is optimized for my personal custom workflow. It may not suit your project perfectly and modifications may be in order.



## Installation

Pull this package in through Composer.

```js

    {
        "require": {
            "ixudra/wizard": "2.*"
        }
    }

```

Add the service provider to your `config/app.php` file. 

```php

    'providers'     => array(

        //...
        Ixudra\Wizard\WizardServiceProvider::class,

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

For creating new flows, you can leverage the functionality that is being made available by the `ixudra/generators` package. This package can be used to generate a wide variety of files such as models and controllers, but also offers specific templates that fit hand in glove into this package.

In order to use this functionality, you also need to include the service provider for the `ixudra/generators` package in your `config/app.php` file:


```php

    'providers'     => array(

        //...
        Ixudra\Wizard\WizardServiceProvider::class,
        Ixudra\Generators\GeneratorsServiceProvider::class,

    ),

```


## Usage

The package provides the key building blocks to easily create wizards and flows in your application. The actual flows need to be built in your application and need to follow a specific pattern for them to fit into this mold. In this document I will describe how to create an example flow called `ExampleFlow` which should provide you with enough information on how to create your own. 


### Step 1: Adding the flow routes

Add the flow controller to your routes file with the prefixes and middleware that you require:

```php

    Route::group(array(), function()
    {
        // Flow controller
        Route::get(     'flows/{id}/{step?}',                       array('as' => 'flows.step',                                 'uses' => '\Ixudra\Wizard\Http\Controllers\FlowController@step' ));
        Route::post(    'flows/{id}/{step?}',                       array('as' => 'flows.step.process',                         'uses' => '\Ixudra\Wizard\Http\Controllers\FlowController@processStep' ));
    });

```

These two routes will support all the functionality that you will need for your flows. The routes will support any number of flows and should thus only be added once (unless in certain cases where a different route configuration is needd per flow, e.g. middleware or route prefixes).


### Step 2: Writing the flow migrations

Create a new flow using Laravel migrations. For your convenience, you can copy this time from `Ixudra/Wizard/database/CreateExampleFlows.php` to get a head start.


### Step 3: Creating the flow 

To make a new flow, simply use the following command:

```
    php artisan generate:flow example_flow first_step

```

This will automatically generate all required flow files in the correct folders and fill in the correct variables based on the the parameters passed to the command. The first parameter is the name of the flow, the second parameter is the name of the first flow step that is to be created for this flow. 


### Step 4: Accessing the flow

Once this is done, you are good to go and you can access your flow via the url http://app.dev/flows/1, which will automatically redirect to the first flow step if no specific step is specified. You can add as many flow steps as you want. To add new flow steps, simply add the necessary FlowStepHandler class and step.blade.php file and update the flow information through a migration.

Switching between flow steps is easy. This can be done through GET requests (if no processing is needed) or through POST requests (if processing is needed). 

Some modifications may be in order depending on your setup, but this should provide you with a decent scaffold to speed up your development process.


### Step 5: Adding additional flow steps

To create additional flow steps, you will need to update the flow config in the database using a migration. After that, you need to create a new flow step class as well as a new view that will render the step to the user (if applicable). You can use the following command to automatically create both files for you in the correct locations:

```
    php artisan generate:flow-step example_flow second_step

```


That's all there is to it! Have fun!




## Support

Help me further develop and maintain this package by supporting me via [Patreon](https://www.patreon.com/ixudra)!!




## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)




## Contact

For package questions, bug, suggestions and/or feature requests, please use the Github issue system and/or submit a pull request. When submitting an issue, always provide a detailed explanation of your problem, any response or feedback your get, log messages that might be relevant as well as a source code example that demonstrates the problem. If not, I will most likely not be able to help you with your problem. Please review the [contribution guidelines](https://github.com/ixudra/wizard/blob/master/CONTRIBUTING.md) before submitting your issue or pull request.

For any other questions, feel free to use the credentials listed below: 

Jan Oris (developer)

- Email: jan.oris@ixudra.be
- Telephone: +32 496 94 20 57

