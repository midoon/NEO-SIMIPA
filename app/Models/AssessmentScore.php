<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentScore extends Model
{
    protected $guarded = ['id'];

    public function asssessment_type()
    {
        return $this->belongsTo(AssessmentType::class);
    }
}
