<?php

namespace App;

interface ModuleConfiguration
{
    public function get(string $key): mixed;
}
