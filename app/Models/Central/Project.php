<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = [
        'name',
        'description',
        'status',
        'priority',
        'deadline',
        'started_at',
        'completed_at',
        'created_by',
        'assigned_to',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
