<?php namespace Ixudra\Wizard\Repositories\Eloquent;


use Ixudra\Core\Repositories\Eloquent\BaseEloquentRepository;
use Ixudra\Wizard\Models\Flow;

class EloquentFlowRepository extends BaseEloquentRepository {

    protected function getModel()
    {
        return new Flow;
    }

    protected function getTable()
    {
        return 'flows';
    }

    public function findByName($name)
    {
        return $this->getModel()->where('name', '=', $name)->first();
    }

}