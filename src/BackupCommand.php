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
                'archive_name',
                InputArgument::OPTIONAL,
                'Name archive',
                '../project.tar.gz'
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
        $bitrixPath = $input->getArgument('bitrix_path');
        $archiveName = $input->getArgument('archive_name');
        $connectionName = $input->getArgument('bitrix_path');

        $config = require $bitrixPath . '/.settings.php';
        $dbConf = $config['connections']['value'][$connectionName];

        $commandDump = 'mysqldump -h ' . $dbConf['host'] .
            ' -u ' . $dbConf['login'] .
            ' -p' . $dbConf['password'] . ' ' .
            $dbConf['database'] .
            ' > ' . $dbConf['database'] . '.sql';

        exec($commandDump);
        //$output->writeln('')
        $commandArchive = 'tar -czvpf ' . $archiveName . ' ' .
            $rootPath .
            ' ' . $dbConf['database'] . '.sql' .
            ' --exclude=' . $bitrixPath . '/cache/*' .
            ' --exclude=' . $bitrixPath . '/managed_cache/*' .
            ' --exclude=' . $bitrixPath . '/stack_cache/*';

        exec($commandArchive);
        //$output->writeln('')
        exec('rm -rf ' . $dbConf['database'] . '.sql');
        //$output->writeln('')
    }
}
