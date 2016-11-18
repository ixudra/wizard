<?php namespace Ixudra\Wizard\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App;
use InvalidArgumentException;

class Flow extends Model {

    //- Laravel ---

    protected $guarded = array( 'id' );


    //- Relationships ---



    //- Functions ---

    /**
     * Determines whether or not a user is allowed to access this particular flow step
     * The responsibility for this task is delegated to the appropriate flow step handler to for maximum customisation
     *
     * @param   string $key         Name of the flow step that is selected by the user
     * @param   array $context      Array of values that are passed along to the request
     * @return  boolean
     */
    public function isAllowed($key, $context = array())
    {
        return $this->getFlowHandler()->isAllowed( $context ) && $this->getFlowStepHandler( $key )->isAllowed( $context );
    }

    /**
     * Renders the view associated to the selected flow step to the user
     * The responsibility for this task is delegated to the appropriate flow step handler to for maximum customisation
     *
     * @param   string $key         Name of the flow step that is selected by the user
     * @param   array $input        Array of input values that are passed along to the request
     * @return \Illuminate\Contracts\View\View
     */
    public function render($key, $input)
    {
        return $this->getFlowStepHandler( $key )->render( $this, $input );
    }

    /**
     * Handles the processing of this flow step and redirects the user to the next step in the flow
     * The responsibility for this task is delegated to the appropriate flow step handler to for maximum customisation
     *
     * @param   string $key         Name of the flow step that is selected by the user
     * @param   array $input        Array of input values that are passed along to the request
     * @return \Illuminate\Contracts\View\View
     */
    public function handle($key, $input)
    {
        return $this->getFlowStepHandler( $key )->handle( $this, $input );
    }

    /**
     * @return \Ixudra\Wizard\Flows\BaseFlowHandler
     */
    public function getFlowHandler()
    {
        return App::make( '\Ixudra\Wizard\Flows\\'. Str::studly( $this->name ) .'\FlowHandler', array( $this ) );
    }

    /**
     * @param   string $key         Name of the flow step that is selected by the user
     * @return \Ixudra\Wizard\Flows\BaseFlowStep
     */
    public function getFlowStepHandler($key)
    {
        $steps = json_decode( $this->steps, true );
        if( !array_key_exists( $key, $steps ) ) {
            throw new InvalidArgumentException('Invalid flow step specified: ' . $key);
        }

        return App::make( $steps[ $key ][ 'handler' ] );
    }

    /**
     * @return \Ixudra\Wizard\Flows\BaseFlowStep
     */
    public function getFirstStep()
    {
        $steps = json_decode( $this->steps, true );
        reset($steps);

        return key($steps);
    }

}