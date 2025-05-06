<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class appiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        //$reponse=Http::get("http://23.22.129.201:80/");
        //$posts=$reponse->json();
        //$image=Http::get("https://httpbin.org/image/png");
        //$imageData = base64_encode($image->body());
        $imageUrl = Storage::disk('s3')->files('images');
        $imageUrl = array_map(function ($file) {
            return Storage::disk('s3')->url($file);
        }, $imageUrl);
        return view("dashboard",compact("imageUrl"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function procesarImagen(Request $request){
        $request->validate([
            'image_url' => 'required|url',
        ]);
        try {
            // 1. Obtener la imagen desde la URL
            $imageContent = file_get_contents($request->image_url);
            
            if (!$imageContent) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo obtener la imagen'
                ], 400);
            }
    
            // 2. Crear un nombre temporal para el archivo
            $tempFileName = 'temp_' . uniqid() . '.jpg';
            $tempFilePath = sys_get_temp_dir() . '/' . $tempFileName;
            
            // 3. Guardar temporalmente
            file_put_contents($tempFilePath, $imageContent);
    
            // 4. Enviar a tu API de procesamiento
            $response = Http::attach(
                'file', 
                file_get_contents($tempFilePath),
                $tempFileName
            )->post("http://23.22.129.201:80/image");
    
            // 5. Eliminar archivo temporal
            unlink($tempFilePath);
    
            // 6. Procesar respuesta
            $processedImage = 'data:image/jpeg;base64,' . base64_encode($response->body());
    
            return response()->json([
                'success' => true,
                'processed_image' => $processedImage
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function create()
    {
        //
        return  "hola mundo";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('image')) {
           return back()->with('error', 'No se envió ninguna imagen.');
        }
    
        $file = $request->file('image');


        $response = Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post("http://23.22.129.201:80/image");
        $imageData = base64_encode($response->body());
        $image = 'data:image/jpeg;base64,' . $imageData;

        //$image = $response->json()['files']['image'] ?? null;
        //$image = $response['image_url'] ?? null;

        return view('formulario',compact("image"));
    
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
