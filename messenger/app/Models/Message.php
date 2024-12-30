<?php

namespace App\Models;

use App\Base\Traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory, HasRules;

    protected $fillable = [
        'user_id',
        'txt',
        'img',
        'in_replay_to_msg_id',
        'receiver_id',
    ];

    public static function rules(array $updated_rules = []): array
    {
        return array_merge(
            [
                'txt' => ['nullable', 'string', 'max:2056'],
                'img' => ['nullable', 'image'],
            ],
            $updated_rules
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
