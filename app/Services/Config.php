<?php

namespace AndrewSvirin\Interview\Services;

use AndrewSvirin\Interview\Helpers\ArrHelper;

/**
 * Handle config data.
 */
class Config
{

    /**
     * Config data.
     * @var array
     */
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get config data by path.
     *
     * @param string $key The path to config data in "dot" syntax.
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return ArrHelper::get($this->config, $key);
    }
}
