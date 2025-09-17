<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    //Colonnes que l’on peut modifier
    protected $fillable = [
        'full_name', 'email', 'phone', 'address', 'image', 'password'
    ];
    // Colonnes cachées lors de l’envoi à l’API
    protected $hidden = ['password'];

    // Méthodes JWT
    public function getJWTIdentifier() { return $this->getKey(); }
    public function getJWTCustomClaims() { return []; }

    // Relation : un utilisateur peut avoir plusieurs tâches
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
