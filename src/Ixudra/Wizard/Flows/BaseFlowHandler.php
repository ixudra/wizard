<?php namespace Ixudra\Wizard\Flows;


use Ixudra\Wizard\Models\Flow;

use stdClass;

abstract class BaseFlowHandler implements FlowHandlerInterface {

    /** @var  Flow $flow */
    protected $flow;


    public function __construct(Flow $flow)
    {
        $this->flow = $flow;
    }


    /**
     * Determines whether or not a user is allowed to access this particular flow step
     *
     * @param   array $input        Array of input values that are passed along to the request
     * @return  boolean
     */
    public function isAllowed($input = array())
    {
        return true;
    }

    /**
     * Returns an array of breadcrumbs that can be shown to the user for this flow
     *
     * @param   string $currentStep         Identifier of the currently active flow step
     * @param   array $input                Array of input values that are passed along to the request
     * @return  array
     */
    public function getBreadcrumbs($currentStep, $input = array())
    {
        return array();
    }

    /**
     * Return an empty breadcrumb
     *
     * @param   string $name        Name of the flow step for which the breadcrumb is to be generated
     * @return  stdClass
     */
    protected function getEmptyBreadcrumb($name)
    {
        $breadcrumb = new stdClass();
        $breadcrumb->title = '';
        $breadcrumb->class = '';
        $breadcrumb->getParameters = array( $this->flow->id, $name );
        $breadcrumb->isOptional = false;

        return $breadcrumb;
    }

}