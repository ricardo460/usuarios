<html>
<head>
	<title> Ingresar Usuario</title>
	<script src="../common/jquery-2.1.4.min.js"></script>
</head>
<header>
Ingresa los datos del Usuario
</header>
<form id="form" data-parsley-validate  method="post" autocomplete="off">
	<table>
		<tr>
			<td>Nombre Usuario:</td>
			<td> <input id="input-name" type='text' name='nombre' required></td>
		</tr>
		<tr>
			<td>Apellido:</td>
			<td><input id="input-ape" type='text' name='apellido' required></td>
		</tr>
		<tr>
			<td>Fecha Nacimiento:</td>
			<td><input id="input-fn" type="date" name="fechaNacimiento" step="1"  required></td>
		</tr>
		<tr>
			<td>Edad:</td>
			<td><input id="input-edad" type='text' name='edad' maxlength="2" required></td>
		</tr>
		<tr>
			<td>Cedula:</td>
			<td><input id="input-cedula" type='text' name='cedula' maxlength="8" required></td>
		</tr>
		<tr>
			<td>Correo:</td>
			<td><input id="input-correo" type='email' name='correo' required></td>
		</tr>
	</table>
	<button type="submit" class="btn btn-primary" name="submit">Guardar</button>
	<a href="index.php">Volver</a>
</form>
 
</html>

<script type="text/javascript">

	var ingresarUsuario = new IngresarUsuario();
	
	function IngresarUsuario(){

        var input_name = document.getElementById('input-name'),
            input_ape = document.getElementById('input-ape'),
            input_fn = document.getElementById('input-fn'),
            input_edad = document.getElementById('input-edad'),
            input_cedula = document.getElementById('input-cedula'),
            input_correo = document.getElementById('input-correo'),
            buttonSave = document.getElementById('form');

        buttonSave.addEventListener('submit', validarFormulario);

        function validarFormulario(evObject) {
            evObject.preventDefault();
        }

        buttonSave.onsubmit = function(){

            var data = {
                    action : "insertar",
                    nombre : input_name.value,
                    apellido : input_ape.value,
                    fechaNacimiento : input_fn.value,
                    edad : input_edad.value,
                    cedula : input_cedula.value,
                    correo : input_correo.value
                };

           	$.ajax({
	            type: 'POST',
	            dataType: "json",
	            url: '../controller/admin_usuario.php',
	            data: data,
	            success:function(res){
					awindow.lert("Datos Guardados");
	            },
	            error:function(res){

	            	if(res.responseText === "ok"){
	            		window.alert("Datos Guardados");
	            	}
	            	else{
	            		window.alert("Ocurrio un Error");
	            		console.log(res);
	            	}
	            }
	        });
        };

        input_edad.onkeypress = function(e){ return validarNumero(e); };
		input_cedula.onkeypress = function(e){ return validarNumero(e); };

	    function validarNumero(e){

	    	key = e.keyCode || e.which;

	        tecla = String.fromCharCode(key).toLowerCase();

	        letras = ".0123456789";

	        especiales = [32,8,37,39];

	        if(key === 45)
	        	return true;

	        for(var i in especiales){

	            if(key === especiales[i]){

	                return false;
	            }
	        }

	        if(letras.indexOf(tecla) === -1)
	            return false;
	    }

	}
</script>