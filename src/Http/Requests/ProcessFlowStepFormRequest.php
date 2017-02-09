<?php namespace Ixudra\Wizard\Http\Requests;


use Ixudra\Core\Http\Requests\BaseRequest;
use Ixudra\Wizard\Models\Flow;
use Ixudra\Wizard\Repositories\Eloquent\EloquentFlowRepository;

use App;
use InvalidArgumentException;

class ProcessFlowStepFormRequest extends BaseRequest {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        /** @var Flow $flow */
        $flow = App::make( EloquentFlowRepository::class )->find( $this->route( 'id' ) );
        if( is_null($flow) ) {
            throw new InvalidArgumentException('Flow not found');
        }

        $flowStepHandler = $flow->getFlowStepHandler( $this->route('step') );

        return $flowStepHandler->getRules( $flowStepHandler->getInput( $this->getInput() ) );
    }

    public function getInput($includeFiles = false)
    {
        $input = parent::getInput( $includeFiles );

        /** @var Flow $flow */
        $flow = App::make( EloquentFlowRepository::class )->find( $this->route( 'id' ) );
        if( is_null($flow) ) {
            throw new InvalidArgumentException('Flow not found');
        }

        return $flow->getFlowStepHandler( $this->route('step') )->getInput( $input );
    }

    public function messages()
    {
        /** @var Flow $flow */
        $flow = App::make( EloquentFlowRepository::class )->find( $this->route( 'id' ) );
        if( is_null($flow) ) {
            throw new InvalidArgumentException('Flow not found');
        }

        $flowStepHandler = $flow->getFlowStepHandler( $this->route('step') );

        return $flowStepHandler->getMessages( $flowStepHandler->getInput( $this->getInput() ) );
    }

}