<?php 
    require('admin/assets/essentials.php');
    require('admin/assets/db_config.php');

    session_start();
    session_regenerate_id(true);
    if((isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true)){
        redirect('login_usuario.php');
    }
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reserva tu habitación en Disfrutatusvacaciones</title>
        <?php require('admin/assets/links.php'); ?>
    </head>
    <body id="top">
        
        <!-- Navegación -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-5">
                <a class="navbar-brand" href="#top"><img src="assets/images/logo.png" width="150rem" height="100rem" alt="logo-empresa"></a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto ">
                        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="servicios.php">Servicios</a></li>
                        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                        <li class="nav-item"><a class="nav-link" href="nosotros.php">Nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="modal" href="#login">LOGIN</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="modal" href="#registro">REGISTRO</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    <!-- Creación de Usuarios -->
        <?php
    
        $contact_q = "SELECT * FROM `usuarios` WHERE `sr_no`=?";
        $values = [1];
        $contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));

        if(isset($_POST['send']))
        {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $pic = $_POST['pic'];
            $address = $_POST['address'];
            $cp = $_POST['cp'];
            $dob = $_POST['dob'];
            $pass = md5($_POST['pass']);
            $cpass = md5($_POST['cpass']);

            if ($pass === $cpass) {
                $q = "SELECT * FROM `usuarios` WHERE `email` = '$email'";
                $res = mysqli_query($con, $q);
                if(!$res->num_rows > 0) {
                $q = "INSERT INTO `usuarios`(`name`, `surname`, `email`, `phone`, `pic`, `address`, `cp`, `dob`, `pass`, `cpass`) 
                      VALUES ('$name','$surname','$email','$phone','$pic','$address','$cp','$dob','$pass','$cpass')";
                $res = mysqli_query($con, $q);
                if($res){
                    alert('success', '¡Usuario creado con éxito!');
                    $name = "";
                    $surname = "";
                    $email = "";
                    $phone = "";
                    $pic = "";
                    $address = "";
                    $cp = "";
                    $dob = "";
                    $_POST['pass'] = "";
                    $_POST['cpass'] = "";
                } else {
                    alert('error', '¡Woops! Algo fue mal.');
                } 
                } else {
                    alert('error', '¡Woops! Email ya existe.');
                }
            } else {
                alert('error','Contraseña no coincide.');
            }
        }
        ?>
        <!-- Login Usuario -->
        <?php

        if(isset($_POST['submit']))
        {
            $frm_data = filteration($_POST);
            $query = "SELECT * FROM `usuarios` WHERE `email`=? AND `pass`=?";
            $values = [$frm_data['email'], md5($frm_data['pass'])];

            $res = select($query,$values,"ss"); 
            if($res->num_rows==1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION['userLogin'] = true;
                $_SESSION['userId'] = $row['sr_no'];

                redirect('login_usuario.php');
            }
            else{
                alert('error','Login fallido - Credenciales Incorrectas!');
            }
        }
        ?>

        <!-- Modal Login Menu -->
        
        <div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            Login Usuario
                        </h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input required type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input required type="password" name="pass" class="form-control">
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-2">
                        <button type="submit" name="submit" class="btn btn-dark">Login</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        

        <!-- Modal Registro -->
        
        <div class="modal fade" id="registro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            Registro Usuario
                        </h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input required type="text" name="name" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Apellidos</label>
                                    <input required type="text" name="surname" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Email</label>
                                    <input required type="email" name="email" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input required type="number" name="phone" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Foto</label>
                                    <input type="file" name="pic" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Dirección</label>
                                    <textarea class="form-control" name="address" rows="1"></textarea>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Código Postal</label>
                                    <input type="number" name="cp" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Fecha de nacimiento</label>
                                    <input type="date" name="dob" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Contraseña</label>
                                    <input required type="password" name="pass" class="form-control">
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Confirmar Contraseña</label>
                                    <input required type="password" name="cpass" class="form-control">
                                </div>
                                <div class="text-center my-1">
                                    <button type="submit" name="send" class="btn btn-dark my-1">Registro</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- Masthead-->
        
        <header class="masthead">
            <div class="container-fluid px-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase fs-1">My Relax</h1>
                        <h2 class="text-white-50 mx-auto mt-2 mb-5 fs-3">Reserva ya y disfruta de una experiencia única.</h2>
                        <a class="btn btn-primary" href="#disponibilidad">Reserva tu estancia</a>
                    </div>
                </div>
            </div> 
        </header>
        <!-- Formulario Disponibilidad -->
        <?php
        
        if(isset($_POST['send1']))
        {
            $frm_data = filteration($_POST);

            $q = "INSERT INTO `disponibilidad`(`check-in`, `check-out`, `nradultos`, `nrninos`) VALUES (?,?,?,?)";
            $values = [$frm_data['check-in'],$frm_data['check-out'],$frm_data['nradultos'],$frm_data['nrninos']];

            $res = insert($q,$values,'ssss');
            if($res==1){
                alert('success', '¡Disponibilidad enviada!');
            }
            else {
                alert('error','Servidor no responde, intentelo más tarde.');
            }
        }

        ?>

        <div id="disponibilidad" class="container availability-form mt-5">
                <div class="row">
                    <div class="col-lg-12 bg-white shadow p-4 rounded">
                        <h5 class="mb-5">Dinos tu disponibilidad</h5>
                        <form method="POST">
                            <div class="row align-items-end">
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <input required type="date" name="check-in" class="form-control">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Check-out</label>
                                    <input required type="date" name="check-out" class="form-control">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Adultos</label>
                                    <select required class="form-select" name="nradultos">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 mb-3
                                    <label class="form-label">Niños</label>
                                    <select required class="form-select" name="nrninos">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 mb-lg-3 mt-2">
                                    <button type="submit" name="send1" class="btn bg-black text-white">Envía</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>   
        <!-- Servicios-->
        <section class="text-center mt-5" id="servicios">
            <div class="container-fluid px-5 bg-light">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 mt-5">
                        <h2 class="mb-4">Descubre nuestras ofertas exclusivas</h2>
                        <p class="text-black-50">
                            Hazte miembro y accede a increibles ofertas y promociones.
                        </p>
                    </div>
                </div>
                <img class="img-fluid rounded" src="assets/images/main-banner-hotel.jpg" alt="house-swimming-pool" />
            </div>
        </section>
        <!-- Habitaciones-->
        <section class="projects-section bg-light" id="habitaciones">
            <div class="container-fluid px-5">
                <!-- Habitaciones Row-->
                <div class="row gx-0 mb-5 align-items-center">
                    <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-3 mb-lg-0 rounded" src="assets/images/suiteluxury.jpg" alt="bedroom" /></div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="featured-text text-center text-lg-left">
                            <h4>Suite Rooms</h4>
                            <p class="text-black-50 mb-0">Nuestras luxury suites te harán sentir como en casa, incluye baño con jacuzzi y amplia terraza con vistas al mar o montaña.</p>
                        </div>
                    </div>
                </div>
                <!-- Habitaciones One Row-->
                <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                    <div class="col-lg-6"><img class="img-fluid" src="assets/images/bath-hotel.jpg" alt="bathroom" /></div>
                    <div class="col-lg-6">
                        <div class="bg-black text-center h-100 project">
                            <div class="d-flex h-100">
                                <div class="project-text w-100 my-auto text-center text-lg-left">
                                    <h4 class="text-white">Modern Bathrooms</h4>
                                    <p class="mb-0 text-white-50">Nuestros modernos baños incluyen todo tipo de comodidades, como ducha hidromasaje o jacuzzi. Para más infomación <a href="contacto.php">contáctanos</a>.</p>
                                    <hr class="d-none d-lg-block mb-0 ms-0" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Habitaciones Two Row-->
                <div class="row gx-0 justify-content-center">
                    <div class="col-lg-6"><img class="img-fluid" src="assets/images/breakfast-hotel.jpg" alt="breakfast" /></div>
                    <div class="col-lg-6 order-lg-first">
                        <div class="bg-black text-center h-100 project">
                            <div class="d-flex h-100">
                                <div class="project-text w-100 my-auto text-center text-lg-right">
                                    <h4 class="text-white">Desayuno Continental</h4>
                                    <p class="mb-0 text-white-50">Completo desayuno con diferentes opciones, opciones veganas. Consulta todas nuestras <a href="contacto.php">opciones.</a></p>
                                    <hr class="d-none d-lg-block mb-0 me-0" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Nuestras habitaciones -->

        <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-front">Nuestas Habitaciones</h2>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; height: 680px; margin: auto;"> 
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="assets/images/single-bed.jpg" class="d-block w-100" alt="individual">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/images/bath-hotel1.jpg" class="d-block w-100" alt="baño">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/images/piscina.jpg" class="d-block w-100" alt="piscina">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                    <div class="card-body">
                        <h5>Habitación Individual</h5>
                        <h6 class="mb-4">99€ por noche</h6>
                        <div class="features mb-4">
                            <h6 class="mb-1">Características</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Cama
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Baño
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Con Balcón
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Sofá
                            </span>
                        </div>
                        <div class="instalaciones mb-4">
                            <h6 class="mb-1">Instalaciones</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Wifi Gratuito en todo el hotel
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Televisión
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Aire Acondicionado
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Calefacción
                            </span>
                        </div>
                        <div class="huespedes mb-4">
                            <h6 class="mb-1">Huéspedes</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Adulto
                            </span>
                        </div>
                        <div class="d-flex">
                            <a href="#disponibilidad" class="btn btn-primary mt-4">Reserva Ahora</a>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; height: 680px; margin: auto;">
                <div id="carouselExampleControls1" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="assets/images/bedroom-hotel.jpg" class="d-block w-100" alt="habitacion-doble">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/images/bath-hotel1.jpg" class="d-block w-100" alt="baño">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/images/piscina.jpg" class="d-block w-100" alt="piscina">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                    <div class="card-body">
                        <h5>Habitación Doble</h5>
                        <h6 class="mb-4">149€ por noche</h6>
                        <div class="features mb-4">
                            <h6 class="mb-1">Características</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Cama Doble
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Baño
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Con Balcón
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Sofá
                            </span>
                        </div>
                        <div class="instalaciones mb-4">
                            <h6 class="mb-1">Instalaciones</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Wifi Gratuito en todo el hotel
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Televisión
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Aire Acondicionado
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Calefacción
                            </span>
                        </div>
                        <div class="huespedes mb-4">
                            <h6 class="mb-1">Huéspedes</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                2 Adultos
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Niño
                            </span>
                        </div>
                        <div class="d-flex">
                            <a href="#disponibilidad" class="btn btn-primary">Reserva Ahora</a>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; height: 680px; margin: auto;">
                <div id="carouselExampleControls2" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="assets/images/suiteluxury.jpg" class="d-block w-100" alt="habitacion-doble-luxury">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/images/luxury-bath.jpg" class="d-block w-100" alt="baño-luxury">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/images/terraza.jpg" class="d-block w-100" alt="terraza">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                    <div class="card-body">
                        <h5>Habitación Doble Luxury</h5>
                        <h6 class="mb-4">199€ por noche</h6>
                        <div class="features mb-4">
                            <h6 class="mb-1">Características</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Cama King
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Baño Luxury
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Con Terraza 
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                1 Sofá
                            </span>
                        </div>
                        <div class="instalaciones mb-4">
                            <h6 class="mb-1">Instalaciones</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Wifi Gratuito en todo el hotel
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Televisión
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Aire Acondicionado
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Calefacción
                            </span>
                        </div>
                        <div class="huespedes mb-4">
                            <h6 class="mb-1">Huéspedes</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                2 Adultos
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                2 Niños
                            </span>
                        </div>
                        <div class="d-flex">
                            <a href="#disponibilidad" class="btn btn-primary">Reserva Ahora</a>
                        </div>
                    </div>
                </div>
                </div>            
            </div>
        </div>
        <br><br><br><br><br><br>

    


    <?php require ('footer.php'); ?>

</body>
</html>    