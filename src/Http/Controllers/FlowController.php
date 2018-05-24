<?php namespace Ixudra\Wizard\Http\Controllers;


use Illuminate\Http\Request;
use Ixudra\Core\Http\Controllers\BaseController;
use Ixudra\Wizard\Http\Requests\ProcessFlowStepFormRequest;
use Ixudra\Wizard\Models\Flow;
use Ixudra\Wizard\Repositories\Eloquent\EloquentFlowRepository;

use Exception;
use Redirect;
use Translate;
use Config;

class FlowController extends BaseController {

    protected $flowRepository;


    public function __construct(EloquentFlowRepository $flowRepository)
    {
        $this->flowRepository = $flowRepository;
    }


    public function step(Request $request, $id, $step = null)
    {
        /** @var Flow $flow */
        $flow = $this->flowRepository->find( $id );
        if( is_null($flow) ) {
            return $this->notFound( $id );
        }

        if( is_null($step) ) {
            $step = $flow->getFirstStep();
        }

        $input = $request->input();

        if( !$flow->isAllowed( $step, $input ) ) {
            return Redirect::route('index')
                ->with('messageType', 'error')
                ->with('messages', array( Translate::recursive('wizard::flows.errors.notAllowed', array('id' => $id)) ));
        }

        try {
            $response = $flow->render( $step, $input );
        } catch(Exception $e) {
            if( Config::get('app.debug') ) {
                throw $e;
            }

            return Redirect::back()
                ->with('messageType', 'error')
                ->with('messages', array( Translate::recursive('wizard::flows.errors.general', array('id' => $id)) ));
        }

        return $response;
    }

    public function processStep(ProcessFlowStepFormRequest $request, $id, $step)
    {
        /** @var Flow $flow */
        $flow = $this->flowRepository->find( $id );
        if( is_null($flow) ) {
            return $this->notFound( $id );
        }

        $input = $request->getInput();
        unset( $input[ '_token' ] );

        if( !$flow->isAllowed( $step, $input ) ) {
            return Redirect::route('index')
                ->with('messageType', 'error')
                ->with('messages', array( Translate::recursive('wizard::flows.errors.notAllowed', array('id' => $id)) ));
        }

        try {
            $response = $flow->handle( $step, $input );
        } catch(Exception $e) {
            if( Config::get('app.debug') ) {
                throw $e;
            }

            return Redirect::back()
                ->with('messageType', 'error')
                ->with('messages', array( Translate::recursive('wizard::flows.errors.general', array('id' => $id)) ));
        }

        return $response;
    }


    protected function notFound($id)
    {
        return Redirect::route('flows.index')
            ->with('messageType', 'error')
            ->with('messages', array( Translate::recursive('wizard::flows.notFound', array('id' => $id)) ));
    }

}