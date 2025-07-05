<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'completed',
        'completed_at',
    ];

    // Convertir completed_at en instance Carbon
    protected $casts = [
        'completed_at' => 'datetime',
        'completed' => 'boolean',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthode pour marquer comme terminé
    public function markAsCompleted()
    {
        $this->update([
            'completed' => true,
            'completed_at' => now(),
        ]);
    }

    // Méthode pour marquer comme non terminé
    public function markAsIncomplete()
    {
        $this->update([
            'completed' => false,
            'completed_at' => null,
        ]);
    }
}
