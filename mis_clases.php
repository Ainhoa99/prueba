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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Custom Scripts -->
    <script src="js/scripts.js"></script>
    <script src="js/popUp.js" defer></script>
    <title>Mis Clases</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/estiloPopUp.css">
</head>

<body>
    <?php include('cabecera.php'); ?>

    <main id="contenido-mislibros">
        <div id="btn-clase-nueva">
            <div id='enlace-clase-nueva'>
                <i class="fas fa-plus-square"></i>
                <p><span>Klase </span><span>berria</span></p>
            </div>
        </div>
        <div class="titulo-misclases">
            <h2>Nire klaseak</h2>
        </div>
        <div class="todas-mis-clases">

            <?php
            // Prepara SELECT
            $misClases = $miPDO->prepare('SELECT * FROM clase');
            $misClases->execute();
            $clases = $misClases->fetchAll();
            foreach ($clases as $posicion => $clase) {
                $clasesAlumnos = $miPDO->prepare('SELECT COUNT(id_nivel) AS num_alumnos FROM usuarios WHERE id_nivel=:id_nivel');
                $clasesAlumnos->execute(
                    [
                        'id_nivel' => $clase['id_nivel']
                    ]
                );
                $alumnos = $clasesAlumnos->fetch();
            ?>
                <div class='caja-clase'>

                    <!-- Contenedor valoracion -->
                    <div class='caja-info-clase'>
                        <!-- Nombre clase -->
                        <div class='caja-Nombre'>
                            <p class='nombre_clase'></i><span> <?php echo ($clase['nivel']) ?> </span></p>
                        </div>
                        <!-- Numero alumnos -->
                        <div class='caja-alumnos'>
                            <p class='numero_alumnos'> <?php echo ($alumnos['num_alumnos']) ?> <span> ikasleak</span></p>
                        </div>
                    </div>


                </div>
            <?php
            }
            ?>


        </div>

    </main>

    <?php include('pie-pagina.php'); ?>
    <div id="modal_container" class="modal-container">
        <div class="modal">
            <form id="form-valorar" action="formClases.php" method="get">
                <button id="close">&times;</button>
                <h1>KLASE BERRIA</h1>
                <label for="fecha">Fecha límite: </label>
                <input type="date" name="fecha" id="fecha">
                <br>
                <label for="nombre">Nombre de la clase:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de la clase">
                <button id="valorar">Klasea sortu</button>
            </form>
        </div>
    </div>
</body>

</html>