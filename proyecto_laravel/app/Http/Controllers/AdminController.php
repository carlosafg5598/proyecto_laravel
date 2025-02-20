<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrador;
use App\Models\User;
use App\Models\Cliente;
use App\Models\AccionAdministrativa;

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
            $detalles = "Eliminado Cliente: {$cliente->user->name}, Email: {$cliente->user->email}";
            // Eliminar el cliente
            $cliente->delete();
            // Registrar acción en acciones_administrativas
            AccionAdministrativa::create([
                'admin_id' => auth()->id(),
                'cliente_id' => $id,
                'accion' => 'Eliminación',
                'detalles' => $detalles,
            ]);

            // Opcional: También eliminar el usuario vinculado
            $user = User::find($cliente->user_id);
            if ($user) {
                $user->delete();
            }

            return redirect()->route('admin.clientes')->with('success', 'Cliente eliminado correctamente.');
        }

        return redirect()->route('admin.clientes')->with('error', 'Cliente no encontrado.');
    }
    public function editCliente($id)
    {
        // Buscar el cliente y su usuario asociado
        $cliente = Cliente::with('user')->findOrFail($id);
        return view('admin.edit_cliente', compact('cliente'));
    }

    public function updateCliente(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        // Buscar el cliente y su usuario
        $cliente = Cliente::where('id', $id)->first();
        if (!$cliente) {
            return back()->withErrors(['error' => 'Cliente no encontrado']);
        }

        $user = User::where('id', $cliente->user_id)->first();
        if (!$user) {
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        }

        // Guardar datos antes de modificar
        $detalles = "Nombre: {$user->name} → {$request->input('name')}, ";
        $detalles .= "Email: {$user->email} → {$request->input('email')}, ";
        $detalles .= "Dirección: {$cliente->direccion} → {$request->input('direccion')}, ";
        $detalles .= "Teléfono: {$cliente->telefono} → {$request->input('telefono')}";

        // Actualizar datos en users
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Sincronizar el nombre en clientes
        $cliente->nombre = $request->input('name'); // ✅ Aquí sincronizamos el nombre
        $cliente->direccion = $request->input('direccion');
        $cliente->telefono = $request->input('telefono');
        $cliente->save();

        // Registrar acción en acciones_administrativas
        AccionAdministrativa::create([
            'admin_id' => auth()->id(),
            'cliente_id' => $cliente->id,
            'accion' => 'Edición',
            'detalles' => $detalles,
        ]);


        return redirect()->route('admin.clientes')->with('success', 'Cliente actualizado correctamente.');
    }


    // 🔹 Mostrar perfil del administrador
    public function profile()
    {
        $user = Auth::user();
        $admin = Administrador::where('user_id', $user->id)->first();

        return view('admin.profile', compact('user', 'admin'));
    }

    // 🔹 Actualizar perfil del administrador
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'departamento' => 'nullable|string|max:255',
        ]);

        // Obtener el usuario autenticado
        $user = User::find(Auth::id());

        if (!$user) {
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        }

        // Actualizar datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Actualizar datos del administrador
        $admin = Administrador::where('user_id', $user->id)->first();
        if ($admin) {
            $admin->nombre = $request->input('name');
            $admin->departamento = $request->input('departamento');
            $admin->save();
        }

        return redirect()->route('admin.profile')->with('success', 'Perfil actualizado correctamente.');
    }

    // 🔹 Cambiar contraseña del administrador
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!$user) {
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        }

        // Verificar que la contraseña actual es correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        // Actualizar la contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function historial()
    {
        $acciones = AccionAdministrativa::orderBy('created_at', 'desc')->get();
        return view('admin.historial', compact('acciones'));
    }
}
