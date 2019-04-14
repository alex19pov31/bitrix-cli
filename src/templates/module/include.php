<?php
Bitrix\Main\Loader::registerAutoloadClasses(
    "#MODULE_NAME#",
    array(
        "#CLASS_NAME#\\D7\\Test" => "lib/test.php",
    )
);
