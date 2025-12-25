<?php
namespace MongoDB;

class Client {
    private $databases = [];
    private $storageDir;
    
    public function __construct($uri = 'mongodb://localhost:27017') {
        $this->storageDir = __DIR__ . '/../../.mongodb_storage';
        if (!is_dir($this->storageDir)) {
            mkdir($this->storageDir, 0755, true);
        }
    }
    
    public function __get($name) {
        if (!isset($this->databases[$name])) {
            $this->databases[$name] = new Database($name, $this->storageDir);
        }
        return $this->databases[$name];
    }
}

class Database {
    private $collections = [];
    private $storageDir;
    
    public function __construct($name, $storageDir) {
        $this->storageDir = $storageDir . '/' . $name;
        if (!is_dir($this->storageDir)) {
            mkdir($this->storageDir, 0755, true);
        }
    }
    
    public function __get($name) {
        if (!isset($this->collections[$name])) {
            $this->collections[$name] = new Collection($name, $this->storageDir);
        }
        return $this->collections[$name];
    }
}

class Collection {
    private $dataFile;
    
    public function __construct($name, $dbStorageDir) {
        $storageDir = $dbStorageDir . '/' . $name;
        $this->dataFile = $storageDir . '/data.json';
        
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, json_encode([]));
        }
    }
    
    public function findOne($filter = []) {
        $data = $this->loadData();
        foreach ($data as $doc) {
            if ($this->matches($doc, $filter)) {
                return $doc;
            }
        }
        return null;
    }
    
    public function updateOne($filter = [], $update = [], $options = []) {
        $data = $this->loadData();
        $found = false;
        $upsert = $options['upsert'] ?? false;
        
        foreach ($data as &$doc) {
            if ($this->matches($doc, $filter)) {
                $found = true;
                if (isset($update['$set'])) {
                    foreach ($update['$set'] as $key => $value) {
                        $doc[$key] = $value;
                    }
                }
                break;
            }
        }
        
        if (!$found && $upsert) {
            $newDoc = array_merge($filter, $update['$set'] ?? []);
            $newDoc['_id'] = uniqid();
            $data[] = $newDoc;
        }
        
        $this->saveData($data);
        return new \stdClass();
    }
    
    private function matches($doc, $filter) {
        foreach ($filter as $key => $value) {
            if (!isset($doc[$key]) || $doc[$key] !== $value) {
                return false;
            }
        }
        return true;
    }
    
    private function loadData() {
        $content = file_get_contents($this->dataFile);
        return json_decode($content, true) ?: [];
    }
    
    private function saveData($data) {
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }
}

namespace MongoDB\BSON;

class UTCDateTime {
    private $ms;
    
    public function __construct($milliseconds) {
        $this->ms = $milliseconds;
    }
}
?>
