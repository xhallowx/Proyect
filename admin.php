<?php
session_start();

if ($_SESSION['rol'] !== 'admin') {
    header("Location: RyParfum.php");
    exit();
}

include 'php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $imagen = $_FILES['imagen']['name'];
    $target_dir = "assets/images/";
    $target_file = $target_dir . basename($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);

    $query = "INSERT INTO perfumes (nombre, precio, imagen) VALUES ('$nombre', '$precio', '$imagen')";
    mysqli_query($conexion, $query);
    header("Location: admin.php");
    exit();
}

$query = "SELECT * FROM perfumes";
$perfumes_result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="icon" type="image/x-icon" href="assets/images/Zz.ico" />
</head>
<body>
    <header>
        <nav class="nav">
            <div class="logo">Ry Parfum</div>
            <ul class="menu">
                <li><a href="RyParfum.php">Inicio</a></li>
                <li><a href="catalogo.php">Volver al Catálogo</a></li>
            </ul>
        </nav>
    </header>

    <button id="agregar" class="agregar">Agregar Perfume</button>

    <h2>Perfumes Existentes</h2>

    <form id="perfume-form" action="admin.php" method="POST" enctype="multipart/form-data" style="display:none;">
        <label for="nombre">Nombre del Perfume:</label>
        <input type="text" name="nombre" required>

        <!--<label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea>-->

        <label for="precio">Precio:</label>
        <input type="number" name="precio" required>

        <label for="imagen">Imagen del Perfume:</label>
        <input type="file" name="imagen" accept="image/*" required>

        <button type="submit">Guardar Perfume</button>
    </form>

    <div class="perfume-info">
        <?php while ($perfumes = mysqli_fetch_assoc($perfumes_result)): ?>
            <div class="producto">
                <img src="assets/images/<?php echo htmlspecialchars($perfumes['imagen']); ?>" alt="<?php echo htmlspecialchars($perfumes['nombre']); ?>">
                <h2><?php echo htmlspecialchars($perfumes['nombre']); ?></h2>
                <p><?php echo htmlspecialchars($perfumes['descripcion']); ?></p>
                <p>Precio: $<?php echo number_format($perfumes['precio'], 0, '', '.'); ?></p>
                <form method="POST" action="php/admin_functions.php" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?php echo $perfumes['id']; ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                </form>
                <form method="POST" action="php/admin_modificar.php" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?php echo $perfumes['id']; ?>">
                    <button type="submit" name="modificar">Modificar</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <script>
        document.getElementById('agregar').addEventListener('click', function() {
            var form = document.getElementById('perfume-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
        const nav = document.querySelector(".nav");
        window.addEventListener("scroll", function () {
        nav.classList.toggle("active", window.scrollY > 0);
        });
        const perfumeCards = document.querySelectorAll(".perfume-card");

        window.addEventListener("scroll", function () {
        const scrollPos = window.scrollY + window.innerHeight;

        perfumeCards.forEach(function (card) {
            if (scrollPos > card.offsetTop + card.offsetHeight / 2) {
            card.classList.add("visible");
            card.classList.remove("hidden");
            } else {
            card.classList.remove("visible");
            card.classList.add("hidden");
            }
        });
        });
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
            });
        });
        });
    </script>
</body>
</html>
