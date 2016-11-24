<?php namespace Ixudra\Wizard\Flows;


use Illuminate\Http\RedirectResponse;
use Ixudra\Core\Traits\RedirectableTrait;
use Ixudra\Wizard\Services\Html\FlowViewFactory;
use Ixudra\Wizard\Models\Flow;

use Redirect;

abstract class BaseFlowStep {

    use RedirectableTrait;


    /** @var FlowViewFactory */
    protected $flowViewFactory;


    public function __construct(FlowViewFactory $flowViewFactory)
    {
        $this->flowViewFactory = $flowViewFactory;
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
     * Renders the view associated to the current flow step to the user
     *
     * @param   Flow $flow                      Current flow
     * @param   array $parameters               Array of parameters that are passed along to the view
     * @return \Illuminate\Contracts\View\View
     */
    protected function renderView(Flow $flow, $parameters = array())
    {
        $parameters[ 'flow' ] = $flow;

        return $this->flowViewFactory->renderStep( $this->view, $parameters);
    }

    /**
     * Returns an array of validation rules that apply to the current flow step
     *
     * @param   array $input        Array of input values that are passed along to the request
     * @return  array
     */
    public function getRules($input = array())
    {
        return array();
    }

    /**
     * Returns an array of input values that are passed along to the request after pre-processing
     *
     * @param   array $input        Array of input values that are passed along to the request
     * @return  array
     */
    public function getInput($input = array())
    {
        return $input;
    }

    /**
     * Returns an array of custom error messages that are to be used when validating the request input
     *
     * @param   array $input        Array of input values that are passed along to the request
     * @return  array
     */
    public function getMessages($input = array())
    {
        return array();
    }

    /**
     * Redirects the user back to the previous flow step with the input values provided for the user and a warning message
     *
     * @param   array $input            Array of input values that are passed along to the request
     * @param   string $messageType     Type of warning that is to be given to the user
     * @param   array $messages         Array of messages that are to be sent to the user
     * @return  RedirectResponse
     */
    protected function back($input = array(), $messageType = '', $messages = array())
    {
        return Redirect::back()
            ->with( 'messageType', $messageType )
            ->with( 'messages', $messages )
            ->withInput( $input );
    }

    /**
     * Redirects the user back to the next flow step with the input values provided for the user and a warning message
     *
     * @param   Flow $flow          Current flow
     * @param   string $step        Flow step to which the user is to be redirected
     * @param   array $input        Array of input values that are passed along to the request
     * @return  RedirectResponse
     */
    protected function next(Flow $flow, $step, $input = array())
    {
        return $this->redirect( 'flows.step', array( $flow->id, $step ) + $input );
    }

    /**
     * Returns the translation prefix for this flow step
     *
     * @return  string
     */
    abstract protected function getTranslationPrefix();

    /**
     * Returns the active breadcrumb for this flow step
     *
     * @return  string
     */
    abstract protected function getBreadcrumbKey();

}