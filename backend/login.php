<?php
    header('Access-Control-Allow-Origin: *'); 
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once('./conection.php');

    $json = file_get_contents('php://input');
    $params = json_decode($json);

    //script para login y registro de usuarios
    if($params->user != '' && $params->password != ''){
        $user = $params->user; $password = $params->password;
        $pass_hash = md5($password);
        $sql = "SELECT * FROM usuarios WHERE emailUser='$user' AND password='$pass_hash'";
        $consultar = mysqli_query($con,$sql);
        if($consultar){
            while($data = mysqli_fetch_array($consultar)){
                echo $data['nameUser'];
            }
        }
    }

    header('Content-Type: application/json');
?>