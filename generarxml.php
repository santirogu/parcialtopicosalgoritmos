<html>
<head>
    <title>Parcial TEA</title>
</head>
<body>
<form name="formulario" method="post" action="generarxml.php">
    <table>
        <tr>
            <td><label>Número de crisis a generar </label>
            <td><input type="text" id="crisis" name="crisis"><br></td>
        </tr>
        <tr>
            <td><label>Número de familias afectadas </label></td>
            <td><input type="text" id="familias" name="familias"></td>
        </tr>
        <tr>
            <td colspan="2">

                    <button type="submit" name="enviar">Enviar</button>

            </td>
        </tr>
    </table>
</form>
<?php
/**
 * Created by PhpStorm.
 * User: Santiago RG
 * Date: 07/10/2015
 * Time: 11:33
 */
header('Content-Type: text/html; charset=UTF-8');

if(isset($_POST['enviar'])){
    try{
        crearXML($_POST['crisis'], $_POST['familias']);
        echo ('XML generado exitosamente');
    }catch (Exception $e){
        echo ('Paila Error.');
    }
}
function crearXML($c, $f){
    $nombresG = simplexml_load_file('nombres.xml');
    $apellidosG = simplexml_load_file('apellidos.xml');
    $lugaresG = simplexml_load_file('lugares.xml');
    $nombresCrisisG = simplexml_load_file('nombresCrisis.xml');
    $tipoG = simplexml_load_file('tipo.xml');
    for($p = 1;$p <= $c;$p++) {
        $crisisAleatoria = rand(1,50);
        $tipoAleatoro = rand(1,17);
        $xml = new DomDocument('1.0', 'UTF-8');
        $crisis = $xml->createElement('crisis');
        $crisis = $xml->appendChild($crisis);
        $nombre = $xml->createElement('nombre',$nombresCrisisG->n1[$crisisAleatoria]);
        $nombre = $crisis->appendChild($nombre);
        $tipo = $xml->createElement('tipo',$tipoG->t[$tipoAleatoro]);
        $tipo = $crisis->appendChild($tipo);
        $fecha = $xml->createElement('fecha',rand(1,31).'/'.rand(1,12).'/'.rand(2000,2015));
        $fecha = $crisis->appendChild($fecha);
        $lugar = $xml->createElement('lugar');
        $lugar = $crisis->appendChild($lugar);
        $afectados = $xml->createElement('afectados');
        $afectados = $crisis->appendChild($afectados);
        for ($i = 1; $i <= $f; $i++) {
            $familia = $xml->createElement('familia');
            $familia = $afectados->appendChild($familia);
            $aleatorio = rand(2, 5);
            $lugarProcedenciaAleatorio = rand(1, 37);
            for ($j = 1; $j <= $aleatorio; $j++) {
                $nombreAleatorio = rand(1, 19);
                $apellidoAleatorio = rand(1, 18);
                $lugarNacimientoAleatorio = rand(1, 37);

                $afectado = $xml->createElement('afectado');
                $afectado = $familia->appendChild($afectado);
                $nombres = $xml->createElement('nombres', $nombresG->nombre[$nombreAleatorio]);
                $nombres = $afectado->appendChild($nombres);
                $apellidos = $xml->createElement('apellidos', $apellidosG->apellido[$apellidoAleatorio]);
                $apellidos = $afectado->appendChild($apellidos);
                $rol = $xml->createElement('rol');
                $rol = $afectado->appendChild($rol);
                $fechaNacimiento = $xml->createElement('fecha-nacimiento',rand(1,31).'/'.rand(1,12).'/'.rand(1940,2015));
                $fechaNacimiento = $afectado->appendChild($fechaNacimiento);
                $lugarNacimiento = $xml->createElement('lugar-nacimiento', $lugaresG->lugar[$lugarNacimientoAleatorio]);
                $lugarNacimiento = $afectado->appendChild($lugarNacimiento);
                $lugarProcedencia = $xml->createElement('lugar-procedencia', $lugaresG->lugar[$lugarProcedenciaAleatorio]);
                $lugarProcedencia = $afectado->appendChild($lugarProcedencia);
            }
        }
        $xml->formatOutput = true;
        $xml->saveXML();
        $xml->save('./archivo'.$p.'.xml');
    }
}
?>
</body>
</html>