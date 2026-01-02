<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResourceCategory;
use App\Models\Maintenance;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'cpu',
        'ram',
        'storage',
        'bandwidth',
        'os',
        'ip_address',
        'location',
        'status',
        'responsable_id',
        'category_id',
    ];

    /**
     * Relations
     */
    
    // Responsable de cette ressource
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
    
    // Catégorie de cette ressource
    public function category()
    {
        return $this->belongsTo(ResourceCategory::class, 'category_id');
    }
    
    // Réservations de cette ressource
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    // Maintenances de cette ressource
    public function maintenances()
    {
        return $this->hasMany(ResourceMaintenance::class);
    }
    
    // Incidents liés à cette ressource
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * Méthodes utiles
     */
    
    public function isAvailable()
    {
        return $this->status === 'disponible';
    }
    
    public function isReserved()
    {
        return $this->status === 'reserve';
    }
    
    public function isInMaintenance()
    {
        return $this->status === 'maintenance';
    }
    
    // Vérifier si disponible pour une période
    public function isAvailableForPeriod($startDate, $endDate)
    {
        // Vérifier si en maintenance
        $hasMaintenance = $this->maintenances()
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();
        
        if ($hasMaintenance) {
            return false;
        }
        
        // Vérifier si déjà réservée
        $hasReservation = $this->reservations()
            ->whereIn('status', ['approved', 'active'])
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();
        
        return !$hasReservation;
    }
    
    // Réservations actives
    public function activeReservations()
    {
        return $this->reservations()->where('status', 'active');
    }

    // Cette fonction permet de dire : "Une ressource APPARTIENT À une catégorie"
   public function ResourceCategory() {
    return $this->belongsTo(ResourceCategory::class, 'category_id');
    }
}
