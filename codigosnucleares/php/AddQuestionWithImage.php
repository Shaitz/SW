<?php
session_start();
if (!isset($_SESSION['user']))
{
  header("Location: Layout.php");
  die();
}
$error = "";
$us_email = $_SESSION['user'];

if (isset($_POST['pregunta']) && strlen($_POST['pregunta']) < 10) {
  $error .= nl2br("La pregunta debe tener 10 caracteres.\n");
}

if (isset($_POST['respuestaCorrecta']) && strlen($_POST['respuestaCorrecta']) == 0) {
  $error .= nl2br("La respuesta correcta está vacía.\n");
}

if (isset($_POST['respuestaIncorrecta1']) && strlen($_POST['respuestaIncorrecta1']) == 0) {
  $error .= nl2br("La respuesta incorrecta1 está vacía.\n");
}

if (isset($_POST['respuestaIncorrecta2']) && strlen($_POST['respuestaIncorrecta2']) == 0) {
  $error .= nl2br("La respuesta incorrecta2 está vacía.\n");
}

if (isset($_POST['respuestaIncorrecta3']) && strlen($_POST['respuestaIncorrecta3']) == 0)
{
  $error .= nl2br("La respuesta incorrecta3 está vacía.\n");
}

if (isset($_POST['tema']) && strlen($_POST['tema']) == 0) {
  $error .= nl2br("El tema está vacío.\n");
}

?>

<?php include 'DbConfig.php';
      if ($error == "" && isset($_POST['pregunta'])) 
      {
        /*                  insert into DB                    */
        $link = mysqli_connect($server, $user, $pass, $basededatos);

        if (!strlen($_FILES["imagen"]["name"]) < 1) 
        {
          $target_dir = "../images/";
          $target_file = $target_dir . $_FILES["imagen"]["name"];

          if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file))
            exit(1);

          $image = $_FILES["imagen"]["name"]; // para guardar en una variable el nombre de la imagen
          $sql = "INSERT INTO Preguntas(Email, Pregunta, CorrectAns, IncAns1, IncAns2, IncAns3, Dificultad, Tema, Imagen) VALUES ('$us_email','$_POST[pregunta]','$_POST[respuestaCorrecta]','$_POST[respuestaIncorrecta1]','$_POST[respuestaIncorrecta2]','$_POST[respuestaIncorrecta3]','$_POST[dificultad]','$_POST[tema]', '$image')";
        } 
        else 
        {
          $image = "no_image";
          $sql = "INSERT INTO Preguntas(Email, Pregunta, CorrectAns, IncAns1, IncAns2, IncAns3, Dificultad, Tema, Imagen) VALUES ('$us_email','$_POST[pregunta]','$_POST[respuestaCorrecta]','$_POST[respuestaIncorrecta1]','$_POST[respuestaIncorrecta2]','$_POST[respuestaIncorrecta3]','$_POST[dificultad]','$_POST[tema]', '$image')";
        }

        if (!mysqli_query($link, $sql))
          die('Error en la query: ' . mysqli_error($link));


        /*                  insert into XML                    */
        if (file_exists('../xml/Questions.xml'))
          $xml = simplexml_load_file('../xml/Questions.xml');
        else
          die('Error abriendo el xml.');
        
        if ($xml === FALSE)
          die('Error al procesar el xml.');

        $question = $xml->addChild('assessmentItem');
        $question->addAttribute('subject', trim($_POST['tema']));
        $question->addAttribute('author', $us_email);

        $itembody = $question->addChild('itemBody');
        $itembody->addChild('p', trim($_POST['pregunta']));

        $correctResponse = $question->addChild('correctResponse');
        $correctResponse->addChild('response', trim($_POST['respuestaCorrecta']));

        $incorrectResponses = $question->addChild('incorrectResponses');
        $incorrectResponses->addChild('response', trim($_POST['respuestaIncorrecta1']));
        $incorrectResponses->addChild('response', trim($_POST['respuestaIncorrecta2']));
        $incorrectResponses->addChild('response', trim($_POST['respuestaIncorrecta3']));

        $xmlDocument = new DOMDocument('1.0');
        $xmlDocument->preserveWhiteSpace = false;
        $xmlDocument->formatOutput = true;
        $xmlDocument->loadXML($xml->asXML());
        $xmlDocument->saveXML();

        if(!$xmlDocument->save('../xml/Questions.xml'))
          die('Error al intentar guardar los datos en el xml.');

        
        /*                  insert into JSON                    */
        $data = file_get_contents("../json/Questions.json");
        if (!$data)
          die("Error al leer el json.");

        $array = json_decode($data);
        if ($array == null)
          die("Error al decodificar el json.");

        $pregunta = new stdClass();
        $pregunta->subject = trim($_POST['tema']);
        $pregunta->author = $us_email;
        $pregunta->itemBody = array("p"=>trim($_POST['pregunta']));
        $pregunta->correctResponse = array("value"=>trim($_POST['respuestaCorrecta']));
        $pregunta->incorrectResponses = array("value"=>array(trim($_POST['respuestaIncorrecta1']),trim($_POST['respuestaIncorrecta2']),trim($_POST['respuestaIncorrecta3'])));

        $preguntaArray[0] = $pregunta;
        array_push($array->assessmentItems, $preguntaArray[0]);

        $jsonData = json_encode($array, JSON_PRETTY_PRINT);

        if(!file_put_contents("../json/Questions.json", $jsonData))
          die("Error al escribir al JSON.");

        /*                  Response                    */
        echo "Pregunta añadida correctamente.";
        mysqli_close($link);
      } else {
        echo( $error );
      }
?>