<?php
function cargarTareas($archivo) {
    $tareas = [];
    if (file_exists($archivo)) {
        $json = file_get_contents($archivo);
        $tareas = json_decode($json, true);
    }
    return $tareas;
}

function guardarTareas($archivo, $tareas) {
    $json = json_encode($tareas);
    file_put_contents($archivo, $json);
}

function mostrarTareas($tareas) {
    echo "Tareas:\n";
    foreach ($tareas as $index => $tarea) {
        echo $index + 1 . ". {$tarea[0]} - {$tarea[1]}\n";
    }
}
?>
