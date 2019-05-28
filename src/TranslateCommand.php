<?php

namespace Alex19pov31\BitrixCli;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TranslateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('helper:translate')
            ->setAliases(['tr'])
            ->setDescription('translate local messages')
            ->addArgument(
                'source_lang',
                InputArgument::OPTIONAL,
                '',
                'ru'
            )
            ->addArgument(
                'target_lang',
                InputArgument::OPTIONAL,
                '',
                'en'
            );
    }

    private function packMessages(array $data): string
    {
        $index = 0;
        $nData = [];
        foreach ($data as $file => $messList) {
            $nData[] = implode('|||', array_values($messList));
        }

        return implode('~~~', $nData);
    }

    private function unpackMessages(array $originData, string $newData): array
    {
        $data = [];
        $files = array_keys($originData);
        $newData = str_replace(
            [
                '| ||',
                '|| |',
                '| | |',
                '~ ~~',
                '~~ ~',
                '~ ~ ~',
            ],
            [
                '|||',
                '|||',
                '|||',
                '~~~',
                '~~~',
                '~~~',
            ],
            $newData
        );
        $list = explode('~~~', $newData);

        foreach ($list as $i => $el) {
            $file = $files[$i];
            $keys = array_keys($originData[$file]);
            $values = explode('|||', $el);
            if (empty($keys)) {
                $data[$file] = [];
                continue;
            }

            $data[$file] = array_combine($keys, $values);
        }

        return $data;
    }

    private function saveFile(string $filePath, $data): void
    {
        $strData = "<?php\n";
        $data = $data ? $data : [];
        foreach ($data as $key => $msg) {
            $strData .= "\$MESS['" . $key . "'] = \"" . str_replace('"', '\"', trim($msg)) . "\";\n";
        }

        file_put_contents($filePath, $strData);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceLang = $input->getArgument('source_lang');
        $targetLang = $input->getArgument('target_lang');
        $gTargtLang = $targetLang;
        if ($gTargtLang == 'cn') {
            $gTargtLang = 'zh-TW';
        }

        $langMesaages = Helper::getLangMessages('./lang/' . $sourceLang);
        if (empty($langMesaages)) {
            $output->writeln('Messages not found');
            return;
        }

        $tr = new GoogleTranslate($gTargtLang, $sourceLang);
        $nData = $tr->translate($this->packMessages($langMesaages));
        $trData = $this->unpackMessages($langMesaages, $nData);

        $countMessage = 0;
        foreach ($trData as $file => $data) {
            $countMessage += count($data);
            $filePath = './lang/' . $targetLang . '/' . $file;
            Helper::mkdirSafe(dirname($filePath), true);
            $this->saveFile($filePath, $data);
        }
        $output->writeln($countMessage . ' messages translated');
    }
}
