<?php namespace Ixudra\Wizard\Flows\ExampleFlow;


use Ixudra\Wizard\Flows\BaseFlowHandler;
use Ixudra\Wizard\Flows\FlowHandlerInterface;

class FlowHandler extends BaseFlowHandler implements FlowHandlerInterface {

    public function isAllowed($input = array())
    {
        return true;
    }

    public function getBreadcrumbs($currentStep, $input = array())
    {
        $breadcrumbs = [
            'first-step'                    => array(
                'title'                         => 'wizard::flows.exampleFlow.firstStep.breadcrumb',
                'params'                        => array()
            ),
            'second-step'                   => array(
                'title'                         => 'wizard::flows.exampleFlow.secondStep.breadcrumb',
                'params'                        => array()
            ),
        ];

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

        $breadcrumbs[$currentStep]->class = 'active';

        return $breadcrumbs;
    }

}