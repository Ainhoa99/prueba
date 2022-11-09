<?php
include_once "database/conexion.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estiloGenerico.css">
    <!-- <script src="js/scriptValidaciones.js" defer></script> -->
    <title>AÑADIRLIBRO</title>
</head>

<body>
    <div class="container">
        <?php
        // Comprobamos que nos llega los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Variables del formulario
            $isbn = isset($_REQUEST['isbn']) ? $_REQUEST['isbn'] : null;
            $titulo_libro = isset($_REQUEST['titulo_libro']) ? $_REQUEST['titulo_libro'] : null;
            $autor = isset($_REQUEST['autor']) ? $_REQUEST['autor'] : null;
            $ano_de_libro = isset($_REQUEST['ano_de_libro']) ? $_REQUEST['ano_de_libro'] : null;
            $sinopsis = isset($_REQUEST['sinopsis']) ? $_REQUEST['sinopsis'] : null;
            $formato = isset($_REQUEST['formato']) ? $_REQUEST['formato'] : null;
            $idioma  = isset($_REQUEST['idioma']) ? $_REQUEST['idioma'] : null;
            $link_compra = isset($_REQUEST['link_compra']) ? $_REQUEST['link_compra'] : null;

            $comprobar = $miPDO->prepare('SELECT id_libro FROM libros WHERE isbn = :isbn');
            $comprobar->execute(['isbn' => $isbn]);
            $comprobar = $comprobar->fetch();

            if (empty($comprobar)) {
                $archivo = isset($_FILES['foto']) ? $_FILES['foto'] : null;
                $target_dir = "C:\\xampp\\htdocs\\2DW3\\src\\";
                $target_file = $target_dir . basename($archivo["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image

                // Check if image file is a actual image or fake image
                if (isset($_POST["submit"])) {
                    $check = getimagesize($archivo["tmp_name"]);
                    if ($check !== false) {
                        echo "azala - " . $check["foto"] . " da.";
                        $uploadOk = 1;
                    } else {
                        echo "Barkatu, argazkiak bakarrik igo daitezke";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "azala errepikatuta dago";
                    $uploadOk = 0;
                }

                // Check file size
                if ($archivo["size"] > 500000) {
                    echo "Barkatu, azalaren argazkia oso handia da.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                ) {
                    echo "Barkatu, bakarrik JPG, JPEG eta PNG irudiak.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Barkatu, azala ezin izan da igo";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
                        echo htmlspecialchars(basename($archivo["foto"])) . "azala ondo igo da.";
                    } else {
                        echo "Barkatu, arazo bat egon da azala igotzerakoan.";
                    }
                }

                // Base de datos.
                $consulta = $miPDO->prepare('INSERT INTO libros (isbn, titulo_libro, foto, autor, ano_de_libro, sinopsis, formato, edadmedia, notamedia, num_lectores, /*validado,*/ id_idioma, link_compra)
                                            VALUES (:isbn, :titulo_libro, :foto, :autor, :ano_de_libro, :sinopsis, :formato, :edadmedia, :notamedia, :num_lectores, /*:validado,*/ :id_idioma, :link_compra)');
                $consulta->execute([
                    'isbn' => $isbn,
                    'titulo_libro' => $titulo_libro,
                    'foto' => basename($archivo["name"]),
                    'autor' => $autor,
                    'ano_de_libro' => $ano_de_libro,
                    'sinopsis' => $sinopsis,
                    'formato' => $formato,
                    'edadmedia' => 0,
                    'notamedia' => 0,
                    'num_lectores' => 0,
                    //'validado' => 0,
                    'id_idioma' => $idioma,
                    'link_compra' => $link_compra
                ]);

                header('Location: index.php');
                die();
            };
        }
        ?>
        <form class="form" id="register" action="" method="post" enctype="multipart/form-data">
            <img id="logobueno" src="src/Logobueno.png" alt="Logo">
            <div id="main">
                <div class="fila">
                    <!-- TITULO LIBRO -->
                    <div class="formulario__grupo" id="grupo__apellidos">
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="titulo_libro" id="apellidos" size="40" autofocus placeholder="Liburuaren Izenburua">
                        </div>
                        <!-- <p class="formulario__input-error">Abizenak 3 eta 16 digitu artekoa izan behar du, eta letrak bakarrik eduki ditzake, beti letra larriz hasita.</p> -->
                    </div>
                    <!-- ESCRITOR -->
                    <div class="formulario__grupo" id="grupo__nickname">
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="autor" id="nickname" size="40" autofocus placeholder="Idazlea">
                        </div>
                        <!-- <p class="formulario__input-error">Ezizena 4-16 digitu izan behar ditu, eta zenbakiak, letrak eta gidoi baxua baino ezin ditu izan.</p> -->
                    </div>

                </div>
                <div class="fila">
                    <!-- AÑO DEL LIBRO -->
                    <div class="formulario__grupo" id="grupo__password">
                        <div class="formulario__grupo-input">
                            <input type="year" name="ano_de_libro" class="formulario__input" id="password" size="40" autofocus placeholder="Liburuaren argitaratze data">
                        </div>
                        <!-- <p class="formulario__input-error">Pasahitzak 4 eta 12 digitu artekoa izan behar du.</p> -->
                    </div>

                    <!-- NICKNAME -->
                    <div class="formulario__grupo" id="grupo__password">
                        <div class="formulario__grupo-input">
                            <input type="text" name="formato" class="formulario__input" id="password" size="40" autofocus placeholder="Formatua">
                        </div>
                        <!-- <p class="formulario__input-error">Pasahitzak 4 eta 12 digitu artekoa izan behar du.</p> -->
                    </div>

                </div>
                <div class="fila">
                    <!-- CONTRASEÑA -->
                    <div class="formulario__grupo-input">
                        <select name="idioma" id="centro">
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
                    </div>
                    <!-- CONTRASEÑA 2 -->
                    <div class="formulario__grupo" id="grupo__nombre">
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="isbn" id="nombre" size="40" autofocus placeholder="Isbn zembakia">
                        </div>
                        <!-- <p class="formulario__input-error">Izenak 3 eta 16 digitu artekoa izan behar du, eta letrak bakarrik eduki ditzake, beti letra larriz hasita.</p> -->
                    </div>
                </div>
                <div class="fila">
                    <!-- CONTRASEÑA -->

                    <!-- CONTRASEÑA 2 -->
                    <div class="formulario__grupo" id="grupo__password2">
                        <div class="formulario__grupo-input">
                            <textarea type="text" name="sinopsis" class="formulario__input" id="password2" size="40" autofocus placeholder="sinopsia/laburpena"></textarea>
                        </div>
                        <!-- <p class="formulario__input-error">Pasahitzak berdinak izan behar dira.</p> -->
                    </div>
                </div>
                <div class="fila">
                    <!-- CONTRASEÑA -->
                    <div class="formulario__grupo" id="grupo__password2">
                        <div class="formulario__grupo-input">
                            <input type="text" name="link_compra" class="formulario__input" id="password2" size="40" autofocus placeholder="Erosteko linka">
                        </div>
                        <!-- <p class="formulario__input-error">Pasahitzak berdinak izan behar dira.</p> -->
                    </div>
                    <!-- CONTRASEÑA 2 -->
                    <div class="formulario__grupo" id="grupo__email">
                        <div class="formulario__grupo-input">
                            <input type="file" class="formulario__input" name="foto" id="foto" size="40" autofocus placeholder="Liburuaren azala">
                        </div>
                        <!-- <p class="formulario__input-error">Email-a letrak, zenbakiak, puntuak, gidoiak eta gidoi baxua baino ezin ditu izan.</p> -->
                    </div>
                </div>
                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i><b>Errorea:</b> Mesedez, bete formularioa behar bezala.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button class="form__button" type="submit" id="btnRegistro">GeHitu Liburua</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Ondo bidalitako formularioa!</p>
                </div>

                <p class="form__text">
                    <a class="form__link" href="login.php" id="linkCreateAccount">Baduzu kontu bat? Saioa hasi</a>
                </p>

        </form>
    </div>
</body>

</html>