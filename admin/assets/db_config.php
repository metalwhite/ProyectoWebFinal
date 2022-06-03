<?php


$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'dtvwebsite';

$con = mysqli_connect($hname, $uname, $pass, $db);

if(!$con){
    die("No se puede conectar a la base de datos".mysqli_connect_error());
}

function filteration($data){
    foreach($data as $key => $value){
        $data[$key] = trim($value);
        $data[$key] = stripslashes($value);
        $data[$key] = htmlspecialchars($value);
        $data[$key] = strip_tags($value);
    }
    return $data;
}

function select($sql,$values,$datatypes)
{
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con,$sql))
    {
        mysqli_stmt_bind_param($stmt,$datatypes,...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }    
        else{
            mysqli_stmt_close($stmt);
            die("Query no se puede ejecutar - Select");
        }
    }
    else{
        die("Query no disponible - Select");
    }
}

function insert($sql,$values,$datatypes)
{
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con,$sql))
    {
        mysqli_stmt_bind_param($stmt,$datatypes,...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }    
        else{
            mysqli_stmt_close($stmt);
            die("Query no se puede ejecutar - Insert");
        }
    }
    else{
        die("Query no disponible - Insert");
    }
}



?>