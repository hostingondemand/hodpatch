<?php namespace modules\hodpatch\listener;
class ProjectPostUpdate extends  \lib\event\BaseListener{

    function handle($data)
    {
        $this->service->patch->setup();
        $this->service->patch->doPatchProject();
    }
}