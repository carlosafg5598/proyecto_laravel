<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Obtener todos los clientes con su información de usuario
        $clientes = Cliente::with('user')->get();

        return view('admin.clientes', compact('clientes'));
    }

    public function destroyCliente($id)
    {
        // Buscar el cliente
        $cliente = Cliente::find($id);

        if ($cliente) {
            // Eliminar el cliente
            $cliente->delete();

            // Opcional: También eliminar el usuario vinculado
            $user = User::find($cliente->user_id);
            if ($user) {
                $user->delete();
            }

            return redirect()->route('admin.clientes')->with('success', 'Cliente eliminado correctamente.');
        }

        return redirect()->route('admin.clientes')->with('error', 'Cliente no encontrado.');
    }
}
