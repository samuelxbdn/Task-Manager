<?php


$sapi = php_sapi_name();

if ($sapi != 'cli') {
    echo "No estás utilizando el cliente correcto para el programa.\n";
} else {

echo "\nBienvenido al gestor de tareas.\n";

while(true){
    echo "Introduce tu nombre.\n";
    $usuario = trim(fgets(STDIN));

    echo "Estás seguro que lo has escrito correctamente?: $usuario \n";
    echo "1. Si\n";
    echo "2. No\n";
    $confirmacion= trim(fgets(STDIN));
    if($confirmacion == '1'){
    break;
    }
}

$nombre=[];

if(file_exists("config/config.yaml")){

$archivoYaml = file_get_contents("config/config.yaml");

$configuracion = yaml_parse($archivoYaml);
$nombre = $configuracion["nombre"];

}

if (in_array($usuario,$nombre)){
    $key=intval(array_search($usuario,$nombre));
    $metodo = $configuracion[$nombre[$key]];

}

else{
    echo "\nVeo que es tu primera vez por aquí, que método de almacenamiento deseas usar.\n";

    while (true){
    echo "Escriba csv o json.\n"; 
    $metodo = trim(fgets(STDIN));
    if($metodo == "csv" || $metodo == "json"){
        break;
    }else{
        echo "Método incorrecto.\n";
    }
    }

    $nombre[] = $usuario;
    $configuracion["nombre"] = $nombre;
    $configuracion[$usuario] = $metodo;

    $introYaml=yaml_emit($configuracion);
    file_put_contents("config/config.yaml",$introYaml);
    }

    if ($metodo == 'csv') {
        include 'funcions csv.php';
        $archivoTareas = "config/csv/$usuario.csv";
        if(!file_exists($archivoTareas)){
            $tareas=fopen($archivoTareas,'w');
        }

    }elseif($metodo == 'json'){
    include 'funcions json.php';
    $archivoTareas = "config/json/$usuario.json";

if (!file_exists($archivoTareas)) {
    file_put_contents($archivoTareas, json_encode([]));
}
    }
        $tareas = cargarTareas($archivoTareas);   

        while (true) {

        echo "\nBienvenido $usuario, seleccione con su correspondiente número que desea realizar:\n";
        echo "1. Mostrar tareas\n";
        echo "2. Añadir tarea\n";
        echo "3. Completar tarea\n";
        echo "4. Eliminar tarea\n";
        echo "5. Salir\n";
        

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