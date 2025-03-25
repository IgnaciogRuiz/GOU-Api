<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user1_id',
        'user2_id',
        'creation_date',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user1_id' => 'integer',
        'user2_id' => 'integer',
        'creation_date' => 'datetime',
        'user_id' => 'integer',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
