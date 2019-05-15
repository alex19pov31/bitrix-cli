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

        $countMessage = 0;
        foreach ($iterator as $file) {
            if (strpos($file, '/lang/') !== false || strpos($file, '.php') === false && strpos($file, '.vue') === false) {
                continue;
            }

            $originalData = file_get_contents($file);
            $data = preg_replace("/<script[\w\W]*?<\/script>/", "", $originalData);
            $data = preg_replace("/\<\?[\w\W]*?\?\>/", "", $data);
            preg_match_all("/\>([^\<\>]{2,})\</", $data, $match);

            $result = array_filter($match[1], function ($item) {
                return !empty(trim($item));
            });

            $result = array_values($result);
            $strData = "<?php\n";
            foreach ($result as $i => $text) {
                $key = 'message_' . $i;
                $strData .= "\$MESS['" . $key . "'] = \"" . str_replace('"', '\"', trim($text)) . "\";\n";
                $originalData = str_replace(trim($text), "<?= Loc::getMessage('" . $key . "') ?>", $originalData);
            }

            $filePath = './lang/ru/' . $file->getFilename();
            Helper::mkdirSafe(dirname($filePath), true);
            file_put_contents($filePath, $strData);
            file_put_contents($file, $originalData);
            $countMessage += count($result);
        }

        $output->writeln($countMessage . ' messages created');
    }
}
