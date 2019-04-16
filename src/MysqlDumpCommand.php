<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlDumpCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('server:db-dump')
            ->setAliases(['dbd'])
            ->setDescription('create database dump')
            ->addArgument(
                'bitrix_path',
                InputArgument::OPTIONAL,
                'Path to bitrix folder',
                realpath('./bitrix')
            )
            ->addArgument(
                'connection_name',
                InputArgument::OPTIONAL,
                'Name to connection DB',
                'default'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bitrixPath = $input->getArgument('bitrix_path');
        $connectionName = $input->getArgument('connection_name');

        if (!is_dir($bitrixPath)) {
            $output->writeln('Bitrix core not found!');
            return;
        }

        $config = require $bitrixPath . '/.settings.php';
        $dbConf = $config['connections']['value'][$connectionName];

        $output->writeln('Start dump database...');
        $commandDump = 'mysqldump -h ' . $dbConf['host'] .
            ' -u ' . $dbConf['login'] .
            ' -p' . $dbConf['password'] . ' ' .
            $dbConf['database'] .
            ' >' . $dbConf['database'] . '.sql';

        exec($commandDump);
        $output->writeln('Dump is finished!');
    }
}
