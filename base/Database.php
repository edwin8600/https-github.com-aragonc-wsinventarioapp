<?php

/**
 * Class Database
 *
 * Class for connect to the database and handle the basic crud statements
 *
 * @author José Loguercio <jloguercio@loggux.com>
 * @copyright Copyright (c) 2016, Loggux.com Internet Services
 *
 * @package Base.database
 */
class Database
{

    /**
     * Connect to the main DB function
     *
     * @return mixed conexión object | string msg error
     */
    public static function Connect()
    {
        try {
            $user = 'root';
            $password = 'Gamelord123';
            $host =  'localhost';
            $dbname = 'inventario';
            $conexion = new PDO(
                "mysql:host=$host;
                dbname=$dbname;",
                $user,
                $password,
                [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
            );

            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;
        } catch (PDOException $e) {
            return 'Error - ' . $e->getMessage();
        }
    }

    /**
     * Find all rows, simple select database statement
     *
     * @param string $class
     * @param array $orders
     * @return mixed class object
     */
    public static function findAll($class, $orders)
    {
        try {

            // Connect to the database.
            $connection = self::Connect();

            // Convert the class passed by parameter to a table name
            $table = to_under_score($class);

            $sorts = '';
            $counter = 0;

            // Parse orders for query sort
            foreach ($orders as $attr => $sort) {
                $sorts = "$attr $sort";
                $counter++;
                if (count($orders) !== $counter ) {
                    $sorts .= ", ";
                }
            }

            // Start query process
            $sql = "SELECT * FROM $table $sorts";
            $query = $connection->prepare($sql);
            $query->execute();

            // Fetch the Class Object
            $query->setFetchMode(PDO::FETCH_CLASS, $class);
            $rows = $query->fetchAll();

            return $rows;
        } catch (PDOException $e) {
            return 'Error - ' . $e->getMessage();
        }
    }

    /**
     * Conditional find by criteria, select database statement
     *
     * @param string $class
     * @param array $criteria
     * @param array $orders
     * @param string $rowShow
     * @return mixed class object
     */
    public static function findBy($class, $criteria, $orders = [], $rowShow = 'First')
    {
        try {

            // First, needs to validate all the params
            if (!validate_params($class, $criteria)) {
                return false;
            }

            // Connect to the database.
            $connection = self::Connect();

            // Convert the class passed by parameter to a table name
            $table = to_under_score($class);

            // Some vars init
            $condition = '';
            $counter = 0;

            $params = [];

            // Parse criteria for query condition
            foreach ($criteria as $attr => $value) {
                $checker = check_db_query_flag($value);

                if ($checker) {

                    $condition .= "$attr {$checker[0]} :$attr";
                    $params[$attr] = $checker[1];
                } else {

                    $condition .= "$attr = :$attr";
                    $params[$attr] = $value;
                }
                $counter++;
                if (count($criteria) !== $counter ) {
                    $condition .= " AND ";
                }
            }

            $sorts = '';
            $counter = 0;

            // Parse orders for query sort
            foreach ($orders as $attr => $sort) {
                $sorts = "$attr $sort";
                $counter++;
                if (count($orders) !== $counter ) {
                    $sorts .= ", ";
                }
            }

            // Start query process
            $sql = "SELECT * FROM $table WHERE $condition $sorts";

            $query = $connection->prepare($sql);
            $query->execute($params);

            // Fetch the Class Object
            $query->setFetchMode(PDO::FETCH_CLASS, $class);

            // Check rows count and return it
            $rowCount = $query->rowCount();

            if ($rowCount > 1 || $rowShow == 'All') {

                $rows = [];

                while ($result = $query->fetch()) {
                    $rows[] = $result;
                }

                return $rows;
            } else if($rowCount <= 1 || $rowShow == 'First') {
                return $query->fetch();
            }

        } catch (PDOException $e) {
            return 'Error - ' . $e->getMessage();
        }
    }

    /**
     * Insert database statement
     *
     * @param string $class
     * @param array $values
     * @return mixed Database response
     */
    public static function insert($class, $values)
    {
        try {

            // First, needs to validate all the params
            if (!validate_params($class, $values)) {
                return false;
            }

            // Connect to the database.
            $connection = self::Connect();

            // Convert the class passed by parameter to a table name
            $table = to_under_score($class);
            // Get the set values and handle pre set nulls
            $values = array_filter($values, 'is_not_null');
            $fields = '';
            $vals = '';
            foreach ($values as $index => $value) {
                $fields .= "$index, ";
                $vals .= ":$index, ";
                $values[$index] = $values[$index] !== SET_NULL ? $value : null;
            }
            $fields = substr($fields, 0, -2);
            $vals = substr($vals, 0, -2);

            // Start query process
            $sql = "INSERT INTO $table ($fields) VALUES ($vals)";
            $query = $connection->prepare($sql);
            $query->execute($values);
            $result = $connection->lastInsertId();

            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update row(s) database statement
     *
     * @param string $class
     * @param array $params
     * @param array $criteria
     * @return mixed Database response
     */
    public static function update($class, $params, $criteria)
    {
        try {

            // First, needs to validate all the params
            if (!validate_params($class, $params, $criteria)) {
                return false;
            }

            // Connect to the database.
            $connection = self::Connect();

            // Convert the class passed by parameter to a table name
            $table = to_under_score($class);
            // Get the set values and handle pre set nulls
            $params = array_filter($params, 'is_not_null');
            $placeholder = '';
            foreach ($params as $index => $value) {
                $placeholder .= "$index = :$index, ";
                $params[$index] = $params[$index] !== SET_NULL ? $value : null;
            }
            $placeholder = substr($placeholder, 0, -2);

            // Parse criteria for query condition
            $condition = '';
            $counter = 0;
            foreach ($criteria as $attr => $value) {

                $checker = check_db_query_flag($value);

                if ($checker) {

                    $condition .= "$attr {$checker[0]} :$attr";
                    $params[$attr] = $checker[1];
                } else {

                    $condition .= "$attr = :$attr";
                    $params[$attr] = $value;
                }

                $counter++;
                if (count($criteria) !== $counter ) {
                    $condition .= " AND ";
                }
            }

            // Start query process
            $sql = "UPDATE $table SET $placeholder WHERE $condition";
            $query = $connection->prepare($sql);
            $result = $query->execute($params);

            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Find all rows, simple select database statement
     *
     * @param string $class
     * @param array $criteria
     * @return mixed class object
     */
    public static function delete($class, $criteria)
    {
        try {

            // First, needs to validate all the params
            if (!validate_params($class, $criteria)) {
                return false;
            }

            // Connect to the database.
            $connection = self::Connect();

            // Convert the class passed by parameter to a table name
            $table = to_under_score($class);

            // Parse criteria for query condition
            $condition = '';
            $counter = 0;
            foreach ($criteria as $attr => $value) {
                $condition .= "$attr = :$attr";
                $counter++;
                if (count($criteria) !== $counter ) {
                    $condition .= " AND ";
                }
            }

            // Start query process
            $sql = "DELETE FROM $table WHERE $condition";
            $query = $connection->prepare($sql);
            $response = $query->execute($criteria);

            return $response;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Search Like pattern database statement
     *
     * @param $class
     * @param $pattern
     * @param $orders
     * @return mixed class object
     */
    public static function searchLike($class, $pattern, $orders)
    {
        try {

            // Connect to the database.
            $connection = self::Connect();

            // Convert the class passed by parameter to a table name
            $table = to_under_score($class);

            $sorts = '';
            $counter = 0;

            // Parse orders for query sort
            foreach ($orders as $attr => $sort) {
                $sorts = "$attr $sort";
                $counter++;
                if (count($orders) !== $counter ) {
                    $sorts .= ", ";
                }
            }

            // Parse pattern and condition
            $search = '';
            $counter = 0;

            foreach ($pattern as $field => $condition) {
                $search .= "$field LIKE ";

                foreach ($condition as $pattern => $operator) {
                    switch ($operator) {
                        case Model::BOTH:
                            $search .= "'%$pattern%'";

                            break;
                        case Model::STARTS:
                            $search .= "'$pattern%'";

                            break;
                        case Model::ENDS:
                            $search .= "'%$pattern'";

                            break;
                    }
                }

                $counter++;
                if (count($search) !== $counter ) {
                    $search .= " AND ";
                }
            }

            // Start query process
            $sql = "SELECT * FROM $table WHERE $search $sorts";
            $query = $connection->prepare($sql);
            $query->execute();

            // Fetch the Class Object
            $query->setFetchMode(PDO::FETCH_CLASS, $class);
            $rows = $query->fetchAll();

            return $rows;
        } catch (PDOException $e) {
            return 'Error - ' . $e->getMessage();
        }
    }

    /**
     * Custom Query database statement
     *
     * @param string $sql query
     * @param string $rowShow
     * @param string $class
     * @return array db response
     */
    public static function query($sql, $class, $rowShow = 'All')
    {
        try {

            // Connect to the database.
            $connection = self::Connect();

            // Start query process
            $query = $connection->prepare($sql);
            $query->execute();

            // Fetch the Class Object
            $query->setFetchMode(PDO::FETCH_CLASS, $class);

            // Check rows count and return it
            $rowCount = $query->rowCount();

            if ($rowCount > 1 || $rowShow == 'All') {

                $rows = [];

                while ($result = $query->fetch()) {
                    $rows[] = $result;
                }

                return $rows;
            } else if($rowCount <= 1 || $rowShow == 'First') {
                return $query->fetch();
            }

        } catch (PDOException $e) {
            return false;
        }
    }
}
