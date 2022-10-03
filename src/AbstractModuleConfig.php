<?php

namespace App;

abstract class AbstractModuleConfig implements ModuleConfiguration
{
    protected array $config = [];

    public function __construct() {
        $this->config = require_once (dirname(__DIR__) . '/config/config.php');
    }

    public function get(string $key): mixed
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : null;
    }
}
