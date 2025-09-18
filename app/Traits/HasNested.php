<?php  
namespace App\Traits;

trait HasNested {

    protected function nestedSet(){
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }
}