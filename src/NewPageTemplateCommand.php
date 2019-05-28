<?php

namespace Alex19pov31\BitrixCli;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewPageTemplateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new:page-template')
            ->setAliases(['npt'])
            ->setDescription('New page template')
            ->addArgument(
                'pageTemplatename',
                InputArgument::OPTIONAL,
                '',
                'standard'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pageTemplatename = $input->getArgument('pageTemplatename').'.php';
        $dataTemplate = file_get_contents(Helper::getTemplatePath('/page_templates/standart.php'));
        $filteConfig = './page_templates/.content.php';
        $fileTemplate = './page_templates/'.$pageTemplatename;
        $isFileExists = file_exists($filteConfig);
        if ($isFileExists) {
            require_once($filteConfig);
        }
        $TEMPLATE[$pageTemplatename] = [
            'name' => 'Новая страница',
            'sort' => 100,
        ];

        $strData = "<?php\n";
        foreach($TEMPLATE as $page => $data) {
            $strData .= "\$TEMPLATE[\"".$page."\"] = [\n\t";
            $strData .= "\"name\" => \"".$data['name']."\",\n\t";
            $strData .= "\"sort\" => ".(int) $data['sort'].",\n];\n"; 
        }
        Helper::mkdirSafe(dirname($filteConfig), true);
        file_put_contents($filteConfig, $strData);
        file_put_contents($fileTemplate, $dataTemplate);
    }
}
