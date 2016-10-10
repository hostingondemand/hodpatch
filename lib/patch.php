<?php
namespace modules\hodpatch\lib;
    use core\Lib;
    use core\Loader;

    class Patch extends Lib{
        function __construct()
        {
            Loader::loadClass("basePatch","modules/hodpatch/lib/patch");
        }

        function table($name){
            $table= Loader::CreateInstance("table","modules\hodpatch\lib\patch");
            $table->setName($name);
            return $table;
        }
    }
?>