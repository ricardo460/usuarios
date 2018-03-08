<html>
<head>
	<title>Mostrar Usuarios</title>
	<script src="../common/jquery-2.1.4.min.js"></script>
	<script src="../common/bootstrap.min.js"></script>
    <script src="../common/dataTables.min.js"></script>
    <script src="../common/dataTables_bootstrap.min.js"></script>
    <link href="../common/bootstrap/dist/bootstrap.min.css" rel="stylesheet">
    <link href="../common/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../common/custom.css" rel="stylesheet">
    <link href="../common/dataTables.min.css" rel="stylesheet">
</head>
<body>
	<div class="x_content">
		<div id="container-filter" class="container-fluid">
		    </div>
		    <br />
		  <div class="table-responsive" style="overflow:auto;">
		    <table id="table-info" class="table l2 table-striped table-hover table-bordered table-condensed borderless" style="overflow:auto;width:100%;">
		      <tfoot>  
		        <tr>  
		            <th></th>  
		            <th></th>  
		            <th></th>  
		            <th></th>
		            <th></th>  
		            <th></th>
		            <th></th>  
		        </tr>  
		        </tfoot>
		      <thead>
		        <tr>

		          <th>ID</th>
		          <th>Nombre</th>
		          <th>Apellido</th>
		          <th>Fecha de Nacimiento</th>
		          <th>Edad</th>
		          <th>Cedula</th>
		          <th>Correo</th>
		          <th>&nbsp;</th>
		          <th>&nbsp;</th>
		        </tr>
		      </thead>
		      <tbody id = "tbody">

		      </tbody>
		    </table>
		  </div>
	</div>
	<a href="index.php">Volver</a>

	<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4><span class="fa fa-user"></span> <span id="tag.ModifyUser">Modificar Usuario</span></h4>
          </div>
          <div class="modal-body">
            <form id="form" role="form" method="post" autocomplete="off">

              <div class="form-group">
                <label for="idUsuario"><span class="fa fa-user"></span> ID</label>
                <input type="text" class="form-control" id="idUser" disabled required>
              </div>

              <div class="form-group">
                <label for="nombre"><span class="fa fa-user"></span> <span> Nombre</span></label>
                <input type="text" class="form-control" id="input-name" required="required">
              </div>

              <div class="form-group">
                <label for="apellido"><span class="fa fa-user"></span> Apellido</label>
                <input type="text" class="form-control" id="input-ape"  required="required">
              </div>

              <div class="form-group">
                <label for="nickname"><span class="fa fa-user"></span> Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="input-fn"  required="required">
              </div>

              <div class="form-group">
                <label for="nickname"><span class="fa fa-user"></span> Edad</label>
                <input type="text" class="form-control" id="input-edad"  required="required">
              </div>

              <div class="form-group">
                <label for="nickname"><span class="fa fa-user"></span> Cedula</label>
                <input type="text" class="form-control" id="input-cedula"  required="required">
              </div>

              <div class="form-group">
                <label for="nickname"><span class="fa fa-user"></span> Correo</label>
                <input type="text" class="form-control" id="input-correo"  required="required">
              </div>

              <br><br>
              <button id="editUser" type="submit" class="btn btn-success btn-block" disabled><span class="glyphicon glyphicon-check"></span> <span id="tag.Modify"></span></button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <span id="tag.Cancel"></span></button>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
