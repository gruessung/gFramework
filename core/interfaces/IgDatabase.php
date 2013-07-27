<?php

interface IgDatabase {

    /**
     * function to connect to database
     *
     * @throws gError_Database
     *
     * @param $h
     * @param $u
     * @param $p
     * @param $d
     * @return mixed
     */
    public function connect($h, $u, $p, $d);

    /**
     * function to execute a query
     *
     * @param $query
     * @return mixed
     */
    public function query($query);

    /**
     * function to count rows in query result set
     *
     * @return mixed
     */
    public function num_rows();

    /**
     * function to fetch rows
     *
     * @return mixed
     */
    public function fetch();


    /**
     * function to insert a row
     *
     * @param $table
     * @param $colls
     * @param $values
     * @param string $prafix
     * @return mixed
     */
    public function insert($table,$colls,$values,$prafix=pfw);

}