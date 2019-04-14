<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewProjectCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new:project')
            ->setAliases(['np'])
            ->setDescription('create new bitrix project')
            ->addArgument('name', InputArgument::REQUIRED)
            ->addArgument(
                'distr',
                InputArgument::OPTIONAL,
                '[start, standard, small_business, business, bitrix24, bitrix24_enterprise]',
                'business'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $baseURL = 'http://www.1c-bitrix.ru/download/';
        $distrList = [
            'start' => 'start_encode.tar.gz',
            'standard' => 'standard_encode.tar.gz',
            'small_business' => 'small_business_encode.tar.gz',
            'business' => 'business_encode.tar.gz',
            'bitrix24' => 'portal/bitrix24_encode.tar.gz',
            'bitrix24_enterprise' => 'portal/bitrix24_enterprise_encode.tar.gz',
        ];

        $name = $input->getArgument('name');
        $distr = $input->getArgument('distr');

        $command = 'mkdir ' . $name . ' && cd ' . $name . ' && ';
        $command .= 'wget ' . $baseURL . $distrList[$distr] . ' && ';
        $command .= 'tar -xzvpf ' . str_replace('portal/', '', $distrList[$distr]) . ' && ';
        $command .= 'rm -rf ' . str_replace('portal/', '', $distrList[$distr]);

        exec($command);
    }
}
