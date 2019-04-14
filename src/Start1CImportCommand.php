<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Start1CImportCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('helper:1c-import')
            ->setAliases(['1ci'])
            ->setDescription('start import from local files')
            ->addArgument('archive', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setInteractive(true);
    }
}
