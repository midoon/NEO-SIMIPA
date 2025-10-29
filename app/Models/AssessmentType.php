<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentType extends Model
{
    protected $guarded = ['id'];


    public function assessment_scores(): HasMany
    {
        return $this->hasMany(AssessmentScore::class);
    }
}
