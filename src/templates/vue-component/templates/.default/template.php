<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\UI\Extension;
Extension::load('ui.vue');
define('VUEJS_DEBUG', true);

?>

<div id="#VUE_COMPONENT_NAME#"></div>
<template id="#VUE_COMPONENT_NAME#-template">
    Your template....
</template>

    <script>
        BX.Vue.component('bx-#VUE_COMPONENT_NAME#-component', {
            template: '##VUE_COMPONENT_NAME#-template',
            computed: {
                localize: function() {
                    return <?=json_encode(Loc::loadLanguageFile(__FILE__));?>
                },
            },
            data: function () {
                return <?=json_encode($arResult);?>;
            },
            methods : {
            }
        });
        BX.Vue.create({
            el: '##VUE_COMPONENT_NAME#',
            template: '<bx-#VUE_COMPONENT_NAME#-component/>',
        });
    </script>