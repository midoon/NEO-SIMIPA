<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    protected $guarded = ["id"];

    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }
}
