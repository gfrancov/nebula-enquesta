<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Enquesta | Nebula Hosting</title>
        <link href="../css/styles.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>

        <header>

            <a class="logo-nebula" href="https://www.nebula.cat/"><img src="../img/logo-lila.png" alt="Logo Nebula"></a>
            <h1 class="titol-nebula">Nebula <span class="color-lila">Hosting</span></h1>
            <p class="autor-nebula">Desenvolupat per Gabriel Franco</p>

        </header>

        <div class="contingut">

            <?php 
                if($_POST) {

                    include "../credencials.php";

                    if($_POST['usuari'] === $usuari && $_POST['contrasenya'] === $contrasenya) {
                        echo("<p>Benvingut " . $_POST['usuari'] . " al panell per veure els resultats.</p>");
                        echo("<p class='botons'><a href='resultats.php'><i class='fas fa-chart-line'></i> Veure els resultats</a></p>");
                        session_start();
                        $_SESSION['usuari'] = $usuari;
                        $_SESSION['loguejat'] = 'true';
                    } else {
                        echo("<p class='error-text'>Has introduit credencials errònies.</p>");
                    }

                } else {

            ?>
            <form class="login" method="POST" action="#">
                <p class="enunciat-login"><label for="usuari">Nom d'usuari: </label></p>
                <input class="login-camp" type="text" name="usuari" id="usuari" placeholder="Nom d'usuari" required/>
                <p class="enunciat-login"><label for="contrasenya">Contrasenya: </label></p>
                <input class="login-camp" type="password" name="contrasenya" id="contrasenya" placeholder="••••••••••" required/>
                <p class="enunciat-login"><input type="submit" value="Iniciar Sessió"/></p>
                
            </form>

            <?php
                }
            ?>

        </div>

    </body>
</html>