<?php

include 'funcions.php';

$archivoTareas = "tareas.csv";


$tareas = cargarTareas($archivoTareas);

$sapi = php_sapi_name();

if ($sapi != 'cli') {
    echo "No estás utilizando el cliente correcto para el programa.\n";
} else {
   

while (true) {

    echo "\n";
    echo "1. Mostrar tareas\n";
    echo "2. Añadir tarea\n";
    echo "3. Completar tarea\n";
    echo "4. Eliminar tarea\n";
    echo "5. Salir\n";
    echo "Elija una opción: ";
    

    $opcion = trim(fgets(STDIN));
    
    switch ($opcion) {

        case '1':
            mostrarTareas($tareas);
            break;

        case '2':
            echo "Ingrese el nombre de la tarea: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese la descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));
            $tareas[] = [$nombre, $descripcion];
            guardarTareas($archivoTareas, $tareas);
            echo "Tarea añadida exitosamente.\n";
            break;
            
        case '3':
            mostrarTareas($tareas);
            echo "Ingrese el número de la tarea que desea completar:";
            $indice = intval(trim(fgets(STDIN))) - 1;
            if (isset($tareas[$indice])) {
                $nombre=$tareas[$indice][0];
                $descripcion = "Completada";
                $tareas[$indice] = [$nombre, $descripcion];
                guardarTareas($archivoTareas, $tareas);
                echo "Tarea modificada exitosamente.\n";
            } else {
                echo "Índice de tarea no válido.\n";
            }
            break;

        case '4':
            mostrarTareas($tareas);
            echo "Ingrese el número de la tarea que desea eliminar: ";
            $indice = intval(trim(fgets(STDIN))) - 1;
            if (isset($tareas[$indice])) {
                array_splice($tareas, $indice, 1);
                guardarTareas($archivoTareas, $tareas);
                echo "Tarea eliminada exitosamente.\n";
            } else {
                echo "Índice de tarea no válido.\n";
            }
            break;
        case '5':
            echo "¡Hasta luego!\n";
            exit();
        default:
            echo "Opción no válida. Por favor, elija una opción del menú.\n";
            break;
    }
}
}
?>
