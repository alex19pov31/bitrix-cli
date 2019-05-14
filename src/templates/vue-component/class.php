<?php

namespace App\Local\Component;

use CBitrixComponent;

class #CLASS_NAME# extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
	{
		return $arParams;
    }
    
    public function executeComponent(): void
    {
        $this->includeComponentTemplate();
    }

}
