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
    <script src="js/scriptValidaciones.js" defer></script>
    <title>REGISTER</title>
</head>

<body>
    <div class="container">
        <?php
        // Comprobamos que nos llega los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Variables del formulario
            $nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : null;
            $apellidos = isset($_REQUEST['apellidos']) ? $_REQUEST['apellidos'] : null;
            $correo = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
            $nickname = isset($_REQUEST['nickname']) ? $_REQUEST['nickname'] : null;
            $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
            $password2 = isset($_REQUEST['password2']) ? $_REQUEST['password2'] : null;
            $centro = isset($_REQUEST['centro']) ? $_REQUEST['centro'] : null;
            $fecha = isset($_REQUEST['fecha']) ? $_REQUEST['fecha'] : null;
            $nivel = isset($_REQUEST['nivel']) ? $_REQUEST['nivel'] : null;

            $comprobar = $miPDO->prepare('SELECT nickname FROM usuarios WHERE nickname = :nickname OR correo = :correo');
            $comprobar->execute(
                [
                    'nickname' => $nickname,
                    'correo' => $correo
                ]
            );
            $comprobar = $comprobar->fetch();

            if (empty($comprobar)) {
                // Base de datos.
                $consulta = $miPDO->prepare('INSERT INTO usuarios (nombre, apellidos, correo, nickname, id_centro, fecha_nacimiento, tipo, validado, password, id_nivel, curso)
                                            VALUES (:nombre, :apellidos, :correo, :nickname, :id_centro, :fecha_nacimiento, :tipo, :validado, :password, :id_nivel, :curso)');
                $consulta->execute([
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'correo' => $correo,
                    'nickname' => $nickname,
                    'id_centro' => $centro,
                    'fecha_nacimiento' => $fecha,
                    'tipo' => 'Alumno',
                    'validado' => 0,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'id_nivel' => $nivel,
                    'curso' => '2022-2023'

                ]);

                header('Location: login.php');
                die();
            } else {
                echo '<div><p style="color: red" class="form__text">Badago erabiltzaile bat ezizen edo email honekin</p></div>';
            };
        }
        ?>
        <form class="form" id="register" action="" method="post">
            <img id="logobueno" src="src/Logobueno.png" alt="Logo">
            <div id="main">
                <div class="fila">
                    <!-- NOMRBRE -->
                    <div class="formulario__grupo" id="grupo__nombre">
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="nombre" id="nombre" size="40" autofocus placeholder="Izena">
                        </div>
                        <p class="formulario__input-error">Izenak 3 eta 16 digitu artekoa izan behar du, eta letrak bakarrik eduki ditzake, beti letra larriz hasita.</p>
                    </div>
                    <!-- APELLIDOS -->
                    <div class="formulario__grupo" id="grupo__apellidos">
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="apellidos" id="apellidos" size="40" autofocus placeholder="Abizenak">
                        </div>
                        <p class="formulario__input-error">Abizenak 3 eta 16 digitu artekoa izan behar du, eta letrak bakarrik eduki ditzake, beti letra larriz hasita.</p>
                    </div>
                </div>
                <div class="fila">
                    <!-- CORREO -->
                    <div class="formulario__grupo" id="grupo__email">
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="email" id="email" size="40" autofocus placeholder="Email-a">
                        </div>
                        <p class="formulario__input-error">Email-a letrak, zenbakiak, puntuak, gidoiak eta gidoi baxua baino ezin ditu izan.</p>
                    </div>
                    <!-- NICKNAME -->
                    <div class="formulario__grupo" id="grupo__nickname">
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="nickname" id="nickname" size="40" autofocus placeholder="Ezizena">
                        </div>
                        <p class="formulario__input-error">Ezizena 4-16 digitu izan behar ditu, eta zenbakiak, letrak eta gidoi baxua baino ezin ditu izan.</p>
                    </div>
                </div>
                <div class="fila">
                    <!-- CONTRASEÑA -->
                    <div class="formulario__grupo" id="grupo__password">
                        <div class="formulario__grupo-input">
                            <input type="password" name="password" class="formulario__input" id="password" size="40" autofocus placeholder="Pasahitza">
                        </div>
                        <p class="formulario__input-error">Pasahitzak 4 eta 12 digitu artekoa izan behar du.</p>
                    </div>
                    <!-- CONTRASEÑA 2 -->
                    <div class="formulario__grupo" id="grupo__password2">
                        <div class="formulario__grupo-input">
                            <input type="password" class="formulario__input" id="password2" size="40" autofocus placeholder="Errepikatu pasahitza">
                        </div>
                        <p class="formulario__input-error">Pasahitzak berdinak izan behar dira.</p>
                    </div>
                </div>

                <div class="formulario__grupo" id="grupo__fecha">
                    <!-- FECHA_NACIMIENTO -->
                    <div class="formulario__grupo-input">
                        <input type="text" name="fecha" class="formulario__input" id="fecha" size="40" autofocus placeholder="Jaiotxe-data" onfocus="(this.type='date')">
                    </div>
                </div>


                <div class="fila">
                    <div class="formulario__grupo-input">
                        <span>Curtsoa:</span>
                        <select name="nivel" id="nivel">
                            <?php
                            //Consulta
                            $consulta = $miPDO->prepare("SELECT * FROM clase");
                            $consulta->execute();
                            $niveles = $consulta->fetchAll();
                            foreach ($niveles as $posicion => $nivel) {
                                echo "<option value = '" . $nivel['id_nivel'] . "'>" . $nivel['nivel'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="formulario__grupo-input">
                        <span>Ikastetxea:</span>
                        <select name="centro" id="centro">
                            <?php
                            //Consulta
                            $consulta = $miPDO->prepare("SELECT * FROM centro");
                            $consulta->execute();
                            $centros = $consulta->fetchAll();
                            foreach ($centros as $posicion => $centro) {
                                echo "<option value = '" . $centro['id_centro'] . "'>" . $centro['nombre_centro'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i><b>Errorea:</b> Mesedez, bete formularioa behar bezala.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button class="form__button" type="submit" id="btnRegistro">Erregistratu</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Ondo bidalitako formularioa!</p>
                </div>

                <p class="form__text">
                    <a class="form__link" href="login.php" id="linkCreateAccount">Baduzu kontu bat? Saioa hasi</a>
                </p>

        </form>
    </div>
</body>

</html>