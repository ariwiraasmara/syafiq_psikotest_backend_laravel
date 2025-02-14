<?php
// 
// 
// 
namespace App\Policies;

use App\Models\as0001_variabelsetting;

class as0001_variabelsetting_policy
{
    /**
     * Create a new policy instance.
     */
    protected as0001_variabelsetting $model;
    public function __construct(as0001_variabelsetting $model)
    {
        //
        $this->model = $model;
    }

    public function validation(int $id) {
        $res = $this->model->where(['id' => $id])->first();
        if($res) return true;
        else return false;
    }
}
