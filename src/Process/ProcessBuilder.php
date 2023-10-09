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
    private ?string $executable;

    public function __construct(
        PhpSelectorReader $phpSelectorReader,
        ExternalCommand $externalCommandLocator,
        IOInterface $io,
        ProcessConfig $config
    ) {
        parent::__construct($externalCommandLocator, $io, $config);
        $this->executable = $phpSelectorReader->getExecutable();
    }

    public function buildProcess(ProcessArgumentsCollection $arguments): Process
    {
        if (null !== $this->executable) {
            $array = $arguments->toArray();
            array_unshift($array, $this->executable);
            $arguments = new ProcessArgumentsCollection($array);
        }

        return parent::buildProcess($arguments);
    }
}
