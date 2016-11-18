<?php namespace Ixudra\Wizard\Services\Html;


use Ixudra\Core\Services\Html\BaseViewFactory;

class FlowViewFactory extends BaseViewFactory {

    public function renderStep($view, $parameters)
    {
        $this->addParameterMap( $parameters );

        return $this->makeView( $view );
    }

}
