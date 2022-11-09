<?php
//hh
function anadirlibros($respuesta)
{
    foreach ($respuesta as $libros) {

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

        //ee


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
