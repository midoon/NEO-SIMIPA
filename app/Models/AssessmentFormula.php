<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentFormula extends Model
{
    protected $guarded = ['id'];


    public function assessment_formula_details()
    {
        return $this->hasMany(AssessmentFormulaDetail::class);
    }
}
