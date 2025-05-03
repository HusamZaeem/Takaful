<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    
    

    protected $primaryKey = 'case_type_id';

    protected $fillable = ['name'];

    public function cases()
    {
        return $this->belongsToMany(CaseForm::class, 'case_form_case_type', 'case_type_id', 'case_id');
    }


}
