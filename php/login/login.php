<?php
include '../usuarios/DAOUsuario.php';
include '../usuarios/Usuario.php';
$DaoUsr = new DAOUsuario();
$usr = new Usuario();
?>

<head>
    <title>Login</title>
    <!-- Enlaces a Bootstrap y CSS personalizado -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>

    <main class="d-flex flex-column">

        <div class="d-flex justify-content-center align-items-center">
            <img src="../../../Citas_Medicas_V1_Grupo4/php/styles/logo.jpeg" class="" alt="logo citas" style="width: 200px; height: 200px;">
        </div>

        <form class="d-flex flex-column justify-content-center align-items-center">
            <div class="form-outline mb-4">
                <label class="form-label" for="correo">correo</label>
                <input type="email" id="correo" name="correo" class="form-control" />
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" />
            </div>
            <button type="submit" id="btnLogin" name="btnLogin" class="btn btn-primary btn-block mb-4">Iniciar sesion</button>
        </form>
    </main>

    <?php
    if (isset($_REQUEST["btnLogin"])) {
        $usr->setCorreo($_REQUEST["correo"]);
        $usr->setPassword($_REQUEST["password"]);

        $loginResult = $DaoUsr->login($usr);

        if ($loginResult) {

            $response = array(
                'correo' => $loginResult['correo'],
                'rol' => $loginResult['rol'],
                'id_persona' => $loginResult['id_persona']
            );

            // Convertir el array a formato JSON
            $jsonResponse = json_encode($response);

            // Imprimir el JSON como parte de la respuesta
            echo "<script>
                    var jsonData = JSON.parse('" . $jsonResponse . "');
                    localStorage.setItem('correo', jsonData.correo);
                    localStorage.setItem('rol', jsonData.rol);
                    localStorage.setItem('id_persona', jsonData.id_persona);
                    window.location.href = '../../../Citas_Medicas_V1_Grupo4/php/MenuPrincipal.php';
                </script>";
            exit();
        } else {
            // Inicio de sesión fallido, puedes manejar esto de acuerdo a tus necesidades
            echo "<script>swal({title:'Error',text:'Inicio de sesión fallido. Verifica tus credenciales.', type: 'error'});</script>";
        }
    }
    ?>

    <!-- Scripts -->
    <script>

    </script>
</body>

</html>