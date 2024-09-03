<?php
session_start();
include 'conexion.php';

$correo = $_POST['correo'];
$clave = $_POST['clave'];

$query = "SELECT * FROM usuarios WHERE correo='$correo'";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
    if (password_verify($clave, $usuario['clave'])) {
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['rol'] = $usuario['rol'];
        
        if ($usuario['rol'] === 'admin') {
            header("Location: ../RyParfum.php");
        } else {
            header("Location: ../RyParfum.php");
        }
        exit();
    } else {
        echo '<script>
                alert("Contraseña incorrecta");
                window.location = "../login.php";
              </script>';
    }
} else {
    echo '<script>
            alert("El usuario no existe");
            window.location = "../login.php";
          </script>';
}
?>
