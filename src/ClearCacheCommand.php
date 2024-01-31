<?php

namespace Alex19pov31\BitrixCli;

use Bitrix\Main\Data\Cache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCacheCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('helper:clear-cache')
            ->setAliases(['cc'])
            ->setDescription('clear cache bitrix')
            ->addArgument(
                'bitrix_path',
                InputArgument::OPTIONAL,
                'Path to bitrix folder',
                realpath('./bitrix')
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bitrixPath = $input->getArgument('bitrix_path');
        $prologFile = $bitrixPath . '/modules/main/include/prolog_before.php';
        if (!is_file($prologFile)) {
            $output->writeln('Bitrix core not found!');
            return 0;
        }

        require_once $prologFile;

        $output->writeln('Start cleaning...');
        Cache::createInstance()->clearCache(true);
        $output->writeln('Cache cleared');
        return 1;
    }
}
