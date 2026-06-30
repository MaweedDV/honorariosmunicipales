<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('funcionarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre_funcionario' => 'required|string|max:255',
            'rut_funcionario' => 'required|string|max:12',
            'fecha_ingreso' => 'required|date',
            'fecha_termino' => 'nullable|date|after_or_equal:fecha_ingreso',
        ]);

        // Aquí puedes guardar los datos en la base de datos o realizar otras acciones necesarias
        Funcionario::create([
            'nombre' => $validatedData['nombre_funcionario'],
            'rut' => $validatedData['rut_funcionario'],
            'fecha_ingreso' => $validatedData['fecha_ingreso'],
            'fecha_termino' => $validatedData['fecha_termino'] ?? null,
        ]);

        // Redirigir a una página de éxito o mostrar un mensaje de éxito
        return redirect()->route('honorario.create')->with('success', 'Funcionario agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
