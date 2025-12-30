<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'department',
        'requested_role',
        'justification',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
        'created_user_id',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relations
     */
    
    // Admin qui a traité la demande
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    
    // Compte créé suite à cette demande
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
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
    
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}