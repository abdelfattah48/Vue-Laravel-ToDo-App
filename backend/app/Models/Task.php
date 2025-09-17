<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Colonnes qui peuvent être remplies
    protected $fillable = ['title', 'description', 'done', 'user_id'];
    protected $casts = [
        'done' => 'boolean',
    ];
    //une tâche appartient à un utilisateur
    public function user() {
        return $this->belongsTo(User::class);
    }

}
