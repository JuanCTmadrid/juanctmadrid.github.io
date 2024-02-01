<?php 

// Inicializo la variable datos si esta no está ya creada.
$datos = isset($datos) ? $datos : [];
// Si hay información previa en la agenda, esta se añade a la variable datos.
if (isset($_POST['agenda'])) {
  $datos = json_decode($_POST['agenda'], true);
}

/* Variables que almacenan los datos enviados por el formulario.
  A dichos datos se les da un formato para evitar posibles duplicidades. */
$nombre = isset($_POST['nombre']) ? trim(ucfirst(htmlspecialchars($_POST['nombre']))) : '';
$telefono = isset($_POST['telefono']) ? trim(htmlspecialchars($_POST['telefono'])) : '';

/* Condicional 1: En el caso de que las variables de nombre y teléfono tengan
  datos, estas se almacenan en la variable datos. Si el nombre ya existe, se 
  modifica solo el teléfono. */
if (!empty($nombre) && !empty($telefono)) {
  $datos[$nombre] = $telefono;
/* Condicional 2: En el supuesto de que solo tenga datos la variable nombre, si
  dicho nombre existe en la variable datos, será borrado. */
} elseif (!empty($nombre) && empty($telefono)) {
  if (isset($datos[$nombre]))
    unset($datos[$nombre]);
}
?>

<!-- PAGINA PRINCIPAL AGENDA -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarea DWES02</title>
  <style>
    * {
      margin: 0px;
      padding: 0px;
    }
    body {
      background-color: darkseagreen;
      text-align: center;
      padding-top: 40px;
    }
    .contenedor {
      background-color: white;
      width: 85%;
      margin: 0 auto;
    }
    h2, section {padding: 30px 0;}
    hr {color: darkseagreen;}
    form, p {padding: 5px; text-align: left;}
    form>* {margin: 4px;}
    #boton {margin: 0 auto; background-color: darkgreen; 
      color: white; width: 80px; height: 30px;}   
  </style>
</head>
<body>
  <div class="contenedor">
    <h2>AGENDA</h2>
    <hr>
    <section>
      <div class="agenda">
        <?php
        // Muestra de los contactos existentes en la variable datos.
        foreach ($datos as $nombre => $telefono) {
          echo "<p>Nombre: " . $nombre . " - Teléfono: " . $telefono . "</p>";
        }
        // Si hay datos, se crea una línea horizontal para separar apartados.
        if (!empty($datos))
          echo "<br><hr><br>";
        ?>
      </div>
      <!--En el teléfono solo se admiten números con una longitud de 9. -->
      <div class="formulario">
        <form name="agenda" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <label for="nombre">Introduzca nombre:</label> <input type="text" name="nombre"><br>
          <label for="telefono">Introduzca teléfono:</label> <input type="tel" pattern="[0-9]{9}" name="telefono"><br>
          <!-- El input agenda va a codificar $datos para guardar la información. -->
          <input type="hidden" name="agenda" value='<?php echo json_encode($datos); ?>'>
          <input id="boton" type="submit" value="enviar">
        </form>
        <?php
          /* Si no se introduce nombre pero sí un teléfono, se genera un mensaje de
            aviso. En el caso de que no se introduzca ningún dato no va a pasar nada. */
          if (empty($_POST['nombre']) && !empty($_POST['telefono']))
          echo "<p>No ha introducido un nombre</p>";
        ?>
      </div>
    </section>
  </div>
</body>
</html>