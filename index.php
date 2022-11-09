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
    <?php include('funcionLibros.php'); ?>

    <main id="pagina-inicio">
        <div id="contenido">
            <?php
            $busqueda = '';
            $busqueda = isset($_REQUEST['busqueda']) ? $_REQUEST['busqueda'] : null;

            if ($busqueda === '' || $busqueda === null) {
                $consulta = $miPDO->prepare('SELECT * FROM libros;');

                // Ejecuta consulta
                $consulta->execute();

                $respuesta = $consulta->fetchAll();
                // funcion de cargar libros
                anadirlibros($respuesta);
            } else {
                // Variables del formulario
                $respuesta = $miPDO->prepare("SELECT * FROM libros WHERE autor LIKE '%$busqueda%' oR titulo_libro LIKE '%$busqueda%'");
                $respuesta->execute();
                $respuesta = $respuesta->fetchAll();

                //texto de informacion de la busqueda
                if ($respuesta) {
                    $contador = count($respuesta);
                    echo ("<div id='textobusqueda'>
                    <p>(<strong>" . $contador . "</strong>) aurkipen daude (<strong>" . $busqueda . "</strong>) libururekin erlazionatuta. 
                    </p></div>"
                    );
                    echo ('<div id = "contenedorLibros">' . anadirlibros($respuesta) . '</div>');
                } else {
                    echo 'NO EXISTE NINGUN LIBRO CON ESTE AUTOR O TITULO';
                }
                // foreach($respuesta as $posicion =>$libros): 

            }

            ?>
        </div>
        <!-- Slideshow container -->
        <div class="contenedor-galeria">
            <div class="slideshow-container">
                <!-- Full-width images with number and caption text -->
                <div class="mySlides fade">
                    <?php
                    // Prepara SELECT
                    $otraconsulta = $miPDO->prepare('SELECT foto, id_libro FROM libros ORDER BY notamedia DESC LIMIT 3');

                    // Ejecuta consulta
                    $otraconsulta->execute();
                    $libros = $otraconsulta->fetchAll();
                    ?>
                    <div class="numbertext">1 / 3</div>
                    <?php
                    foreach ($libros as $libro) {
                    ?>
                        <a class='foto-enlace' href='fichalibro.php?liburua= <?php echo $libro['id_libro'] ?>'>
                            <figure class="galeria-img"><img src='src/<?php echo $libro['foto'] ?>'></figure>
                        </a>
                    <?php
                    }
                    ?>
                    <div class="mejorvalorados-text">
                        <p>Balorazio onena duten liburuak</p>
                    </div>

                </div>

                <div class="mySlides fade">
                    <?php
                    // Prepara SELECT
                    $otraconsulta = $miPDO->prepare('SELECT foto, id_libro FROM libros ORDER BY id_libro DESC LIMIT 3');

                    // Ejecuta consulta
                    $otraconsulta->execute();
                    $libros = $otraconsulta->fetchAll();
                    ?>
                    <div class="numbertext">2 / 3</div>
                    <?php
                    foreach ($libros as $libro) {
                    ?>
                        <a class='foto-enlace' href='fichalibro.php?liburua= <?php echo $libro['id_libro'] ?>'>
                            <figure class="galeria-img"><img src='src/<?php echo $libro['foto'] ?>'></figure>
                        </a>

                    <?php
                    }
                    ?>
                    <div class="mejorvalorados-text">
                        <p>Liburu berrienak</p>
                    </div>

                </div>


                <div class="mySlides fade">
                    <?php
                    // Prepara SELECT
                    $otraconsulta = $miPDO->prepare('SELECT foto, id_libro FROM libros ORDER BY num_lectores DESC LIMIT 3');

                    // Ejecuta consulta
                    $otraconsulta->execute();
                    $libros = $otraconsulta->fetchAll();
                    ?>
                    <div class="numbertext">3 / 3</div>
                    <?php
                    foreach ($libros as $libro) {
                    ?>
                        <a class='foto-enlace' href='fichalibro.php?liburua= <?php echo $libro['id_libro'] ?>'>
                            <figure class="galeria-img"><img src='src/<?php echo $libro['foto'] ?>'></figure>
                        </a>
                    <?php
                    }
                    ?>
                    <div class="mejorvalorados-text">
                        <p>Gehien irakurri diren liburuak</p>
                    </div>
                    

                </div>
                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                
                <!-- The dots/circles 
                <div id="puntos-galeria" style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                </div> -->
            </div>
            <br />
        </div>

        <script>
            let slideIndex = 1;
            showSlides(slideIndex);

            // Next/previous controls
            function plusSlides(n) {
                showSlides((slideIndex += n));
            }

            // Thumbnail image controls
            function currentSlide(n) {
                showSlides((slideIndex = n));
            }

            function showSlides(n) {
                let i;
                let slides = document.getElementsByClassName("mySlides");
                let dots = document.getElementsByClassName("dot");
                if (n > slides.length) {
                    slideIndex = 1;
                }
                if (n < 1) {
                    slideIndex = slides.length;
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex - 1].style.display = "flex";
                dots[slideIndex - 1].className += " active";
            }
        </script>

    </main>

    <?php include('pie-pagina.php'); ?>

</body>

</html>