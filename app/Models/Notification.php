<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'related_id',
        'related_type',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
    
    // Pas besoin de updated_at pour les notifications
    public $timestamps = false;
    
    // Mais on garde created_at
    const CREATED_AT = 'created_at';

    /**
     * Relations
     */
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Méthodes utiles
     */
    
    public function isRead()
    {
        return $this->read_at !== null;
    }
    
    public function isUnread()
    {
        return $this->read_at === null;
    }
    
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }
    
    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
    }
}