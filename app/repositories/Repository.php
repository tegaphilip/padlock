<?php

namespace App\Repositories;

use App\CInterface\RepositoryInterface;
use App\Models\BaseModel;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Http\Request;

abstract class Repository implements RepositoryInterface
{
    private $config;

    /** @var Request */
    private $request;

    protected static $perPage = 15;

    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $class = $this->modelName();
        $this->model = new $class();
        $this->request = Di::getDefault()->get('request');
        $this->config = Di::getDefault()->get('config');
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    abstract public function modelName();

    /**
     *
     * @return \Phalcon\Mvc\Model\Query\Builder
     */
    public function getQueryBuilder()
    {
        return Di::getDefault()->get('modelsManager')->createBuilder()->addFrom($this->modelName());
    }

    /**
     * Create a new model object
     *
     * @param  array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->add($data);
    }

    /**
     * Update a model
     *
     * @param array $condition
     * @param  array $data
     * @return mixed
     */
    public function update(array $condition, array $data)
    {
        /** @var BaseModel $model */
        if ($model = $this->findOne($condition)) {
            return $model->edit($data);
        }

        return false;
    }

    /**
     * Delete one model by id
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        $field = BaseModel::getPrimaryKeyField($this->model);
        if (empty($field)) {
            return false;
        }

        $model = $this->findOne([$field => $id]);

        return $model ? $model->delete() : false;
    }

    /**
     * Find one or more models by field/value pair
     *
     * @param array $conditions
     * @param null $limit
     * @return mixed
     */
    public function findAll(array $conditions, $limit = null)
    {
        $wildCards = $binds = [];

        $count = 0;
        foreach ($conditions as $key => $value) {
            $wildCards[] = "$key=:" . $count . ":";
            $binds[$count] = $value;
            $count++;
        }

        $wildCards = implode(" AND ", $wildCards);
        $builder = $this->getQueryBuilder();
        $builder->where($wildCards, $binds);
        if (!empty($limit)) {
            $builder->limit($limit);
        }

//        print_r($wildCards);
//        print_r($binds);

        return $builder->getQuery()->execute();
    }

    /**
     * @param array $conditions
     * @return mixed
     */
    public function findOne(array $conditions)
    {
        $results = $this->findAll($conditions, 1);
        return $results->count() === 0 ? null : $results[0];
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $builder = $this->getQueryBuilder();
        return $builder->getQuery()->execute();
    }

    /**
     * @return BaseModel
     */
    public function getModel()
    {
        return $this->model;
    }
}
