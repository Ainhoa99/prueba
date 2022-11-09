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
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts -->

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
    <main id="contenido">
        <?php

        $nickname = $_SESSION['nickname'];
        // Prepara SELECT
        $consulta = $miPDO->prepare('SELECT * FROM usuarios where nickname = :nickname');

        // Ejecuta consulta
        $consulta->execute([
            'nickname' => $nickname,
        ]);

        $respuesta = $consulta->fetch();
        // foreach($respuesta as $posicion =>$libros):  
        $centro = $respuesta['id_centro'];
        $consulta2 = $miPDO->prepare('SELECT nombre_centro FROM centro WHERE id_centro = :id_centro');
        $consulta2->execute(
            [
                'id_centro' => $centro,
            ]
        );
        $respuesta2 = $consulta2->fetch();
        $id_nivel = $respuesta['id_nivel'];
        $consulta3 = $miPDO->prepare('SELECT nivel FROM clase WHERE id_nivel = :id_nivel');
        $consulta3->execute(
            [
                'id_nivel' => $id_nivel,
            ]
        );
        $respuesta3 = $consulta3->fetch();
        ?>
        <div id='container'>
            <div class="container2">
                <div id="foto">
                    <figure class='foto'><img src='src/<?php echo ($respuesta['foto']) ?>'></figure>
                    <input type='file' id='foto' style='display: none'>
                </div>

                <div id='caja-info-perfil'>

                    <dl class='caja-info-usuario'>

                        <dt>Izena</dt>
                        <dd class='nombre' method='get'><?php echo ($respuesta['nombre']) ?></dd>
                        <input type='text' id='nombre' style='display: none'>

                        <dt>Abizena</dt>
                        <dd class='apellidos'><?php echo ($respuesta['apellidos']) ?></dd>
                        <input type='text' id='apellidos' style='display: none'>

                        <dt>Ezizena</dt>
                        <dd class='nickname'><?php echo ($respuesta['nickname']) ?></dd>
                        <input type='text' id='nickname' style='display: none'>

                        <dt>Emaila</dt>
                        <dd class='correo'><?php echo ($respuesta['correo']) ?></dd>
                        <input type='text' id='correo' style='display: none'>

                    </dl>


                    <dl id='info'>

                        <dt>Eskola</dt>
                        <dd><?php echo ($respuesta2['nombre_centro']) ?></dd>

                        <dt>Jahiotze data</dt>
                        <dd class='fecha_nacimiento'><?php echo ($respuesta['fecha_nacimiento']) ?></dd>
                        <input type='date' id='fecha_nacimiento' style='display: none'>

                        <dt>Mugikorra</dt>
                        <dd class='movil'><?php if ($respuesta['movil'] == '') {
                                                echo ('Ez daukat mugikorra');
                                            } else {
                                                echo ($respuesta['movil']);
                                            }
                                            echo ($respuesta['movil']) ?></dd>
                        <input type='text' id='movil' style='display: none'>

                        <dt>Maila</dt>
                        <dd class='nivel'><?php echo ($respuesta3['nivel']) ?></dd>


                    </dl>
                </div>

            </div>
            <div id="caja-btn-editar">
                <button class="btn-editar"><a id="btneditar" href='cambioPassword.php'>Aldatu pasahitza</a></button>
            </div>
        </div>

    </main>

    <?php
    include('pie-pagina.php');
    ?>
</body>

</html>