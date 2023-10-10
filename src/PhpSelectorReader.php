<?php

declare(strict_types=1);

namespace TorfsICT\GrumPHP\PhpSelector;

use GrumPHP\Util\Paths;
use Symfony\Component\Dotenv\Dotenv;

class PhpSelectorReader
{
    private ?string $executable;

    public function __construct(Paths $paths)
    {
        // Retrieve the environment variable (if set)
        $envPath = sprintf('%s/.env.grumphp', $paths->getProjectDir());
        if (!is_readable($envPath) || is_dir($envPath)) {
            $this->executable = null;
        } else {
            $data = file_get_contents($envPath);
            assert(is_string($data));
            $env = (new Dotenv())->parse($data, $envPath);
            if (array_key_exists('GRUMPHP_PHP_EXECUTABLE', $env) && !empty($env['GRUMPHP_PHP_EXECUTABLE'])) {
                $this->executable = $env['GRUMPHP_PHP_EXECUTABLE'];
            } else {
                $this->executable = null;
            }
        }
    }

    public function getExecutable(): ?string
    {
        return $this->executable;
    }

    public function hasExecutable(): bool
    {
        return null !== $this->executable;
    }
}
