<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BackupCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('server:backup')
            ->setAliases(['bkp'])
            ->setDescription('create backup bitrix project')
            ->addArgument(
                'archive_name',
                InputArgument::OPTIONAL,
                'Name archive',
                '../project.tar.gz'
            )
            ->addArgument(
                'root_path',
                InputArgument::OPTIONAL,
                'Root path project',
                './'
            )
            ->addArgument(
                'bitrix_path',
                InputArgument::OPTIONAL,
                'Path to bitrix folder',
                './bitrix'
            )
            ->addArgument(
                'connection_name',
                InputArgument::OPTIONAL,
                'Name to connection DB',
                'default'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rootPath = $input->getArgument('root_path');
        $rootGlobalPath = realpath($input->getArgument('root_path'));
        $bitrixPath = $input->getArgument('bitrix_path');
        //$bitrixGlobalPath = realpath($bitrixPath);
        $archiveName = $input->getArgument('archive_name');
        $connectionName = $input->getArgument('connection_name');

        if (!is_dir($bitrixPath)) {
            $output->writeln('Bitrix core not found!');
            return 0;
        }

        $config = require $bitrixPath . '/.settings.php';
        $dbConf = $config['connections']['value'][$connectionName];

        $output->writeln('Start dump database...');
        $commandDump = 'mysqldump -h ' . $dbConf['host'] .
            ' -u ' . $dbConf['login'] .
            ' --password="' . $dbConf['password'] . '" ' .
            $dbConf['database'] .
            ' > ' . $rootGlobalPath . '/db.sql';
        exec($commandDump);
        $output->writeln('Dump is finished!');

        $output->writeln('Creating archive...');
        $commandArchive = 'tar -czvpf ' . $archiveName . ' ' .
            $rootPath .
            ' --exclude=' . $rootPath . '/bitrix/cache/*' .
            ' --exclude=' . $rootPath . '/bitrix/managed_cache/*' .
            ' --exclude=' . $rootPath . '/bitrix/stack_cache/*' .
            ' --exclude=' . $rootPath . '/bitrix/backup/*' .
            ' --exclude=' . $rootPath . '/upload/resize_cache/*' .
            ' --exclude=' . $rootPath . '/*.tar.gz';

        exec($commandArchive);
        exec('rm -rf ' . $rootGlobalPath . '/db.sql');
        $output->writeln('Backup is complete!');
        return 0;
    }
}
