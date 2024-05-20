<?php
function cargarTareas($archivo) {
    $tareas = [];
    if (($gestor = fopen($archivo, "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
            $tareas[] = $datos;
        }
        fclose($gestor);
    }
    return $tareas;
}


function guardarTareas($archivo, $tareas) {
    if (($gestor = fopen($archivo, "w")) !== FALSE) {
        foreach ($tareas as $tarea) {
            fputcsv($gestor, $tarea);
        }
        fclose($gestor);
    }
}


function mostrarTareas($tareas) {
    echo "Tareas:\n";
    foreach ($tareas as $index => $tarea) {
        echo $index + 1 . ". {$tarea[0]} - {$tarea[1]}\n";
    }
}
?>
