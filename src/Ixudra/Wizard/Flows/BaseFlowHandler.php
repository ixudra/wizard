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
     * Returns an array of breadcrumbs of all flow steps up to the currently active flow step
     *
     * @param   string $currentStep         Identifier of the currently active flow step
     * @param   array $input                Array of input values that are passed along to the request
     * @return  array
     */
    public function getBreadcrumbs($currentStep, $input = array())
    {
        $breadcrumbs = $this->getStepsForBreadcrumbs();

        array_walk(
            $breadcrumbs,
            function (&$item, $key) use ($input) {
                $breadcrumb = $this->getEmptyBreadcrumb($key);
                $breadcrumb->title = trans($item[ 'title' ]);
                foreach( $item[ 'params' ] as $name ) {
                    if( array_key_exists($name, $input) ) {
                        $breadcrumb->getParameters[ $name ] = $input[ $name ];
                    }
                }

                $item = $breadcrumb;
            }
        );

        $position = array_search($currentStep, array_keys($breadcrumbs));
        if ($position !== false) {
            array_splice($breadcrumbs, ($position + 1));
        }

        $breadcrumbs[ $currentStep ]->class = 'active';

        return $breadcrumbs;
    }

    /**
     * Returns an array of all available breadcrumbs that can be shown to the user for this flow
     *
     * @return  array
     */
    abstract protected function getStepsForBreadcrumbs();

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