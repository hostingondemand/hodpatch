<?php
namespace modules\maxpatch\lib;
    use core\Lib;
    use core\Loader;

    class Patch extends Lib{
        function __construct()
        {
            Loader::loadClass("basePatch","modules/maxpatch/lib/patch");
        }

        function table($name){
            $table= Loader::CreateInstance("table","modules\maxpatch\lib\patch");
            $table->setName($name);
            return $table;
        }
    }
?>