<?php
namespace App\Traits;

trait RecordCount{

    public function getTotalCount(){
        return $this->count();
    }
}
