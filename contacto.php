<?php
    require('admin/assets/db_config.php'); 
    require('admin/assets/essentials.php'); 

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <?php require('admin/assets/links.php'); ?>
</head>
<body class="bg-light">
    <?php require('header.php'); ?>

    <?php
        $contact_q = "SELECT * FROM `usuarios_contact` WHERE `sr_no`=?";
        $values = [1];
        $contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
    ?>

<br><br><br><br><br>
    <div class="container">
        <div class="my-5 px-4">
            <h2 class="fw-bold text-center">CONTACTO</h2>
            <div class="h-line bg-dark"></div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Contacto-->
            <div class="container mb-5">
                <div class="text-center mb-5">
                    <h3 class="section-subheading text-muted">Contacta con nosotros a través de nuestro formulario.</h3>
				</div>
                <form method="POST" id="contactForm">
                    <div class="row align-items-stretch mb-5">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <!-- Nombre input-->
                                <input class="form-control" name="name" required type="text" placeholder="Nombre *">
                            </div>
                            <div class="form-group mb-3">
                                <!-- Email address input-->
                                <input class="form-control" name="email" required type="email" placeholder="Email *">    
                            </div>
                            <div class="form-group mb-3">
                                <!-- Teléfono input-->
                                <input class="form-control" name="phone" required type="tel" placeholder="Teléfono *">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-textarea mb-md-0">
                                <!-- Mensaje input-->
                                <textarea required class="form-control" rows="5" name="message" placeholder="Tu Mensaje *"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Botón Submit -->
                    <div class="text-center">
                        <button type="submit" name="send" class="btn btn-primary text-uppercase">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- Formulario contacto -->
    <?php
        
        if(isset($_POST['send']))
        {
            $frm_data = filteration($_POST);

            $q = "INSERT INTO `usuarios_contact`(`name`, `email`, `phone`, `message`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'],$frm_data['email'],$frm_data['phone'],$frm_data['message']];

            $res = insert($q,$values,'ssss');
            if($res==1){
                alert('success', '¡Mensaje enviado!');
            }
            else {
                alert('error','Servidor no responde, intentelo más tarde.');
            }
        }

    ?>




    <?php require('footer.php'); ?>

</body>
</html>