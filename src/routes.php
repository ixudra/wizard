<?php



Route::group(array('prefix' => ''), function()
{
    Route::get(     'flows/{id}/{step?}',                       array('as' => 'flows.step',                                 'uses' => 'FlowController@step' ));
    Route::post(    'flows/{id}/{step?}',                       array('as' => 'flows.step.process',                         'uses' => 'FlowController@processStep' ));
});
