<?

IncludeModuleLangFile(__FILE__);
use \Bitrix\Main\ModuleManager;

class #CLASS_NAME# extends CModule
{
    public $MODULE_ID = "#MODULE_NAME#";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $errors;

    public function __construct()
    {
        $this->MODULE_VERSION = "#VERSION#";
        $this->MODULE_VERSION_DATE = "#DATE_CREATE#";
        $this->MODULE_NAME = "Название модуля";
        $this->MODULE_DESCRIPTION = "Описание модуля";
    }

    public function DoInstall()
    {
        $this->InstallDB();
        $this->InstallEvents();
        $this->InstallFiles();
        ModuleManager::RegisterModule($this->MODULE_ID);
        return true;
    }

    public function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        return true;
    }

    public function InstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/".$this->MODULE_ID."/install/db/install.sql");
        if (!$this->errors) {

            return true;
        } else {
            return $this->errors;
        }

    }

    public function UnInstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/".$this->MODULE_ID."/install/db/uninstall.sql");
        if (!$this->errors) {
            return true;
        } else {
            return $this->errors;
        }

    }

    public function InstallEvents()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }

    public function InstallFiles()
    {
        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }
}
