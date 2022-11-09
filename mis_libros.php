<?php include('database/conexion.php');
// Comprobamos si existe la sesión de apodo
session_start();
if (!isset($_SESSION['nickname'])) {
    // En caso contrario devolvemos a la página login.php
    header('Location: login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>IGKLUBA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="css/estilos.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Custom Scripts -->
    <script src="js/scripts.js"></script>
</head>

<body>

    <?php include('cabecera.php'); ?>

    <main id="contenido-mislibros">

        <div class="mis-libros">
            <h2>Nire liburuak</h2>
        </div>
        <div class="todos-mis-libros">
            <?php
            $nickname = $_SESSION['nickname'];
            // Prepara SELECT
            $misLibros = $miPDO->prepare('SELECT * FROM valoraciones WHERE nickname = :nickname');
            $misLibros->execute(
                [
                    'nickname' => $nickname,
                ]
            );
            $mios = $misLibros->fetchAll();
            foreach ($mios as $posicion => $libro) {
                $titulo = $libro['id_libro'];
                $consulta = $miPDO->prepare('SELECT * FROM libros WHERE id_libro = :id_libro');
                // Ejecuta consulta
                $consulta->execute(
                    [
                        'id_libro' => $titulo,
                    ]
                );

                $respuesta = $consulta->fetchAll();
                // foreach($respuesta as $posicion =>$libros):   

                foreach ($respuesta as $posicion => $libros) {

                    //$titulo-libro = $libros['titulo_libro'];

                    echo "<div class='libro'>";

                    //Imagen
                    echo "<figure class='img-libro'><img src='src/" . $libros['foto'] . "'></figure>";


                    //Contenedor info libro
                    echo "<div class='caja-info-libro'>";

                    //Contenedor valoracion
                    echo "<div class='caja-medias-libro'>";
                    //Nota media
                    echo "<div class='caja-notamedia'>";
                    echo "<p class='libro-notamedia'><i class='fas fa-star'></i><span>" . $libros['notamedia'] . "</span></p>";
                    echo "</div>";
                    //Edad media
                    echo "<div class='caja-libro-edadmedia'>";
                    echo "<p class='libro-edadmedia-texto'><span>Batez</span> <span>besteko</span> <span>adina</span></p>";
                    echo "<p class='libro-edadmedia'>" . $libros['edadmedia'] . "</p>";
                    echo "</div>";

                    echo "</div>";

                    //Titulo
                    echo "<p class='libro-titulo' method='get'>" . $libros['titulo_libro'] . "</p>";

                    //Autor
                    echo "<p class='libro-autor'>" . $libros['autor'] . "</p>";

                    //Enlace a la ficha
                    echo "<p class='enlace-ficha'><a href='fichalibro.php?liburua=" . $libros['id_libro'] . "'>Fitxa ikusi</a></p>";


                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>

    </main>

    <?php include('pie-pagina.php'); ?>

</body>

</html>