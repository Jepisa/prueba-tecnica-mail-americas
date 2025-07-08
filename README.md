# Prueba Técnica Laravel SR

![alt text](image.png)

## Prueba Técnica – Desarrollador Laravel Senior

⏱️ **Duración:** 30–45 minutos  
🛠️ **Modalidad:** Individual, con acceso a documentación  
✅ **Consigna:** Queremos validar tu conocimiento práctico y tu lógica con Laravel.

## 1. Función de Agrupamiento de Tareas

Crea una función en Laravel (puede estar en un controller, command o clase simple) que reciba un array de tareas como este:

```php
$tareas = [
    ['titulo' => 'Tarea A', 'estado' => 'pendiente'],
    ['titulo' => 'Tarea B', 'estado' => 'completada'],
    ['titulo' => 'Tarea C', 'estado' => 'pendiente'],
];
```

Y devuelva una respuesta JSON agrupando las tareas por estado, así:

```json
{
    "pendiente": [
        "Tarea A",
        "Tarea C"
    ],
    "completada": [
        "Tarea B"
    ]
}
```

📌 **Bonus** si usa colecciones de Laravel de forma elegante.

## 2. Análisis de Código Laravel

¿Qué devuelve este fragmento de código y por qué?

```php
collect([1, 2, 3, 4])
    ->map(fn($n) => $n * 2)
    ->filter(fn($n) => $n > 5)
    ->values()
    ->all();
```

✍️ **Explicá** brevemente tu razonamiento.

## 3. (Opcional) Mejora de rendimiento en Laravel

¿Qué harías para mejorar el rendimiento de un sistema Laravel con muchas consultas a base de datos? Una breve lista con 3 o más ideas concretas.

---

## 📋 Respuestas

Las respuestas a esta prueba técnica se encuentran en: [RESPUESTAS.md](RESPUESTAS.md)