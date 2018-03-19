<?php # ini_set('display_errors', 1); ?> 
<?php 
require_once('Connections/cnn_data.php');
require_once('Connections/cnn_info_schema.php'); ?>
<?php 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ($_POST['procesar']==1) {

	include("ip_info.php");

	 $insertSQL = sprintf("INSERT INTO t_registro(PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, IDTipoIdentificacion, Identificacion, FechaNacimento, eMail, Genero, Celular, SmartPhone, CampoAccion, Entidad, ComoSeEntero, IPRegistro) VALUES (	%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	        GetSQLValueString($_POST['PrimerNombre'],  'text'),
	        GetSQLValueString($_POST['SegundoNombre'],  'text'),
	        GetSQLValueString($_POST['PrimerApellido'],  'text'),
	        GetSQLValueString($_POST['SegundoApellido'],  'text'),
	        GetSQLValueString($_POST['IDTipoIdentificacion'],  'int'),
	        GetSQLValueString($_POST['Identificacion'],  'int'),
	        GetSQLValueString($_POST['FechaNacimento'],  'date'),
	        GetSQLValueString($_POST['eMail'],  'text'),
	        GetSQLValueString($_POST['Genero'],  'int'),
	        GetSQLValueString($_POST['Celular'],  'text'),
	        GetSQLValueString($_POST['SmartPhone'],  'int'),
	        GetSQLValueString($_POST['CampoAccion'],  'text'),
	        GetSQLValueString($_POST['Entidad'],  'text'),
	        GetSQLValueString($_POST['ComoSeEntero'],  'text'),
	        GetSQLValueString($_POST['IPRegistro'],  'text'));
	  mysql_select_db($database_cnn_data, $cnn_data);
	   $Result1 = mysql_query($insertSQL, $cnn_data) or die(mysql_error());


	  if($_POST['Genero']==1) {$texto_genero="Masculino";} else {$texto_genero="Femenino";}
	  switch ($_POST['IDTipoIdentificacion']) {
	  	case '0': $texto_tipo_id="C.C."; break;
	  	case '1': $texto_tipo_id="C.E."; break;
	  	default: $texto_tipo_id="C.C."; break;
	  }

	// título
	$título ='Un nuevo usuario se ha registrado en mipropioempleo.com';
	// mensaje
	$mensaje = '
				<html>
				<head>
				  <title>'.$_POST["Titulo"].'</title>
				</head>
				<body>				
					<p>
						Nombre: '.$_POST["PrimerNombre"].' '.$_POST["SegundoNombre"].' '.$_POST["PrimerApellido"].' '.$_POST["SegundoApellido"].'<br>
						Documento: '.$texto_tipo_id." ".$_POST["Identificacion"].'<br>
						Fecha de nacimiento: '.$_POST["FechaNacimento"].'<br>
						Correo electronico: '.$_POST["eMail"].'<br>
						Genero: '.$texto_genero.'<br>
						Celular: '.$_POST["Celular"].'<br>
						Tengo teléfono inteligente: '.$_POST["SmartPhone"].' <br>
						Campo de acción: '.$_POST["CampoAccion"].'<br>
						Institución donde realizó o se encuentra realizando sus estudios: '.$_POST["Entidad"].'<br>
						¿Cómo se enteró de esta oportunidad?: '.$_POST["ComoSeEntero"].'<br>
					</p>
					<p>--</p>
					<p>Este mensaje fue enviado desde www.mipropioempleo.com </p>
				</body>
				</html>
				';
	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// Cabeceras adicionales
	$cabeceras .= 'To: andres.tabares@eiso.com.co' . "\r\n";
	$cabeceras .= 'From: mipropioempleo.com <andres.tabares@eiso.com.co>' . "\r\n";
	$cabeceras .= 'Cc: silenatenorio@yahoo.com' . "\r\n";
	// Enviarlo
	mail($para, $título, $mensaje, $cabeceras);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mi propio empleo</title>
	<meta name="author" content="EISO S.A.S.">
	<meta name="title" content="Mi propio empleo" />
	<meta name="description" content="">
	<meta name="keywords" content=""/>
	<link rel="stylesheet" href="css/estilos.css">
	<link rel="stylesheet" href="css/sweetalert.css">
	<script type="text/javascript" src="js/sweetalert.min.js"></script>
</head>
<body>

<img class="img-responsive"	src="img/enfermeras-escritorio.jpg" alt="Tu pasión por ayudar">
<section class="features">
	<h3 class="title">La oportunidad de negocio está abierta para crecer laboralmente</h3>		
	<ul class="grid">
		<li>
			<img class="img-ico" src="img/se-tu-propio-jefe.png" alt="Smiley face" height="60%" width="45%">
			<h4>Sé tu propio jefe</h4>
			<p>y sé dueño de tu tiempo.</p>
		</li>
		<li>
			<img class="img-ico" src="img/horario-flexible.png" alt="Smiley face" height="60%" width="45%">
			<h4>Maneja un horario flexible</h4>
			<p>y proporciona tiempo a los tuyos.</p>
		</li>
		<li>
			<img class="img-ico" src="img/mejora-tus-ingresos.png" alt="Smiley face" height="60%" width="45%">
			<h4>Mejora tus ingresos</h4>
			<p>y disfrútalos.</p>
		</li>	
	</ul>
</section>
<div class="fondoazul">
	<div class="contienetitulo">
		<h3 class="titulo">Haz parte de esta</h3>
		<h4 class="subtitulo">gran comunidad</h4>
	</div>
	<div class="formulario">
		<div class="titulo-form">
			<h1 class="titulodelformulario">Mis Datos</h1>
			<div class="separadordeltitulo"></div>
		</div>
		<form class="contenedorflex" method="POST" name="formulario" id="formulario" >
			<div class="barras" >
				<label for="PrimerNombre" class="titulosdecampos">Primer nombre</label>
				<input name="PrimerNombre" type="text" id="PrimerNombre">
			</div>
			<div class="barras">
				<label for="SegundoNombre" class="titulosdecampos">Segundo nombre</label>
				<input name="SegundoNombre" type="text" id="SegundoNombre">
			</div>
			<div class="barras">
				<label for="PrimerApellido" class="titulosdecampos">Primer apellido</label>
				<input name="PrimerApellido" type="text" id="PrimerApellido">
			</div>
			<div class="barras">
				<label for="SegundoApellido" class="titulosdecampos">Segundo apellido</label>
				<input name="SegundoApellido" type="text" id="SegundoApellido">
			</div>
			<div class="barras">
				<label for="IDTipoIdentificacion" class="titulosdecampos">Tipo de documento</label>
				<select name="IDTipoIdentificacion" id="IDTipoIdentificacion" class="identidad">
	       			<option value="0">C.C</option>
					<option value="1">C.E</option>	
				</select>
			</div>
			<div class="barras">
				<label for="Identificacion" class="titulosdecampos">Número de identidad</label>
				<input name="Identificacion" type="text" id="Identificacion">
			</div>
			<p style="margin-bottom:15px;"> El número debe ser ingresado sin puntos, ni comas.</p>
			<div class="barras">
				<label for="FechaNacimento" class="titulosdecampos">Fecha de nacimiento</label>
				<input name="FechaNacimento" class="fecha" type="date" id="FechaNacimento">
			</div>
			<div class="barras">
				<label for="eMail" class="titulosdecampos">Correo electrónico</label>
				<input name="eMail" type="text" id="eMail">
			</div>			
			<div class="barras">
				<label for="Genero" class="titulosdecampos">Género</label>
				<select name="Genero" id="Genero" class="identidad">
	        		<option value="1">Masculino</option>
					<option value="0">Femenino</option>	
				</select>
			</div>			
			<div class="barras">
				<label for="Celular" class="titulosdecampos">Celular</label>
				<input name="Celular" type="text" id="Celular" placeholder="">
			</div>	
			<div class="barras">
				<span>Tengo teléfono inteligente:</span>
			</div>			
			<div class="barras">
				<input name="SmartPhone" type="radio" id="tiene-cel" value="si" checked="">
				<label  style="margin-right: 10px;" for="tiene-cel">Sí</label>
			    <input name="SmartPhone" type="radio" id="no-tiene-cel" value="no">
			    <label for="no-tiene-cel">No</label>
			</div>			
			<div class="titulo-form">
				<h1 class="titulodelformulario">Mi Campo de acción</h1>
				<div class="separadordeltitulo"></div>
			</div>
			<div class="opciones">
				<input type="radio" id="soy-enfermera" name="CampoAccion" value="Soy enfermera" checked="">
				<label for="soy-enfermera">Soy enfermera</label>
				<br>
			    <input type="radio" id="soy-auxiliar" name="CampoAccion" value="Soy auxiliar de enfermería">
			    <label for="soy-auxiliar">Soy auxiliar de enfermería</label>
			    <br>
			    <input type="radio" id="soy-terapeuta" name="CampoAccion" value="Soy terapeuta" >
			    <label for="soy-terapeuta">Soy terapeuta</label>
				<br>
				<input type="radio" id="soy-estudiante" name="CampoAccion" value="Soy estudiante del área de salud" >
			    <label for="soy-estudiante">Soy estudiante del área de salud</label>
				<br>
			    <input type="radio" id="tengo-vocacion" name="CampoAccion" value="Tengo vocación de servicio para cuidar personas">
			    <label for="tengo-vocacion">Tengo vocación de servicio para cuidar personas</label>
			</div>
			<label class="espaciolabel" for="Entidad">Institución donde realizó o se encuentra realizando sus estudios</label>
			<input style="width: 100%; margin-bottom: 10px;" type="text" id="Entidad" name="Entidad">				
			<label class="espaciolabel" for="ComoSeEntero">¿Cómo se enteró de esta oportunidad?</label>
			<input style="width:100%;" type="text" id="ComoSeEntero" name="ComoSeEntero">
			<div class="terminos">
				<div class="check">
					<input checked class="checkmark cuadrodecheck" value="ok" type="checkbox" name="terminos" required="" id="terminos">					
				</div>
				<label class="estilocondiciones" for="terminos"> Me interesa conocer cómo tendré mi propio empleo.
					<a href="http://eiso.com.co/politicas-de-privacidad-y-tratamiento-de-datos/" target="_blank" class=" checkcontainer">Acepto términos y condiciones </a> 
				</label>
			</div>
			<input class="botonenviar" type="submit" value="Enviar">
			    <?php if ($_POST['procesar']==1) { ?>
					<script>
						swal({
						  title: "Has registrado tus datos con éxito.",
						  text: "¡Ahora eres parte de este gran comunidad!  \n Espera noticias muy pronto.  \n Equipo comunidad www.mipropioempleo.com",  
						  type: "success",
						  confirmButtonColor : "#58DEB3" ,
						  confirmButtonText: "Aceptar"
						});
					</script>
			    <?php } ?>
			<input type="hidden" name="Titulo" id="Titulo" value="Registro en mipropioempleo.com">
			<input type="hidden" name="procesar" id="procesar" value="1">
			<input type="hidden" name="IPRegistro" id="IPRegistro" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
		</form>
	</div>	
</div>	

<script>

	function validar(e) {
		var formulario 	= document.getElementById('formulario');
		var campos = [
			formulario.PrimerNombre, 
			formulario.PrimerApellido,
			formulario.IDTipoIdentificacion,
			formulario.Identificacion,
			formulario.FechaNacimento,
			formulario.eMail,
			formulario.Genero,
			formulario.Celular,
			formulario.SmartPhone,
			formulario.CampoAccion,
			formulario.Entidad,
			formulario.ComoSeEntero,
			formulario.terminos
		];

		var valido = true;

		for (var i = 0; i < campos.length; i++) {
			if (campos[i].value == '' || campos[i].value == null) {
				valido = false;
				break;
			}
		}

		if (!valido) {
			swal({
			  title: "Hay errores de validación",
			  text: "Todos los campos son obligatorios" ,  
			  type: "error",
			  confirmButtonColor : "#272727" ,
			  confirmButtonText: "Cerrar"
			});
			e.preventDefault();
		}
	}

	formulario.addEventListener('submit', validar);

</script>

</body>
</html>
