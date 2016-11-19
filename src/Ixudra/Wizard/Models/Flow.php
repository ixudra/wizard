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
     * Return the configuration for this group purchase
     *
     * @param   string      $key    Name of the configuration value to be extracted in dot notation
     * @return mixed
     */
    public function getConfig($key = '')
    {
        $config = json_decode($this->config, true);
        if( empty($key) ) {
            return $config;
        }

        return array_get( $config, $key );
    }

    /**
     * @return \Ixudra\Wizard\Flows\BaseFlowHandler
     */
    public function getFlowHandler()
    {
        return App::make( $this->getConfig('handler'), array( $this ) );
    }

    /**
     * @param   string $key         Name of the flow step that is selected by the user
     * @return \Ixudra\Wizard\Flows\BaseFlowStep
     */
    public function getFlowStepHandler($key)
    {
        $flowStepHandler = $this->getConfig('steps.' . $key . '.handler');
        if( empty($flowStepHandler) ) {
            throw new InvalidArgumentException('Invalid flow step specified: '. $key);
        }

        return App::make( $flowStepHandler );
    }

    /**
     * @return \Ixudra\Wizard\Flows\BaseFlowStep
     */
    public function getFirstStep()
    {
        $steps = $this->getConfig('steps');
        reset($steps);

        return key($steps);
    }

}