<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Escrituras\Volumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateBooksJson extends Command
{
    protected $signature = 'generate:books-json';
    protected $description = 'Generate JSON files for all volumes';

    public function handle()
    {
        // Obtener todos los volúmenes con sus relaciones
        $volumenes = Volumen::with(['divisiones.libros.capitulos.versiculos', 'divisiones.libros.capitulos.parte', 'divisiones.libros.capitulos.versiculos.pericopa'])->get();

        // Crear directorio para los archivos JSON
        $directory = 'volumes_json';
        if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory);
            $this->info("Directory '{$directory}' created.");
        } else {
            $this->info("Directory '{$directory}' already exists.");
        }

        // Recorrer cada volumen y generar su archivo JSON
        foreach ($volumenes as $volumen) {
            $libros = $volumen->divisiones->flatMap(function($division) {
                return $division->libros->map(function($libro) use ($division) {
                    return [
                        'id' => $libro->id,
                        'nombre' => $libro->nombre,
                        'abreviatura' => $libro->abreviatura,
                        'division_id' => $division->id,
                        'division_nombre' => $division->nombre,
                        'capitulos' => $libro->capitulos->map(function($capitulo) {
                            return [
                                'id' => $capitulo->id,
                                'num_capitulo' => $capitulo->num_capitulo,
                                'referencia' => $capitulo->referencia,
                                'parte_id' => $capitulo->parte_id,
                                'parte_nombre' => $capitulo->parte ? $capitulo->parte->nombre : null,
                                'versiculos' => $capitulo->versiculos->map(function($versiculo) {
                                    return [
                                        'id' => $versiculo->id,
                                        'num_versiculo' => $versiculo->num_versiculo,
                                        'contenido' => $versiculo->contenido,
                                        'referencia' => $versiculo->referencia,
                                        'pericopa_id' => $versiculo->pericopa_id,
                                        'pericopa_nombre' => $versiculo->pericopa ? $versiculo->pericopa->nombre : null,
                                    ];
                                })->toArray(),
                            ];
                        })->toArray(),
                    ];
                });
            })->toArray();

            if (Str::slug($volumen->nombre) === 'antiguo-testamento') {
                // Definir el tamaño de cada chunk
                $chunkSize = ceil(count($libros) / 3);

                // Dividir los libros en chunks
                $chunks = array_chunk($libros, $chunkSize);

                foreach ($chunks as $index => $chunk) {
                    $data = [
                        'id' => $volumen->id,
                        'nombre' => $volumen->nombre,
                        'libros' => $chunk,
                    ];

                    // Convertir los datos a formato JSON
                    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Crear el nombre del archivo basado en el slug del nombre del volumen y el número de chunk
                    $filename = Str::slug($volumen->nombre) . '-' . ($index + 1) . '.json';

                    // Guardar el archivo JSON en el directorio especificado
                    $filePath = "{$directory}/{$filename}";
                    Storage::disk('local')->put($filePath, $json);

                    // Verificar si el archivo se guardó correctamente
                    if (Storage::disk('local')->exists($filePath)) {
                        $this->info("File '{$filePath}' created successfully.");
                    } else {
                        $this->error("Failed to create file '{$filePath}'.");
                    }
                }
            } else {
                $data = [
                    'id' => $volumen->id,
                    'nombre' => $volumen->nombre,
                    'libros' => $libros,
                ];

                // Convertir los datos a formato JSON
                $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                // Crear el nombre del archivo basado en el slug del nombre del volumen
                $filename = Str::slug($volumen->nombre) . '.json';

                // Guardar el archivo JSON en el directorio especificado
                $filePath = "{$directory}/{$filename}";
                Storage::disk('local')->put($filePath, $json);

                // Verificar si el archivo se guardó correctamente
                if (Storage::disk('local')->exists($filePath)) {
                    $this->info("File '{$filePath}' created successfully.");
                } else {
                    $this->error("Failed to create file '{$filePath}'.");
                }
            }
        }

        $this->info('JSON files generated successfully for all volumes.');
    }
}
