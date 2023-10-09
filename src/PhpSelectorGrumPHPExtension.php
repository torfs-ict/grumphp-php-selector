<?php

declare(strict_types=1);

namespace TorfsICT\GrumPHP\PhpSelector;

use GrumPHP\Extension\ExtensionInterface;

class PhpSelectorGrumPHPExtension implements ExtensionInterface
{
    public function imports(): iterable
    {
        yield __DIR__.'/../config/php-selector.yaml';
    }
}
