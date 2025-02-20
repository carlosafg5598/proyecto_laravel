<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['user_id', 'nombre', 'direccion', 'telefono'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getNombreAttribute()
    {
        return $this->user ? $this->user->name : 'Sin nombre';
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($cliente) {
            if ($cliente->user) {
                $cliente->user->delete(); // Eliminar manualmente el usuario al eliminar el cliente
            }
        });
    }
}
