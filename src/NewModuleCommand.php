<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewModuleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new:module')
            ->setAliases(['nm'])
            ->setDescription('create new bitrix module')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $from = Helper::getTemplatePath('/module');
        $to = Helper::getCurrentPath('/' . $name);
        Helper::copyFolder($from, $to);

        $moduleClass = str_replace(['-', '.', ' '], '_', $name);
        $namespace = str_replace(['-', '.', ' '], "\\", $name);
        Helper::compileFolder($to, [
            '#CLASS_NAME#' => $moduleClass,
            '#MODULE_NAME#' => $name,
            '#NAMESPACE#' => $namespace,
            '#VERSION#' => '0.0.1',
            '#DATE_CREATE#' => date('Y-m-d H:i:s'),
        ]);
    }
}
