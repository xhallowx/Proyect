<?php
include 'conexion.php';

if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM perfumes WHERE id = $id";
    mysqli_query($conexion, $query);

    header("Location: ../admin.php");
    exit();
}

?>
