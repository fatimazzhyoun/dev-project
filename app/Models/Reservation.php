<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resource_id',
        'start_date',
        'end_date',
        'status',
        'justification',
        'response_message',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Relations
     */
    
    // Utilisateur qui a fait la réservation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Ressource réservée
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    
    // Qui a approuvé/refusé
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    // Incidents liés à cette réservation
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * Méthodes utiles
     */
    
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    public function isApproved()
    {
        return $this->status === 'approved';
    }
    
    public function isRefused()
    {
        return $this->status === 'refused';
    }
    
    public function isActive()
    {
        return $this->status === 'active';
    }
    
    public function isTerminated()
    {
        return $this->status === 'terminated';
    }
    
    // Durée en jours
    public function getDurationInDays()
    {
        return $this->start_date->diffInDays($this->end_date);
    }
    
    // Durée en heures
    public function getDurationInHours()
    {
        return $this->start_date->diffInHours($this->end_date);
    }
}
