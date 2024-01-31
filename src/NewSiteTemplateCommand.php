<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewSiteTemplateCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('new:site-template')
            ->setAliases(['nst'])
            ->setDescription('create new bitrix site template')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $from = Helper::getTemplatePath('/site-template');
        $to = Helper::getCurrentPath('/' . $name);
        Helper::copyFolder($from, $to);
        Helper::compileTemplate($to . '/description.php', [
            '#TEMPLATE_NAME#' => $name,
        ]);
        return 0;
    }
}
