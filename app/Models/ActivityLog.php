<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'role_id', 'email', 'name', 'activity', 'action', 'ip_address', 'status'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
