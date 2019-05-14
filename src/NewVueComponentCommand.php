<?php


namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewVueComponentCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new:vue-component')
            ->setAliases(['nvc'])
            ->setDescription('create new bitrix vue component')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $from = Helper::getTemplatePath('/vue-component');
        $to = Helper::getCurrentPath('/' . $name);
        Helper::copyFolder($from, $to);
        $vueComponentName = str_replace(['-', '.', ' '], '-', $name);
        Helper::compileTemplate($to . '/class.php', [
            '#CLASS_NAME#' => Helper::strToCamelCase($name) . 'Component',
        ]);
        Helper::compileTemplate($to . '/templates/.default/template.php', [
            '#VUE_COMPONENT_NAME#' => $vueComponentName,
        ]);
    }
}