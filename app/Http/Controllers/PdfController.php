<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function ver($archivo)
    {
        // Intentar diferentes rutas posibles
        $rutasPosibles = [
            storage_path('app/public/' . $archivo),
            storage_path('app/' . $archivo),
            public_path('storage/' . $archivo),
            public_path($archivo),
        ];

        foreach ($rutasPosibles as $ruta) {
            if (file_exists($ruta)) {
                return response()->file($ruta, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($archivo) . '"'
                ]);
            }
        }

        // Si no se encuentra en ninguna ruta
        abort(404, 'El archivo PDF no existe en ninguna ubicación');
    }
}
