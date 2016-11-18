<?php
namespace modules\hodpatch\service;
    use core\Loader;
    use lib\service\BaseService;

    class Patch extends  BaseService{
        var $setupDone=false;


        function setup(){
            if(!$this->setupDone) {
                $table = $this->patch->table("hodpatch");
                if (!$table->exists()) {
                    $table->addField("patch", "varchar(50)");
                    $table->addField("success", "int");
                    $table->addField("date", "int");
                    $table->create();
                }
            $this->setupDone=true;
            }
        }

        function doPatchProject(){
            $this->doPatch("project");
        }

        function doPatch($name)
        {
            if($name=="project"){
                $folder="project/patch";
            }else {
                $folder = "modules/" . $name . "/patch";

                if ($this->filesystem->exists("project/modules/" . $name . "/patch")) {
                    $folder = "project/modules/" . $name . "/patch";
                }
            }


            if($this->filesystem->exists($folder)){
                $files=$this->filesystem->getFiles($folder);
                foreach($files as $file){
                    if(substr($file,-4)){
                        $file=substr($file,0,-4);
                    }

                    $patchName=$name."/".$file;
                    if($this->needPatch($patchName)) {

                        $this->goModule($name);
                        $patch = Loader::getSingleton($file, $folder);
                        $success = $patch->patch();
                        $this->goBackModule();


                        $patchModel = $this->model->patch->initialize($patchName, $success, time());
                        $this->db->saveModel($patchModel, "hodpatch");
                    }
                }
            }
        }

        function needPatch($name){
            $query=$this->db->query("select id from hodpatch where patch='".$name."' and success=1");
            return !$this->db->numRows($query);
        }







    }
?>