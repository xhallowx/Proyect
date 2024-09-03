<?php
session_start();

if(!isset($_SESSION['usuario'])){
    echo'
        <script>
            alert("Por favor debes iniciar sesión");
            window.location= "inicio.php";
        </script>
    ';
    session_destroy();
    die();
}

include 'php/conexion.php';

$query = "SELECT * FROM perfumes";
$productos_result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ry Parfum - Catalogo</title>
    <link rel="stylesheet" href="assets/css/Catalogo.css">
    <link rel="icon" type="image/x-icon" href="assets/images/Zz.ico" />
</head>

<body>
    <header>
        <nav class="nav">
            <div class="logo">Ry Parfum</div>
            <ul class="menu">
                <li><a href="RyParfum.php">Inicio</a></li>
                <li><a href="#catalogo">Catálogo</a></li>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <li><a href="admin.php">Modificar</a></li>
                <?php endif; ?>
                <li><a href="php/cerrar_sesion.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>
    <section class="loader" id="catalogo">
        <div class="slider" style="--i:0"></div>
        <div class="slider" style="--i:1"></div>
        <div class="slider" style="--i:2"></div>
        <div class="slider" style="--i:3"></div>
        <div class="slider" style="--i:4"></div>
    </section>
    <section class="about">
        <div class="about-content">
            <p class="parfum-button">Catálogo de Perfumes</p>
            <p>
                En Ry Parfum, nos dedicamos a ofrecer las fragancias más exclusivas para que mejores tu ESENCIA.
            </p>
        </div>
    </section>

    <section id="Parfum">
        <?php if ($_SESSION['rol'] === 'admin'): ?>
        <?php endif; ?>

        <div class="perfume-grid">
            <?php while ($producto = mysqli_fetch_assoc($productos_result)): ?>
                <div class="perfume-card">
                    <img src="assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" />
                    <div class="perfume-details">
                        <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                        <p>Precio: $<?php echo number_format($producto['precio'], 0, '', '.'); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <script src="assets/js/catalogo.js"></script>
</body>

</html>
