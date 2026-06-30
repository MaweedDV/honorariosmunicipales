<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HonorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexForm()
    {
        $pagos = Informe::with('funcionario')->get();


        return view('formRegistrosAdm.index', compact('pagos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $funcionarios = Funcionario::all();

        return view('formRegistrosAdm.create', compact('funcionarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'valor_pagado' => 'required|numeric|min:0',
            'mes_pago' => 'required',
            'pdf_honorario' => 'nullable|file|mimes:pdf|max:20480', // 20MB máximo
        ]);

        // Procesar el archivo PDF
        $rutaPdf = null;
        if ($request->hasFile('pdf_honorario')) {
            $archivo = $request->file('pdf_honorario');

            // Opción 1: Guardar con nombre original (puede causar duplicados)
            // $rutaPdf = $archivo->store('pdfs_honorarios', 'public');

            // Opción 2: Guardar con nombre único (recomendado)
            $nombreOriginal = $archivo->getClientOriginalName();
            $nombreUnico = time() . '_' . $nombreOriginal;
            $rutaPdf = $archivo->storeAs('pdfs_honorarios', $nombreUnico, 'public');

            // Opción 3: Guardar con nombre personalizado (ej: funcionario_id_mes.pdf)
            // $nombrePersonalizado = $validatedData['funcionario_id'] . '_' . $validatedData['mes_pago'] . '.pdf';
            // $rutaPdf = $archivo->storeAs('pdfs_honorarios', $nombrePersonalizado, 'public');
        }

        // Guardar en la base de datos
        Informe::create([
            'id_funcionario' => $validatedData['funcionario_id'],
            'valor_pagado' => $validatedData['valor_pagado'],
            'mes_pago' => $validatedData['mes_pago'],
            'pdf' => $rutaPdf, // Guarda la ruta del archivo
        ]);

        return redirect()->route('honorario.indexForm')
            ->with('success', 'Honorario registrado exitosamente.');
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
   public function update(Request $request, $id)
    {
        $informe = Informe::findOrFail($id);

        $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'valor_pagado' => 'required|numeric|min:0',
            'mes_pago' => 'required',
            'pdf_honorario' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // Si se sube un nuevo PDF, eliminar el anterior y guardar el nuevo
        if ($request->hasFile('pdf_honorario')) {
            // Eliminar PDF anterior
            if ($informe->pdf_honorario) {
                Storage::disk('public')->delete($informe->pdf_honorario);
            }

            // Guardar nuevo PDF
            $archivo = $request->file('pdf_honorario');
            $nombreUnico = time() . '_' . $archivo->getClientOriginalName();
            $rutaPdf = $archivo->storeAs('pdfs_honorarios', $nombreUnico, 'public');
        } else {
            $rutaPdf = $informe->pdf_honorario; // Mantener el PDF existente
        }

        $informe->update([
            'id_funcionario' => $request->funcionario_id,
            'valor_pagado' => $request->valor_pagado,
            'mes_pago' => $request->mes_pago,
            'pdf' => $rutaPdf,
        ]);

        return redirect()->route('honorario.indexForm')
            ->with('success', 'Honorario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
