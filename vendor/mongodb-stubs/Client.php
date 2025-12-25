<?php
namespace MongoDB;

/**
 * MongoDB Client Class - Stub for Development
 */
class Client
{
    private $uri;
    private $databases = [];

    public function __construct($uri = 'mongodb://localhost:27017', array $options = [])
    {
        $this->uri = $uri;
    }

    public function __get($dbname)
    {
        if (!isset($this->databases[$dbname])) {
            $this->databases[$dbname] = new Database($this, $dbname);
        }
        return $this->databases[$dbname];
    }

    public function close()
    {
        // Connection close logic
    }
}
