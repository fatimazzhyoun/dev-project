<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Champs remplissables
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'department',
    ];

    /**
     * Champs cachés
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversions de types
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relations
     */
    
    // Ressources supervisées (si responsable)
    public function supervisedResources()
    {
        return $this->hasMany(Resource::class, 'responsable_id');
    }
    
    // Réservations faites par cet utilisateur
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    // Réservations approuvées par cet utilisateur (si responsable)
    public function approvedReservations()
    {
        return $this->hasMany(Reservation::class, 'approved_by');
    }
    
    // Notifications reçues
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    
    // Maintenances créées
    public function createdMaintenances()
    {
        return $this->hasMany(ResourceMaintenance::class, 'created_by');
    }
    
    // Incidents signalés
    public function reportedIncidents()
    {
        return $this->hasMany(Incident::class, 'user_id');
    }
    
    // Incidents résolus (si responsable)
    public function resolvedIncidents()
    {
        return $this->hasMany(Incident::class, 'resolved_by');
    }
    
    // Demandes de compte traitées (si admin)
    public function reviewedAccountRequests()
    {
        return $this->hasMany(AccountRequest::class, 'reviewed_by');
    }
    
    // Actions dans l'audit log
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Méthodes utiles
     */
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isResponsable()
    {
        return $this->role === 'responsable';
    }
    
    public function isUser()
    {
        return $this->role === 'user';
    }
    
    public function isGuest()
    {
        return $this->role === 'guest';
    }
    
    public function isActive()
    {
        return $this->status === 'active';
    }
}
