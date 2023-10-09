<?php

declare(strict_types=1);

namespace TorfsICT\GrumPHP\PhpSelector\Process;

use GrumPHP\Collection\ProcessArgumentsCollection;
use GrumPHP\Configuration\Model\ProcessConfig;
use GrumPHP\IO\IOInterface;
use GrumPHP\Locator\ExternalCommand;
use Symfony\Component\Process\Process;
use TorfsICT\GrumPHP\PhpSelector\PhpSelectorReader;

class ProcessBuilder extends \GrumPHP\Process\ProcessBuilder
{
    public function __construct(
        private readonly PhpSelectorReader $phpSelectorReader,
        ExternalCommand $externalCommandLocator,
        IOInterface $io,
        ProcessConfig $config
    ) {
        parent::__construct($externalCommandLocator, $io, $config);
    }

    public function buildProcess(ProcessArgumentsCollection $arguments): Process
    {
        if ($this->phpSelectorReader->hasExecutable()) {
            $executable = $this->phpSelectorReader->getExecutable();
            assert(is_string($executable));
            $array = $arguments->toArray();
            array_unshift($array, $executable);
            $arguments = new ProcessArgumentsCollection($array);
        }

        return parent::buildProcess($arguments);
    }
}
