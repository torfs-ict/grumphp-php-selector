<?php

declare(strict_types=1);

namespace TorfsICT\GrumPHP\PhpSelector\Process;

use GrumPHP\Collection\ProcessArgumentsCollection;
use GrumPHP\Configuration\Model\ProcessConfig;
use GrumPHP\IO\IOInterface;
use GrumPHP\Locator\ExternalCommand;
use PhpParser\ParserFactory;
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
            // Check if the original executable is effectively a PHP script
            $executable = (string) $arguments->first();
            try {
                $parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7);
                $parser->parse((string) file_get_contents($executable));
                $array = $arguments->toArray();
                array_unshift($array, $this->executable);
                $arguments = new ProcessArgumentsCollection($array);
            } catch (\Throwable) {
                // Parser failed, not a PHP script
            }
        }

        return parent::buildProcess($arguments);
    }
}
