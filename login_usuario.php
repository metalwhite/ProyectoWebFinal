<?php
    require('admin/assets/db_config.php');
    require('admin/assets/essentials.php');
    userLogin();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario</title>
    <?php require('admin/assets/links.php'); ?>
</head>
<body class="bg_light">

    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between">
        <h1 class="mb-0">DistrutaTusVacaciones</h1>
        <a href="logout_usuario.php" class="btn btn-light btn-sm">LOG OUT</a>
    </div>
    <div>
        <h1 class="fw-bold align-items-center justify-content-center mt-5 px-5">
            BIENVENIDO A TU PORTAL
        </h1>
    </div>
        <!-- Scripts bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">            
        
</body>
</html>


