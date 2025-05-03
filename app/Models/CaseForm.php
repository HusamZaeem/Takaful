<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseForm extends Model
{



    protected $table = 'case_forms';

    protected $primaryKey = 'case_id';

    protected $fillable = [
        'user_id', 'id_number', 'incident_date', 'short_description',
        'notes', 'status', 'admin_note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function caseTypes()
    {
        return $this->belongsToMany(CaseType::class, 'case_form_case_type', 'case_id', 'case_type_id');
    }
}
