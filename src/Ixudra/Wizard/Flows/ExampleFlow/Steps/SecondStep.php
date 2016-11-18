<?php namespace Ixudra\Wizard\Flows\ExampleFlow\Steps;


use Ixudra\Wizard\Flows\ExampleFlow\FlowStep;
use Ixudra\Wizard\Flows\FlowStepInterface;
use Ixudra\Wizard\Models\Flow;
use Ixudra\Wizard\Services\Html\FlowViewFactory;

class SecondStep extends FlowStep implements FlowStepInterface {

    protected $view = 'wizard::bootstrap.flows.exampleFlow.secondStep.step';


    public function __construct(FlowViewFactory $flowViewFactory)
    {
        parent::__construct( $flowViewFactory );
    }


    protected function getViewParameters(Flow $flow, array $input = array())
    {
        return array(
            'input'         => $input,
        );
    }

    public function handle(Flow $flow, $input = array())
    {
        return $this->redirect('index', array(), 'success', array('Flow completed!'));
    }


    protected function getTranslationPrefix()
    {
        return 'wizard::flows.exampleFlow.secondStep';
    }

    protected function getBreadcrumbKey()
    {
        return 'second-step';
    }

}