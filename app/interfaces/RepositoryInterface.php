<?php

namespace App\CInterface;

interface RepositoryInterface
{
    public function all();

    /**
     * Create a new model object
     *
     * @param  array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a model
     *
     * @param array $condition
     * @param  array $data
     * @return mixed
     */
    public function update(array $condition, array $data);

    /**
     * Delete one model by id
     *
     * @param  int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find a model or some models based on one or more conditions
     *
     * @param array $conditions
     * @param int|null $limit
     * @return mixed
     */
    public function findAll(array $conditions, $limit = null);

    public function findOne(array $conditions);
}
