<?php
    header('Access-Control-Allow-Origin: *'); 
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once('./conection.php');

    $json = file_get_contents('php://input');
    $params = json_decode($json);

    $array_data[] = new stdClass; $contador = 0;
	
	if(isset($params)){
        if($params->action == 'actualizar'){
            $id = $params->id; $nombre = $params->nombre; $email = $params->email; $cargo = $params->cargo;
            $query = "UPDATE usuarios SET nameUser='$nombre',emailUser='$email',cargo='$cargo' WHERE idUser='$id'";
            $result = mysqli_query($con,$query);
            if($result){
                $array_data[$contador]->respuesta = 'Exito';
            }
        }elseif($params->action == 'nuevo'){
            $nombre = $params->nombre; $email = $params->email; $cargo = $params->cargo;
            $query = "INSERT INTO usuarios VALUES (default,'$nombre','$email','$cargo','')";
            $result = mysqli_query($con,$query);
            if($result){
                $data = mysqli_query($con,'SELECT * FROM usuarios');
                $array_data[0]->respuesta = 'Exito';
                $contador++;
                while($row = mysqli_fetch_array($data)){
                    $array_nuevo = array('id'=>$row['idUser'],'nombre'=>$row['nameUser'],'email'=>$row['emailUser'],'cargo'=>$row['cargo']);
                    $array_data[$contador] = $array_nuevo;
                    $contador++;
                }
            }
        }elseif($params->action == 'eliminar'){
            $id = $params->id;
            $eliminar = mysqli_query($con,"DELETE FROM usuarios WHERE idUser='$id'");
            if($eliminar){
                $data = mysqli_query($con,'SELECT * FROM usuarios');
                $array_data[0]->respuesta = 'Exito';
                $contador++;
                while($row = mysqli_fetch_array($data)){
                    $array_nuevo = array('id'=>$row['idUser'],'nombre'=>$row['nameUser'],'email'=>$row['emailUser'],'cargo'=>$row['cargo']);
                    $array_data[$contador] = $array_nuevo;
                    $contador++;
                }
            }
        }
	}else{
		$query = "SELECT * FROM usuarios";
	
		$result = mysqli_query($con,$query);
		if($result){
			while($row = mysqli_fetch_array($result)){
				$array_nuevo = array('id'=>$row['idUser'],'nombre'=>$row['nameUser'],'email'=>$row['emailUser'],'cargo'=>$row['cargo']);
				$array_data[$contador] = $array_nuevo;
				$contador++;
			}			
		}
	}

	echo json_encode($array_data);
    header('Content-Type: application/json');
?>