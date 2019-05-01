<?php

namespace Alex19pov31\BitrixCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitTranslateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('helper:init-translate')
            ->setAliases(['itr'])
            ->setDescription('init local messages')
            ->addArgument(
                'lang',
                InputArgument::OPTIONAL,
                '',
                'ru'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceLang = $input->getArgument('lang');

        $dir_iterator = new \RecursiveDirectoryIterator("./");
        $iterator = new \RecursiveIteratorIterator($dir_iterator, \RecursiveIteratorIterator::SELF_FIRST);
// could use CHILD_FIRST if you so wish

        foreach ($iterator as $file) {
            if (strpos($file, '/lang/') !== false || strpos($file, '.vue') === false) {
                continue;
            }

            $data = file_get_contents($file);
            $data = preg_replace("/<script[\w\W]*?<\/script>/", "", $data);
            $data = preg_replace("/\<\?[\w\W]*?\?\>/", "", $data);
            preg_match_all("/\>([^\<\>]*?)\</", $data, $match);
            echo $file, "\n";
            var_dump($match);
        }

        //$files = glob('./*.php');
        //var_dump($files);
    }
}
