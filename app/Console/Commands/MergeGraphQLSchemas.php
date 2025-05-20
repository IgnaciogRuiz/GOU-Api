<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MergeGraphQLSchemas extends Command
{
    protected $signature = 'graphql:merge-schemas';

    protected $description = 'Combina todos los archivos .graphql dentro de graphql/schemas en un solo archivo schema.graphql';

    public function handle()
    {
        $sourcePath = base_path('graphql/schemas');
        $outputPath = base_path('graphql/schema.graphql');

        if (!File::exists($sourcePath)) {
            $this->error("La carpeta {$sourcePath} no existe.");
            return Command::FAILURE;
        }

        $files = File::files($sourcePath);
        $schemaContent = '';

        foreach ($files as $file) {
            if ($file->getExtension() === 'graphql') {
                $this->line("Agregando: " . $file->getFilename());
                $schemaContent .= File::get($file->getRealPath()) . "\n\n";
            }
        }

        File::put($outputPath, $schemaContent);

        $this->info("Esquema combinado generado en: {$outputPath}");
        return Command::SUCCESS;
    }
}