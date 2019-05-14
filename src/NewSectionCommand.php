<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewSectionCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new:section')
            ->setDescription('create new section')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $from = Helper::getTemplatePath('/section');
        $to = Helper::getCurrentPath('/' . $name);
        Helper::copyFolder($from, $to);
    }
}
