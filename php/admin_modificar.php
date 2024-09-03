<?php
session_start();

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../RyParfum.php");
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $query = "SELECT * FROM perfumes WHERE id = $id";
    $result = mysqli_query($conexion, $query);
    $perfumes = mysqli_fetch_assoc($result);
    
    if (!$perfumes) {
        echo "Perfume no encontrado.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guardar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    
    $imagen = $_FILES['imagen']['name'];
    $target_dir = "../assets/images/";
    $target_file = $target_dir . basename($imagen);

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
        $query = "UPDATE perfumes SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen' WHERE id=$id";
    } else {
        $query = "UPDATE perfumes SET nombre='$nombre', descripcion='$descripcion', precio='$precio' WHERE id=$id";
    }

    if (mysqli_query($conexion, $query)) {
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Error al actualizar el perfume: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Perfume</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <link rel="icon" type="image/x-icon" href="../assets/images/BZ.ico" />
    <style>
        body {
            font-family: 'PT Sans', sans-serif;
            background: #1a1a1a;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: linear-gradient(145deg, #222, #1a1a1a);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 5px 5px 15px #000, -5px -5px 15px #2a2a2a;
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
            filter: drop-shadow(0px 0px 10px #00FED7);
            margin-right: 50px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
            background: #333;
            color: #fff;
            box-shadow: inset 2px 2px 5px #000, inset -2px -2px 5px #444;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(145deg, #00f, #00FED7);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 5px 5px 15px #000, -5px -5px 15px #2a2a2a;
        }

        button:hover {
            background: linear-gradient(145deg, #0073ff, #00f);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h1>Modificar Perfume</h1>
    <form action="admin_modificar.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($perfumes['id']); ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($perfumes['nombre']); ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" value="<?php echo number_format($perfumes['precio'], 0, '', '.'); ?>" required>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" accept="image/*">
        
        <button type="submit" name="guardar">Guardar Cambios</button>
    </form>
</body>
</html>
