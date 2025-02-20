<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionAdministrativa extends Model
{
    use HasFactory;
    protected $table = 'acciones_administrativas';//TODO ARREGLAR AL ELIMINAR UN USUARIO QUE NO FALLE

    protected $fillable = ['admin_id', 'cliente_id', 'otro_admin_id', 'accion', 'detalles'];

    // Relación con el administrador que hizo el cambio
    public function administrador()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relación con el cliente afectado
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con otro administrador afectado
    public function otroAdmin()
    {
        return $this->belongsTo(Administrador::class, 'otro_admin_id');
    }
}
