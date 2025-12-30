<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'start_date',
        'end_date',
        'reason',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relations
     */
    
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Méthodes utiles
     */
    
    public function isActive()
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }
    
    public function isUpcoming()
    {
        return $this->start_date > now();
    }
    
    public function isPast()
    {
        return $this->end_date < now();
    }
    
    public function getDurationInDays()
    {
        return $this->start_date->diffInDays($this->end_date);
    }
}
