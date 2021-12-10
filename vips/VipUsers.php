<?php
// Constantes para el acceso a datos...
//phpinfo();
DEFINE("_HOST_", "localhost");
DEFINE("_PORT_", "8080");
DEFINE("_USERNAME_", "root");
DEFINE("_DATABASE_", "prueba");
DEFINE("_PASSWORD_", "");

/*DEFINE("_HOST_", "localhost");
DEFINE("_PORT_", "8080");
DEFINE("_USERNAME_", "G19");
DEFINE("_DATABASE_", "db_G19");
DEFINE("_PASSWORD_", "35VHZskBwNxae");*/

require_once 'database.php';
//require_once '../codigosnucleares/php/ClientVerifyEnrollment.php';
$method = $_SERVER['REQUEST_METHOD'];
$resource = $_SERVER['REQUEST_URI'];
$cnx = Database::Conectar();
switch ($method) 
{
    case 'GET': 
		if(isset($_GET['id']) && !isset($_GET['ranking']))
		{
            $datos = "";
            $id = $_GET['id'];
            $sql = "SELECT * FROM vips WHERE Email='$id'";
            $data=Database::EjecutarConsulta($cnx, $sql);

            if (isset($data[0]))
            {
                echo "<b>ENHORABUENA ".$id." ES VIP</b><br><img src=../images/ok.gif height = 220px width = 400px>";
                break;
            }
            else 
            {
                echo "<b>LO SIENTO ".$id." NO ES VIP</b><br><img src=../images/wrong.gif height = 220px width = 400px>";
                break;
            }
		}
        if (isset($_GET['ranking']) && !isset($_GET['id']))
        {
            $sql = "SELECT Usuarios.Email, Usuarios.PuntuacionMax FROM Usuarios, vips WHERE Usuarios.Email = vips.Email;";
            $data = Database::EjecutarConsulta($cnx, $sql);
            $sql = "SELECT Usuarios.PuntuacionMax FROM Usuarios, vips WHERE Usuarios.Email = vips.Email;";
            $data2 = Database::EjecutarConsulta($cnx, $sql);

            $usuarios_desordenados = explode(" ", $data);
            $puntuacion_desordenado = explode(" ", $data2);
            
            array_multisort($puntuacion_desordenado, SORT_DESC, $usuarios_desordenados);
            if (count($puntuacion_desordenado, COUNT_RECURSIVE) >= 10)
            {
                $puntuacion_desordenado = array_slice($puntuacion_desordenado, 0, 10);
                $usuarios_desordenados = array_slice($usuarios_desordenados,0,10);
            }
            $usuarios_ordenados = implode(" ", $usuarios_desordenados);
            $puntuacion_ordenado = implode(" ", $puntuacion_desordenado);
            
            echo json_encode(array('Usuarios' => $usuarios_ordenados, 'Puntos' => $puntuacion_ordenado));
			break;
        }
		else
		{
			$sql = "SELECT * FROM vips;";
			$data = Database::EjecutarConsulta($cnx, $sql);
			
			echo $data;
			break;
		}
		break;

    case 'POST':
        $arguments = $_POST;
        $result = 0;
        $email = $arguments['email'];	

        /*$matriculado = verificarMatricula($email);
        if ($matriculado == "NO")
        {
            echo json_encode(array('Creado VIP' => "errorMatricula"));
            break;
        }*/

        $sql = "INSERT INTO vips (Email) VALUES ('$email');";
        $num = Database::EjecutarNoConsulta($cnx, $sql);

		if ($num==0)
            echo json_encode(array('Creado VIP' => "error"));
        else 
            echo json_encode(array('Creado VIP' => $email));
        break;

    case 'DELETE':
        $email = $_REQUEST['id'];
        $sql = "DELETE FROM vips WHERE Email = '$email';";
        $result = Database::EjecutarNoConsulta($cnx, $sql);	

        if ($result == 0)
            echo json_encode(array('VIP eliminado' => "error"));
                
        else 
            echo json_encode(array('VIP eliminado' => $email));
	break;
}
Database::Desconectar($cnx);