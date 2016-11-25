<?php namespace Ixudra\Wizard\Flows\ExampleFlow;


use Ixudra\Wizard\Flows\BaseFlowHandler;
use Ixudra\Wizard\Flows\FlowHandlerInterface;

class FlowHandler extends BaseFlowHandler implements FlowHandlerInterface {

    public function isAllowed($input = array())
    {
        return true;
    }

    protected function getStepsForBreadcrumbs()
    {
        return array(
            'first-step'                    => array(
                'title'                         => 'wizard::flows.exampleFlow.firstStep.breadcrumb',
                'params'                        => array()
            ),
            'second-step'                   => array(
                'title'                         => 'wizard::flows.exampleFlow.secondStep.breadcrumb',
                'params'                        => array()
            ),
        );
    }

}