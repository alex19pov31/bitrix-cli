<?php
Bitrix\Main\Loader::registerAutoloadClasses(
    "#MODULE_NAME#",
    array(
        "#NAMESPACE#\\Test" => "lib/test.php",
    )
);
