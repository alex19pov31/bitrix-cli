<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewComponentCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new:component')
            ->setAliases(['nc'])
            ->setDescription('create new bitrix component')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $from = Helper::getTemplatePath('/component');
        $to = Helper::getCurrentPath('/' . $name);
        Helper::copyFolder($from, $to);
        Helper::compileTemplate($to . '/class.php', [
            '#CLASS_NAME#' => Helper::strToCamelCase($name) . 'Component',
        ]);
    }
}
