<?php

/**
 * Class BaseDB
 *
 * Class to handle main crud database functions
 *
 * @author José Loguercio <jloguercio@loggux.com>
 * @copyright Copyright (c) 2016, Loggux.com Internet Services
 *
 * @package Models
 */
class Model {

    /**
     * Class BaseDB constants
     */
    const STARTS = 'starts';
    const ENDS = 'ends';
    const BOTH = 'both';

    /**
     * Find a row by id
     *
     * @access public
     * @param int $id
     * @return array $rows
     */
    public function find($id) {
        return Database::findBy(get_class($this), ['id' => $id], [], 'First');
    }

    /**
     * Find by criteria
     *
     * @access public
     * @param array $criteria
     * @param array $orders
     * @return array $rows
     */
    public function findBy($criteria, $orders = []) {
        return Database::findBy(get_class($this), $criteria, $orders, 'All');
    }

    /**
     * Find One row by criteria
     *
     * @access public
     * @param array $criteria
     * @param array $orders
     * @return array $rows
     */
    public function findOneBy($criteria, $orders = []) {
        return Database::findBy(get_class($this), $criteria, $orders, 'First');
    }

    /**
     * Find all rows
     *
     * @access public
     * @param array $orders
     * @return array $rows
     */
    public function findAll($orders = []) {
        return Database::findAll(get_class($this), $orders);
    }

    /**
     * Search Like pattern
     *
     * @access public
     * @param $pattern
     * @param $orders
     * @return array $rows
     */
    public function searchLike($pattern = [], $orders = []) {
        return Database::searchLike(get_class($this), $pattern, $orders);
    }

    /**
     * Insert a row
     *
     * @return mixed
     */
    public function insert() {
        return Database::insert(get_class($this), get_object_vars($this));
    }

    /**
     * Update a row(s)
     *
     * @param array $criteria
     * @return mixed
     */
    public function update($criteria = []) {
        return Database::update(get_class($this), get_object_vars($this), $criteria);
    }

    /**
     * Update a row(s)
     *
     * @param array $criteria
     * @return mixed
     */
    public function delete($criteria = []) {
        return Database::delete(get_class($this), $criteria);
    }

    /**
     * objectIterativeSearch
     *
     * @param $request
     * @return mixed | boolean | object
     */
    public function objectIterativeSearch($request)
    {
        $request = trim($request);

        foreach ($this as $property => $value) {
            if (like_match('%' . $request . '%', $value)) {
                return $this;
            } else if (like_match('%' . $request, $value)) {
                return $this;
            } else if (like_match($request . '%', $value)) {
                return $this;
            }
        }

        return false;
    }
}