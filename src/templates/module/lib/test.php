<?php

namespace #NAMESPACE#;

use #NAMESPACE#\DataTable;

class Test
{

    public static function get()
    {
        $result = DataTable::getList(
            array(
                'select' => array('*'),
            ));
        $row = $result->fetch();
        print "<pre>";
        print_r($row);
        print "</pre>";
        return $row;
    }

}