<script src="../common/table-dta.js"></script>
<script type="text/javascript">

	var array = ["id","nombre", "apellido","fechaNacimiento","edad","cedula","correo"];

    document.getElementById("container-filter").innerHTML = window.tableData.createFill(array);

	var verUsuario = new VerUsuario();
	
	function VerUsuario(){

		var input_name = document.getElementById('input-name'),
            input_ape = document.getElementById('input-ape'),
            input_fn = document.getElementById('input-fn'),
            input_edad = document.getElementById('input-edad'),
            input_cedula = document.getElementById('input-cedula'),
            input_correo = document.getElementById('input-correo'),
            buttonSave = document.getElementById('form'),
            USUARIOS = null,
            IDMODI = null;

        buttonSave.addEventListener('submit', validarFormulario);

        init();

        function validarFormulario(evObject) {
            evObject.preventDefault();
        }

        buttonSave.onsubmit = function(){

            var data = {
                    action : "actualizar",
                    id : IDMODI.id,
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
					window.alert("Datos Guardados");
					window.location.reload();
	            },
	            error:function(res){
	            	if(res.responseText === "ok"){
	            		window.alert("Datos Guardados");
	            		window.location.reload();
	            	}
	            	else{
	            		window.alert("Ocurrio un Error");
	            		console.log(res);
	            	}
	            }
	        });
        };
		
        function init(){
        	chanceName();
        	var data = {
                    "action" : "mostrar"
                };

	        $.ajax({
	            type: 'POST',
	            dataType: "json",
	            url: '../controller/admin_usuario.php',
	            data: data,
	            success:function(res){
	            	USUARIOS = res;
					addTable(res);
	            },
	            error:function(res){
	            	
	            }
	        });
        }

        function addTable(listaUsuarios){

            window.tableData.destroy();

            var contents = [];

            var body = document.getElementById('tbody');

            for(var i = 0; i < listaUsuarios.length ; i++){

                var id = listaUsuarios[i].id;

                body.innerHTML += '<tr>'+
                				'<td>'+htmlEntities(listaUsuarios[i].id)+'</td>'+
                                '<td>'+htmlEntities(listaUsuarios[i].nombre)+'</td>'+
                                '<td>'+htmlEntities(listaUsuarios[i].apellido)+'</td>'+
                                '<td>'+htmlEntities(listaUsuarios[i].fechaNacimiento)+'</td>'+
                                '<td>'+htmlEntities(listaUsuarios[i].edad)+'</td>'+
                                '<td>'+htmlEntities(listaUsuarios[i].cedula)+'</td>'+
                                '<td>'+htmlEntities(listaUsuarios[i].correo)+'</td>'+
                                '<td width = "50">'+
                                    '<a href="##" class="pointer-events: none;cursor: default;">'+
                                      '<i id = "edit-'+id+'" class = "glyphicon glyphicon-pencil myBtn" ></i>'+
                                    '</a>'+
                                '</td>'+
                                '<td width = "50">'+
                                    '<a href="##" class="pointer-events: none;cursor: default;">'+
                                      '<i id = "delete-'+id+'" class = "glyphicon glyphicon-trash btnDelete" ></i>'+
                                    '</a>'+
                                '</td>'+
                             '</tr>';

                contents.push([listaUsuarios[i].id, listaUsuarios[i].nombre, listaUsuarios[i].apellido, listaUsuarios[i].fechaNacimiento, listaUsuarios[i].edad, listaUsuarios[i].cedula, listaUsuarios[i].correo ]);

                document.getElementById('edit-'+id).dataset.id = id;

                $(".myBtn").click(function(){
                    $("#myModal").modal();
                    fillModal(this.dataset.id);
                });

                document.getElementById('delete-'+id).dataset.id = id;

                $('.btnDelete').click(function(){
                    var id = this.dataset.id;
                   
                    if(window.confirm("Desea Borrar Este Usuario?"))
                        deleteUser(id);
                        
                });
            }

            window.tableData.init("table-info",contents,3);
            window.tableData.actionBars();
        }

        function deleteUser(id){

            var data = {
                "action" : "eliminar",
                "id" : id
            };

	        $.ajax({
	            type: 'POST',
	            dataType: "json",
	            url: '../controller/admin_usuario.php',
	            data: data,
	            success:function(res){
	            	window.alert("Datos Eliminados");
					window.location.reload();
	            },
	            error:function(res){
	            	if(res.responseText === "ok"){
	            		window.alert("Datos Eliminados");
	            		window.location.reload();
	            	}
	            	else{
	            		window.alert("Ocurrio un Error");
	            		console.log(res);
	            	}
	            }
	        });
        }

        function fillModal(idUser){

            var data = searchUser(idUser);

            IDMODI = data;

            document.getElementById('idUser').value = idUser;
            input_name.value = data.nombre;
            input_ape.value = data.apellido;
            input_fn.value = data.fechaNacimiento;
            input_edad.value = data.edad;
            input_cedula.value = data.cedula;
            input_correo.value = data.correo;
            validateField();
            function searchUser(id){
                for(var data in USUARIOS){
                    if(USUARIOS[data].id === id)
                        return USUARIOS[data];
                }
            }
        }

        function validateField(){


            if(validateChange()){

                document.getElementById("editUser").disabled = false;
            }
            else{
                document.getElementById("editUser").disabled = true;
            }

            function validateChange(){

                if(input_name.value.toLowerCase() !== IDMODI.nombre.toLowerCase())
                    return true;
                else if(input_ape.value.toLowerCase() !== IDMODI.apellido.toLowerCase())
                    return true;
                else if(input_fn.value !== IDMODI.fechaNacimiento)
                    return true;
                else if(input_edad.value.toLowerCase() !== IDMODI.edad.toLowerCase())
                    return true;
                else if(input_cedula.value.toLowerCase() !== IDMODI.cedula.toLowerCase())
                    return true;
                else if(input_correo.value.toLowerCase() !== IDMODI.correo.toLowerCase())
                    return true;
                else
                    return false;
            }

        }

        input_name.onkeyup = function(e){ validateField(); };
        input_ape.onkeyup = function(e){ validateField(); };
        input_fn.onchange = function(e){ validateField(); };
        input_edad.onkeyup = function(e){ validateField(); };
        input_cedula.onkeyup = function(e){ validateField(); };
        input_correo.onkeyup = function(e){ validateField(); };

        function chanceName(){
        	document.getElementById('btn-label').text = "Haga click para mostrar u ocultar la columna:";
        	document.getElementById('btn-0').text = "ID";
        	document.getElementById('btn-1').text = "Nombre";
        	document.getElementById('btn-2').text = "Apellido";
        	document.getElementById('btn-3').text = "Fecha de Nacimiento";
        	document.getElementById('btn-4').text = "Edad";
        	document.getElementById('btn-5').text = "Cedula";
        	document.getElementById('btn-6').text = "Correo";
        }

        function htmlEntities(str) {
	   		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
		}

	}
</script>