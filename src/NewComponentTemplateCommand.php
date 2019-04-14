<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewComponentTemplateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new:component-template')
            ->setAliases(['nct'])
            ->setDescription('create new bitrix template component')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $from = Helper::getTemplatePath('/component-template');
        $to = Helper::getCurrentPath('/' . $name);
        Helper::copyFolder($from, $to);
    }
}
