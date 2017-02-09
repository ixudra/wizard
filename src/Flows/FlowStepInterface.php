<?php namespace Ixudra\Wizard\Flows;


use Ixudra\Wizard\Models\Flow;

interface FlowStepInterface {

    /**
     * Determines whether or not a user is allowed to access this particular flow step
     *
     * @param   array $input        Array of input values that are passed along to the request
     * @return  boolean
     */
    public function isAllowed($input = array());

    /**
     * Renders the view associated to this flow step to the user
     *
     * @param   Flow $flow          Flow for which the step is to be rendered
     * @param   array $input        Array of input values that are passed along to the request
     * @return \Illuminate\Contracts\View\View
     */
    public function render(Flow $flow, $input = array());

    /**
     * Handles the processing of this flow step and redirects the user to the next step in the flow
     *
     * @param   Flow $flow          Flow for which the step is to be handled
     * @param   array $input        Array of input values that are passed along to the request
     * @return \Illuminate\Contracts\View\View
     */
    public function handle(Flow $flow, $input = array());

}