<?php



Route::group(array('prefix' => ''), function()
{
    Route::get(     'flows/{id}/{step?}',                       array('as' => 'flows.step',                                 'uses' => '\Ixudra\Wizard\Http\Controllers\FlowController@step' ));
    Route::post(    'flows/{id}/{step?}',                       array('as' => 'flows.step.process',                         'uses' => '\Ixudra\Wizard\Http\Controllers\FlowController@processStep' ));
});
