<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resource_id',
        'reservation_id',
        'title',
        'description',
        'priority',
        'status',
        'resolved_by',
        'resolved_at',
        'resolution_notes',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Relations
     */
    
    // Qui a signalé
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Ressource concernée
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    
    // Réservation liée (optionnel)
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    
    // Qui a résolu
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Méthodes utiles
     */
    
    public function isOpen()
    {
        return $this->status === 'open';
    }
    
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }
    
    public function isResolved()
    {
        return $this->status === 'resolved';
    }
    
    public function isClosed()
    {
        return $this->status === 'closed';
    }
    
    public function isCritical()
    {
        return $this->priority === 'critical';
    }
    
    public function isHigh()
    {
        return $this->priority === 'high';
    }
}
