<?php namespace Ixudra\Wizard\Flows;


interface FlowHandlerInterface {

    /**
     * Determines whether or not a user is allowed to access this particular flow step
     *
     * @param   array $input        Array of input values that are passed along to the request
     * @return  boolean
     */
    public function isAllowed($input = array());

    /**
     * Returns an array of breadcrumbs that can be shown to the user for this flow
     *
     * @param   string $currentStep         Identifier of the currently active flow step
     * @param   array $input                Array of input values that are passed along to the request
     * @return  array
     */
    public function getBreadcrumbs($currentStep, $input = array());

}