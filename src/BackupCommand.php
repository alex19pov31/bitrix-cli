<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BackupCommand extends Command
{
    protected function configure()
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rootPath = $input->getArgument('root_path');
        $rootGlobalPath = realpath($input->getArgument('root_path'));
        $bitrixPath = $input->getArgument('bitrix_path');
        $bitrixGlobalPath = realpath($bitrixPath);
        $archiveName = $input->getArgument('archive_name');
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
            ' --password="' . $dbConf['password'] . '" ' .
            $dbConf['database'] .
            ' > ' . $dbConf['database'] . '.sql';
        exec($commandDump);
        $output->writeln('Dump is finished!');

        $output->writeln('Creating archive...');
        $commandArchive = 'tar -czvpf ' . $archiveName . ' ' .
            $rootPath .
            ' ' . $dbConf['database'] . '.sql' .
            ' --exclude=' . $bitrixGlobalPath . '/cache/*' .
            ' --exclude=' . $bitrixGlobalPath . '/managed_cache/*' .
            ' --exclude=' . $bitrixGlobalPath . '/stack_cache/*' .
            ' --exclude=' . $bitrixGlobalPath . '/backup/*' .
            ' --exclude=' . $rootGlobalPath . '/upload/resize_cache/*' .
            ' --exclude=' . $rootGlobalPath . '/*.tar.gz';

        exec($commandArchive);
        exec('rm -rf ' . $dbConf['database'] . '.sql');
        $output->writeln('Backup is complete!');
    }
}
