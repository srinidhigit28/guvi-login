<?php
/**
 * RedisStub - Simple Redis-like session storage using file system
 * This is a fallback when Redis extension is not installed
 */
class Redis {
    private $storageDir = __DIR__ . '/../.redis_storage';
    
    public function __construct() {
        if (!is_dir($this->storageDir)) {
            mkdir($this->storageDir, 0755, true);
        }
    }
    
    public function connect($host, $port) {
        // File-based storage doesn't need actual connection
        return true;
    }
    
    public function get($key) {
        $file = $this->storageDir . '/' . md5($key) . '.json';
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            // Check if expired
            if (isset($data['expiry']) && $data['expiry'] < time()) {
                unlink($file);
                return false;
            }
            return $data['value'] ?? false;
        }
        return false;
    }
    
    public function set($key, $value) {
        $file = $this->storageDir . '/' . md5($key) . '.json';
        $data = ['value' => $value, 'expiry' => PHP_INT_MAX];
        file_put_contents($file, json_encode($data));
        return true;
    }
    
    public function setex($key, $ttl, $value) {
        $file = $this->storageDir . '/' . md5($key) . '.json';
        $data = ['value' => $value, 'expiry' => time() + $ttl];
        file_put_contents($file, json_encode($data));
        return true;
    }
    
    public function close() {
        return true;
    }
}
?>
