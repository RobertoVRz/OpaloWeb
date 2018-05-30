<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Resultado</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/stylish-portfolio.css" rel="stylesheet">
    <script type="text/javascript" src="../js/paper-full.js"></script>
</head>

<body id="page-top" class="bg-light">
	<div class="container text-center my-auto">
		<?php

			require_once("tools.php");
			$connect = new Tools();
			$conexion = $connect->connectDB();

			if ($conexion->connect_error) {
				die("La conexion falló: " . $conexion->connect_error);
			}



			$nombre = $_POST['nombre'];
			$apellidos =$_POST['apellidos'];
			$email = $_POST['email'];
			$telefono = $_POST['telefono'];
			$idea = $_POST['idea'];

			$query = "INSERT INTO idea (nombre, apellidos, email, telefono, idea)
					VALUES ('$nombre', '$apellidos', '$email', '$telefono', '$idea')";

					if($conexion->query($query) === TRUE) {

						echo "<br />" . "<h2>" . "¡Éxito!" . "</h2>";
						echo "<p>" . $nombre . ", tu idea fue registrada exitosamente, será analizada y nos pondremos en contacto en brevedad.</p>" . "\n\n";
						echo '<p><a href="../index.php"> Regresar al inicio.</a></p>';

					}

					else {
						echo "<p>Ocurrió un error al procesar tu solicitud, inténtalo de nuevo.</p>". $conexion->error;
						echo '<p><a href="../index.php"> Regresar al inicio.</a></p>';
					}
			?>
	</div>

</body>

</html>

