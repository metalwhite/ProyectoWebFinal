<?php 
    require('assets/essentials.php');
    require('assets/db_config.php');

    session_start();
    session_regenerate_id(true);
    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
        redirect('dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <?php require('assets/links.php'); ?>
</head>
<body class="bg-light">
        <div class="container">
            <div class="mt-5 mb-3">
                <div class="container bg-white">
                    <form method="POST" class="login-email">
                    <p class="text-center mt-5 fw-bold">Login Admin con email</p>
                    <div class="row align-items-center justify-content-center mb-5">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <!-- Nombre input-->
                                <input class="form-control" name="admin_email" required type="text" placeholder="Email *">
                            </div>
                            <div class="form-group mb-3">
                                <!-- Email address input-->
                                <input class="form-control" name="admin_pass" required type="password" placeholder="Contraseña *">
                                
                            </div>
                    </div>
                    <!-- Submit Button-->
                    <div class="text-center">
                        <button name="login" type="submit" class="btn btn-primary text-uppercase">Login</button>
                    </div>
                </form>
                </div>
            </div>
        </div>



    <?php

        if(isset($_POST['login']))
        {
            $frm_data = filteration($_POST);
            $query = "SELECT * FROM `admin_cred` WHERE `admin_email`=? AND `admin_pass`=?";
            $values = [$frm_data['admin_email'], $frm_data['admin_pass']];

            $res = select($query,$values,"ss"); 
            if($res->num_rows==1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminId'] = $row['sr_no'];
                redirect('dashboard.php');
            }
            else{
                alert('error','Login fallido - Credenciales Incorrectas!');
            }
        }
    ?>


    <?php require('assets/scripts.php'); ?>
</body>
</html>