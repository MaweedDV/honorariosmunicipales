<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    // public function ver($archivo)
    // {
    //     // Intentar diferentes rutas posibles
    //     $rutasPosibles = [
    //         storage_path('app/public/' . $archivo),
    //         storage_path('app/' . $archivo),
    //         public_path('storage/' . $archivo),
    //         public_path($archivo),
    //     ];

    //     foreach ($rutasPosibles as $ruta) {
    //         if (file_exists($ruta)) {
    //             return response()->file($ruta, [
    //                 'Content-Type' => 'application/pdf',
    //                 'Content-Disposition' => 'inline; filename="' . basename($archivo) . '"'
    //             ]);
    //         }
    //     }

    //     // Si no se encuentra en ninguna ruta
    //     abort(404, 'El archivo PDF no existe en ninguna ubicación');
    // }

    // En tu controlador
    public function ver($id)
    {
        $pdf = Informe::find($id);

        $url = $pdf->pdf;

        $path1 = Storage::disk('public')->path($url);

        return response()->file($path1);

    }

    // En tu controlador, agrega debug
    public function mostrarPDF($id)
    {
        $documento = Informe::find($id);

        // Verifica la ruta completa
        $rutaCompleta = storage_path('app/public/pdfs_honorarios/' . $documento->pdf);
        Log::info('Ruta del PDF: ' . $rutaCompleta);
        Log::info('¿Existe? ' . (file_exists($rutaCompleta) ? 'Sí' : 'No'));

        // Si no existe, intenta con diferentes rutas
        if (!file_exists($rutaCompleta)) {
            // Probar con public_path
            $rutaPublic = public_path('storage/pdfs_honorarios/' . $documento->pdf);
            if (file_exists($rutaPublic)) {
                return response()->file($rutaPublic);
            }

            abort(404, 'PDF no encontrado');
        }

        return response()->file($rutaCompleta);
    }

    // En un Helper o Controlador
    public function servirPDF($ruta)
    {
        $path = storage_path('app/public/' . $ruta);

        // Verificar si existe
        if (!Storage::disk('public')->exists($ruta)) {
            // Intentar con otra ruta
            if (file_exists(public_path($ruta))) {
                return response()->file(public_path($ruta));
            }
            abort(404, 'Archivo no encontrado');
        }

        // Devolver el archivo
        return response()->file($path);
    }
}
