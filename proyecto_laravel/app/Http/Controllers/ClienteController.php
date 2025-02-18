<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;
use App\Models\User;

class ClienteController extends Controller
{
    public function profile()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        $cliente = Cliente::where('user_id', $user->id)->first();

        return view('cliente.profile', compact('user', 'cliente'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        // Obtener el usuario autenticado
        $user = User::find(Auth::id());

        if (!$user) {
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        }

        // Actualizar el usuario en la tabla users
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Obtener el cliente y actualizar también su nombre
        $cliente = Cliente::where('user_id', $user->id)->first();
        if ($cliente) {
            $cliente->nombre = $request->input('name'); // 💡 También actualizamos el nombre en `clientes`
            $cliente->direccion = $request->input('direccion');
            $cliente->telefono = $request->input('telefono');
            $cliente->save();
        }

        return redirect()->route('cliente.profile')->with('success', 'Perfil actualizado correctamente.');
    }




    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Asegurar que el usuario está autenticado y es un modelo válido
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
        $user->save(); // ✅ Laravel ahora reconoce `save()`

        return redirect()->route('cliente.profile')->with('success', 'Contraseña actualizada correctamente.');
    }


    public function destroy()
    {
        $user = User::find(Auth::id()); // 💡 Obtener el usuario de la base de datos

        if (!$user) {
            return redirect('/')->withErrors(['error' => 'Usuario no encontrado']);
        }

        // Obtener el cliente y eliminarlo
        $cliente = Cliente::where('user_id', $user->id)->first();
        if ($cliente) {
            $cliente->delete();
        }

        // Ahora podemos eliminar el usuario de forma segura
        $user->delete();

        return redirect('/')->with('success', 'Cuenta eliminada correctamente.');
    }
}
