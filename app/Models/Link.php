<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Link extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'url',
        'order'
    ];

    protected $casts = [
        'order' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
