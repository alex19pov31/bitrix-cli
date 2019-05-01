<?php
use Bitrix\Main\UserField\TypeBase;

class TestField extends TypeBase
{
    const USER_TYPE_ID = "#TYPE_NAME#";

    public function GetUserTypeDescription(): array
    {
        return [
            "USER_TYPE_ID" => static::USER_TYPE_ID,
            "CLASS_NAME" => __CLASS__,
            "DESCRIPTION" => GetMessage("USER_TYPE_BOOL_DESCRIPTION"),
            "BASE_TYPE" => \CUserTypeManager::BASE_TYPE_INT,
            "EDIT_CALLBACK" => array(__CLASS__, 'GetPublicEdit'),
            "VIEW_CALLBACK" => array(__CLASS__, 'GetPublicView'),
        ];
    }

    public function GetDBColumnType($arUserField): string
    {
        global $DB;
        switch (strtolower($DB->type)) {
            case "mysql":
                return "int(18)";
            case "oracle":
                return "number(18)";
            case "mssql":
                return "int";
        }
    }

    public function PrepareSettings($arUserField)
    {

    }

    public function GetSettingsHTML($arUserField = false, $arHtmlControl, $bVarsFromForm)
    {

    }

    /**
     * В форме редактирования элемента
     *
     * @param [type] $arUserField
     * @param [type] $arHtmlControl
     * @return void
     */
    public function GetEditFormHTML($arUserField, $arHtmlControl)
    {

    }

    public function GetGroupActionData($arUserField, $arHtmlControl)
    {

    }

    public function GetEditFormHTMLMulty($arUserField, $arHtmlControl)
    {

    }

    public function GetFilterHTML($arUserField, $arHtmlControl)
    {

    }

    public function GetFilterData($arUserField, $arHtmlControl)
    {

    }

    /**
     * Список значений в админке в режиме просмотра
     *
     * @param [type] $arUserField
     * @param [type] $arHtmlControl
     * @return void
     */
    public function GetAdminListViewHTML($arUserField, $arHtmlControl)
    {

    }

    /**
     * Список значений в админке в режиме редактирования
     *
     * @param [type] $arUserField
     * @param [type] $arHtmlControl
     * @return void
     */
    public function GetAdminListEditHTML($arUserField, $arHtmlControl)
    {

    }

    public function GetAdminListEditHTMLMulty($arUserField, $arHtmlControl)
    {

    }

    public function OnBeforeSave($arUserField, $value)
    {

    }

    public static function GetPublicView($arUserField, $arAdditionalParameters = [])
    {

    }

    public function getPublicEdit($arUserField, $arAdditionalParameters = [])
    {

    }
}
