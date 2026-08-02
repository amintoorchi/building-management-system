<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(["user_id", "home_number", "floor", "plate_number"])]
class Unit extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
