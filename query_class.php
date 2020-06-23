<?php


class Query
{
    private $results;
    private $connection;

    function __construct($host, $user, $password, $database)
    {
        $this->connection = mysqli_connect(
            $host, $user, $password, $database
        );
    }

    function Execute($query)
    {
        $this->results = ($this->connection ? mysqli_query($this->connection, $query) : false);
        return $this->results !== false;
    }

    function Display()
    {
        while(($row = mysqli_fetch_row($this->results))) {
            print_r($row);
        }
    }
};