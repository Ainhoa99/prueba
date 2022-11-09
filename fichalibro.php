<?php
include('database/conexion.php');
// Comprobamos si existe la sesión de apodo
session_start();
if (!isset($_SESSION['nickname'])) {
    // En caso contrario devolvemos a la página login.php
    header('Location: login.php');
    die();
}

$libro = $_GET['liburua'];
// Prepara SELECT
$otraconsulta = $miPDO->prepare('SELECT * FROM libros WHERE id_libro = :id_libro;');

// Ejecuta consulta
$otraconsulta->execute(
    [
        'id_libro' => $libro
    ]
);
$libros = $otraconsulta->fetch();

$id_idioma = $libros['id_idioma'];

$consulta2 = $miPDO->prepare('SELECT idioma FROM idiomalibro WHERE id_idioma = :id_idioma;');
// Ejecuta consulta
$consulta2->execute(
    [
        'id_idioma' => $id_idioma
    ]
);
$idioma = $consulta2->fetch();

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Argitalpen-data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/estiloPopUp.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Custom Scripts -->
    <script src="js/scripts.js"></script>
    <script src="js/popUp.js" defer></script>
</head>

<body>

    <?php include("cabecera.php"); ?>

    <main id="contenido-fichalibro">


        <div id='caja-titulo-fichafibro'>
            <!-- Titulo -->
            <h2 class='ficha-titulo'> <?php echo $libros['titulo_libro'] ?> </h2>
            <!-- Autor -->
            <h3 class='ficha-autor'><?php echo $libros['autor'] ?></h3>
        </div>

        <div id='contenedor-todo'>

            <div id='caja-foto-info'>
                <!-- Imagen -->
                <div id='caja-img'>
                    <figure class='ficha-img'><img src='src/<?php echo $libros['foto'] ?>'></figure>
                </div>
                <!-- Contenedor nota media y edad media  -->
                <div class='caja-contenedor-valoracion'>
                    <div id='contenedor-valoracion'>
                        <!-- Valoración -nota media  -->
                        <div class='caja-notamedia'>
                            <p class='ficha-notamedia-text'><i class='fas fa-star'></i><span><?php echo $libros['notamedia'] ?> </span></p>
                            <!-- batez besteko nota -->
                        </div>
                        <!-- Edad media -->
                        <div class='caja-ficha-edadmedia'>
                            <p class='texto-edadmedia'><span>Batez</span> <span>besteko</span> <span>adina</span></p>
                            <p class='ficha-edadmedia'> <?php echo $libros['edadmedia'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id='caja-info-fichafibro'>
                <dl id='datos-libro'>
                    <!-- Sinopsis -->
                    <dt class='titulo-sinopsis'>Sinopsia</dt>
                    <dd class='ficha-sinopsis'><?php echo $libros['sinopsis'] ?></dd>
                </dl>
                <div id='caja-fichatecnica'>
                    <div id='btn-fichatecnica'>
                        <p>Fitxa teknikoa</p>
                    </div>
                    <!-- Contenedor ficha tecnica -->
                    <dl id='contenido-fichatecnica' class='ocultar'>
                        <!-- ISBN -->
                        <div class='elemento-fichatecnica'>
                            <dt class='titulo-isbn'>ISBN</dt>
                            <dd class='ficha-isbn'><?php echo $libros['isbn'] ?> </dd>
                        </div>
                        <!-- Año publicacion  -->
                        <div class='elemento-fichatecnica'>
                            <dt class='titulo-anyo'>Argitalpen-urtea</dt>
                            <dd class='ficha-anyo'><?php echo $libros['ano_de_libro'] ?></dd>
                        </div>
                        <!-- Formato -->
                        <div class='elemento-fichatecnica'>
                            <dt class='titulo-formato'>Formatua</dt>
                            <dd class='ficha-formato'><?php echo $libros['formato'] ?> </dd>
                        </div>
                        <!-- Idioma -->
                        <div class='elemento-fichatecnica'>
                            <dt class='titulo-idioma'>Hizkuntza</dt>
                            <dd class='ficha-idioma'><?php echo $idioma['idioma'] ?> </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
        <div id="btn-valorar">
            <p>Baloratu liburua</p>
        </div>





        <h3 id="titulo-opinion">Irakurleen iritziak</h3>

        <?php

        $otraconsulta = $miPDO->prepare('SELECT * FROM opiniones WHERE validado = 1 AND id_libro = :id_libro ORDER BY id_opinion DESC ');

        // Ejecuta consulta
        $otraconsulta->execute(
            [
                'id_libro' => $libro
            ]
        );
        $comentarios = $otraconsulta->fetchAll();
        $count = count($comentarios);



        ?>
        <div id="comment-count">
            <span id="count-number"><?php echo ('Liburu hau iruskindu duten pertsonek: ' . $count); ?></span>
            <br>
        </div>
        <div id="comentarios" class="">
            <?php
            if ($count > 0) {
            }
            foreach ($comentarios as $opinion) {

                //$titulo-libro = $libros['titulo_libro'];
                echo "<br>";
                echo "<div id='comentario'>";

                echo "<p class='nombre-opinion' method='get'>" . $opinion['nickname'] . "</p>";
                echo "<p class='opinion' method='get'><span>\"</span>" . $opinion['opinion'] . "</p>";
                echo "<div class='responder'><p>Erantzun</p></div>";

                echo "</div>";
            }

            ?>
        </div>

        <div id="btn-opinion">
            <p>Eman zure iritzia</p>
        </div>

        <form id="form-opinion" class="ocultar" action="formopiniones.php" method="get">

            <div class="fecha-opinion">
                <?php
                $fechaActual = date('d-m-Y');
                echo "<p class='texto-opinion'>" . $fechaActual . "</p>";
                ?>
            </div>

            <div class="form-input-opinion">


                <div class="añadir-comentario">
                    <label>Ezizena: </label><?php echo $_SESSION['nickname']; ?>
                </div>
                <div class="añadir-comentario">
                    <label for="mesg">Iritzia:</label>
                    <br>
                    <textarea class="form__input" name="opinion" id="opinion" size="40" autofocus placeholder="Iritzia"></textarea>
                    <input type="hidden" name="libro" value="<?php echo $_GET['liburua'] ?>">
                    <br>
                    <button name="iritzia" id="opinar">Iruzkindu</button>
                </div>



            </div>

        </form>


    </main>

    <?php include('pie-pagina.php'); ?>
    <div id="modal_container" class="modal-container">
        <div class="modal">
            <form id="form-valorar" action="formvaloraciones.php" method="get">
                <button id="close">&times;</button>
                <h1>BALORAZIOA</h1>
                <br>
                <input type="hidden" name="libro" value="<?php echo $_GET['liburua'] ?>">
                <label for="nota">Nota: </label>
                <input type="number" id="nota" name="nota" min="0" max="10">
                <label for="edad">Adina: </label>
                <input type="number" id="edad" name="edad" min="5" max="70">
                <label for="idioma">Hizkuntza: </label>
                <select name="idioma" id="idioma">
                    <?php
                    //Consulta
                    $consulta = $miPDO->prepare("SELECT * FROM idiomalibro");
                    $consulta->execute();
                    $idiomas = $consulta->fetchAll();
                    foreach ($idiomas as $posicion => $idioma) {
                        echo "<option value = '" . $idioma['id_idioma'] . "'>" . $idioma['idioma'] . "</option>";
                    }
                    ?>
                </select>
                <br>
                <button id="valorar">Baloratu</button>
            </form>
        </div>
    </div>

</body>

</html>