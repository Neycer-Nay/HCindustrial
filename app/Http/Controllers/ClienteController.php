<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::orderBy('id', 'desc');

        // Si hay búsqueda, filtra por nombre o teléfonos
    if ($request->filled('buscar')) {
        $busqueda = $request->buscar;
        $query->where(function($q) use ($busqueda) {
            $q->where('nombre', 'like', '%' . $busqueda . '%')
              ->orWhere('telefono_1', 'like', '%' . $busqueda . '%')
              ->orWhere('telefono_2', 'like', '%' . $busqueda . '%')
              ->orWhere('telefono_3', 'like', '%' . $busqueda . '%')
              ->orWhere('numero_documento', 'like', '%' . $busqueda . '%');
        });
    }

        // Mantén el término de búsqueda en la paginación
        $clientes = $query->paginate(10)->appends($request->only('buscar'));

        return view('modules.clientes.showClientes', compact('clientes'));
    }
    

   
    public function create()
    {

    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:PERSONA,EMPRESA',
            'tipo_documento' => 'required|in:CI,NIT,PASAPORTE,OTRO',
            'numero_documento' => 'required|string|unique:clientes,numero_documento|max:50',
            'telefono_1' => 'required|string|max:20',
            'telefono_2' => 'nullable|string|max:20',
            'telefono_3' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'ciudad' => 'nullable|string|max:100',
            'direccion' => 'required|string|max:255',
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'tipo.required' => 'El tipo de cliente es obligatorio.',
                'tipo_documento.required' => 'El tipo de documento esta dublicado.',
                'numero_documento.unique' => 'Este número de documento ya está registrado para otro cliente.',
                'telefono_1.required' => 'El teléfono 1 es obligatorio.',
                'direccion.required' => 'La dirección es obligatoria.',
            ]);

            $cliente = Cliente::create($validated);

            return redirect()->route('recepciones.create', ['cliente_id' => $cliente->id])
            ->with('success', 'Cliente registrado correctamente.');


    }

    public function show(Cliente $cliente)
    {
         // Carga equipos con fotos y recepciones relacionadas
    $cliente->load([
        'equipos.fotos',
        'recepciones'
    ]);
    return view('modules.clientes.VerClienteEquipo', compact('cliente'));
        
    }

}
