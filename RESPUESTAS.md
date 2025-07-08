# Respuestas

## 1. Función de Agrupamiento de Tareas

Desarrollé un comando Laravel (`tasks:group`) que agrupa tareas por estado. El comando incluye dos implementaciones diferentes:

> **Archivo:** [app/Console/Commands/GroupTasksCommand.php](app/Console/Commands/GroupTasksCommand.php)

### Implementación con Collections de Laravel
```php
private function groupTasksByStatus(array $tasks): array
{
    return collect($tasks)
        ->groupBy('estado')
        ->map(function ($group) {
            return $group->pluck('titulo')->values();
        })
        ->toArray();
}
```

### Implementación con PHP Puro
```php
private function groupTasksByStatusPurePHP(array $tasks): array
{
    $grouped = [];
    
    foreach ($tasks as $task) {
        $grouped[$task['estado']][] = $task['titulo'];
    }
    
    return $grouped;
}
```

**Uso del comando:**
```bash
# Usando Laravel Collections (por defecto)
php artisan tasks:group

# Usando PHP puro
php artisan tasks:group --pure-php
```

**Salida esperada:**
```json
{
    "pendiente": [
        "Tarea A",
        "Tarea C",
        "Tarea F",
        "Tarea I"
    ],
    "completada": [
        "Tarea B",
        "Tarea E",
        "Tarea H",
        "Tarea K"
    ],
    "en progreso": [
        "Tarea D",
        "Tarea G",
        "Tarea J"
    ]
}
```


## 2. Análisis de Código Laravel

El fragmento de código:
```php
collect([1, 2, 3, 4])
    ->map(fn($n) => $n * 2)
    ->filter(fn($n) => $n > 5)
    ->values()
    ->all();
```

**Devuelve:** `[6, 8]`

**Razonamiento:**
1. `collect([1, 2, 3, 4])` - Crea una colección con todos los elementos del array, en este caso los números 1, 2, 3, 4
2. `->map(fn($n) => $n * 2)` - Multiplica cada número por 2: [2, 4, 6, 8]
3. `->filter(fn($n) => $n > 5)` - Filtra solo los números mayores a 5: [6, 8]
4. `->values()` - Re-indexa las claves numéricamente (0, 1, 2...)
5. `->all()` - Convierte la colección a un array

## 3. Mejoras de Rendimiento en Laravel

Para mejorar el rendimiento de un sistema Laravel con muchas consultas a base de datos:

1. **Eager Loading** - Usar `with()` para cargar relaciones y evitar el problema N+1:
   ```php
    User::with('tasks.comments')->paginate(20);
   ```

2. **Query Caching** - Implementar cache de las consultas:
   ```php
    $users = Cache::remember('users_list', now()->addMinutes(10), function () {
        return User::select('id', 'name', 'email')->get();
    });
   ```

3. **Database Indexing** - Crear índices en columnas frecuentemente consultadas:
   ```php
    Schema::table('users', function (Blueprint $table) {
        $table->index(['email', 'created_at']);
    });
   ```

4. **Procesamiento en Lotes** - chunkById()
   ```php
    User::select('id', 'name')
        ->where('active', true)
        ->orderBy('id')
        ->chunkById(100, function ($usersChunk) {
            foreach ($usersChunk as $user) {
                //...
            }
        });
   ```

5. **Query Optimization** - Traer solo columnas necesarias:
   ```php
        $users = User::select('id', 'name', 'email')
        ->where('verified', true)
        ->with(['tasks' => function ($query) {
            $query->select('id', 'user_id', 'title', 'status')
                ->where('status', 'pending');
        }])
        ->paginate(20);
   ```

6. **Jobs** - Mover consultas pesadas a jobs en cola para no bloquear la respuesta HTTP.