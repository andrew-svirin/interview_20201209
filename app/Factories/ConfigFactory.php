<?php

namespace AndrewSvirin\Interview\Factories;

use AndrewSvirin\Interview\Exceptions\FileNotFoundException;
use AndrewSvirin\Interview\Services\Config;
use Dotenv\Dotenv;

/**
 * Produce config.
 */
class ConfigFactory
{

    /**
     * Produce config from a file.
     *
     * @param string|null $path
     * @return Config
     * @throws FileNotFoundException
     */
    public static function produceFromFile(string $path = null): Config
    {
        // Set default config file path.
        if (null === $path) {
            $path = BASE_DIR . '/config/app.php';
        }

        // Check if config file exists.
        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }

        // Create in unsafe mode to access by function `getenv`.
        $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
        $dotenv->load();

        // Load config array from file.
        $config = include $path;

        return self::produceFromArray($config);
    }

    /**
     * Produce config from an array.
     *
     * @param array $config
     * @return Config
     */
    public static function produceFromArray(array $config): Config
    {
        return new Config($config);
    }
}
