<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;
    protected $table = 'administradores';
    protected $fillable = ['user_id', 'departamento'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getNombreAttribute()
    {
        return $this->user ? $this->user->name : 'Sin nombre';
    }
}
