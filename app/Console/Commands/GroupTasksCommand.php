<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GroupTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:group {--pure-php : Use pure PHP instead of Laravel collections}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Groups tasks by status and returns JSON response. Use --pure-php flag for pure PHP implementation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = [
            ['titulo' => 'Tarea A', 'estado' => 'pendiente'],
            ['titulo' => 'Tarea B', 'estado' => 'completada'],
            ['titulo' => 'Tarea C', 'estado' => 'pendiente'],
            ['titulo' => 'Tarea D', 'estado' => 'en progreso'],
            ['titulo' => 'Tarea E', 'estado' => 'completada'],
            ['titulo' => 'Tarea F', 'estado' => 'pendiente'],
            ['titulo' => 'Tarea G', 'estado' => 'en progreso'],
            ['titulo' => 'Tarea H', 'estado' => 'completada'],
            ['titulo' => 'Tarea I', 'estado' => 'pendiente'],
            ['titulo' => 'Tarea J', 'estado' => 'en progreso'],
            ['titulo' => 'Tarea K', 'estado' => 'completada']
        ];

        $usePurePhp = $this->option('pure-php');
        
        $groupedTasks = $usePurePhp 
            ? $this->groupTasksByStatusPurePHP($tasks)
            : $this->groupTasksByStatus($tasks);
            
        $method = $usePurePhp ? 'Pure PHP' : 'Laravel Collections';
        $this->info("Using: {$method}");

        $this->info(json_encode($groupedTasks, JSON_PRETTY_PRINT));
    }

    private function groupTasksByStatus(array $tasks): array
    {
        return collect($tasks)
            ->groupBy('estado')
            ->map(function ($group) {
                return $group->pluck('titulo')->values();
            })
            ->toArray();
    }

    private function groupTasksByStatusPurePHP(array $tasks): array
    {
        $grouped = [];
        
        foreach ($tasks as $task) {
            $grouped[$task['estado']][] = $task['titulo'];
        }
        
        return $grouped;
    }
}
