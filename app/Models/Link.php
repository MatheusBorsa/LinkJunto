<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Link extends Model
{

    use HasFactory;
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
