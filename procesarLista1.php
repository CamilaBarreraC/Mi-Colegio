<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->
<?php
// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Aquí se ingresa el nombre que se almacenó en el span, el cual es el seleccionado en select
    $nombre_curso = $_POST['ingresoNombreCurso'];
    $id_colegio = $_POST['id_colegio'];
    $id_curso = $_POST['id_curso'];
    
    // Se concatena lista, para así evitar la redundancia de datos
    // Se ingresa "Lista (Nombre curso seleccionado por usuario)" a la base de datos
    $texto = "Lista";
    $nombre_lista = $texto . " " . $nombre_curso;

    require_once ('controlador/crud_lista1/controlador_lista1.php');
    $obj = new ControladorLista1();

    // Insertar el colegio en la base de datos
    $obj->insertarLista1($nombre_lista, $id_colegio, $id_curso);
}
?>