<?php

/**
 * class Database
 * creates a database connection 
 * 
 * @author malek <malek.beloula@gmail.com>
 * @version 1.0
 */
class Database
{ 
    /**
     * it contain the variable connection to the database
     * @access private
     * @var object
     */
    private $connection = null;
    
    /**
     * 
     * @return boolean  returns true if we have a database connection, false if not
     */
    public function __construct()
    {
        // does db connection already exist (or is it null) ?
        if (!$this->connection) {
            // create a database connection using the constant from config/db.php
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);                        
            // if no errer returns true            
            return (!$this->connection->connect_errno ? true : false);
        }
    }
    
    /**
     * get the dabase connection
     * @return object   returns an object that contains the database connection
     */
    public function getDatabaseConnection()
    {
        return $this->connection;
    }
    
    /**
     * in case of error we get the number of the error
     * @return int  database connection error code
     */    
    public function getDatabaseError()
    {
        return $this->connection->connect_errno;
    }
    
}
