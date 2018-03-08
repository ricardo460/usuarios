var tableData = new TableData();

function TableData(number){

	number = number || "";

	var TABLE = null,
		SHOWHIDE = [],
		ID = null,
		BODY = [],
		language = {
            "lengthMenu": "Motrar  _MENU_  Registros",
            "zeroRecords": "Sin Resultados ",
            "info": "",
            "infoEmpty": "Sin Resultados",
            "infoFiltered": "",
            "search": " ",
            "searchPlaceholder": "Buscar",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
                }
        },
        TAG = null;

    this.get = function(){
    	return fillExportHead();
    }

	this.init = function(id, body, limit, _order){

		ID = id;
		BODY = body;
		var order = true;
		if(_order === false)
			order = false;

		TABLE = $('#'+ID).DataTable({
	        "language": language,
	        "pagingType": "simple_numbers",
	        "lengthMenu": false,
	        scrollCollapse: true,
	        "bLengthChange": false,
	        retrieve: true,
	        destroy: true,
	        bFilter:true,
	        ordering: order
    	});
		createFoot();
		addShowHide(limit);
	};

	this.createFill = function(array, _init){

		var init = _init | 0;

    	SHOWHIDE = ['btn-label'+number];

        var structure = '<div class="table-responsive" style="overflow-x: auto; overflow-y: hidden;">'+
                        '<table >'+
                        '<tr class="success" id = "tTitle">'+
                        '<th>'+
                            '<a id="btn-bars'+number+'" onclick="window.tableData'+number+'.actionBars();" class="btn btn-default fa fa-bars"></a>'+
                        '</th>'+
                        '<th>'+
                            '<a id="btn-label'+number+'" class="btn btn-primary fa table-data"  style="background-color: #d9534f; display: none;"><span class="table-tag" id="tag.InfoPanelState"></span></a>'+
                        '</th>';

        for(var i = 0; i < array.length; i++){

        	var column = init + i; 

            structure += '<th><a id="btn-'+i+number+'" class="btn btn-primary fa table-data showHide'+number+'"  style="display: none;" data-columnindex="'+column+'"><span class="table-tag" id="'+array[i]+'"></span></a></th>'; 
        	SHOWHIDE.push('btn-'+i+number);
        }

        structure += '<th><a id="btn-E'+number+'" class="btn btn-success fa fa-floppy-o" title="Exportar a CSV" onclick="window.tableData'+number+'.export()"></a></th>';
           
        structure += '</tr></table></div>';

        return structure;
    };

    this.destroy = function(){

		if(TABLE)
			TABLE.destroy();

		if(SHOWHIDE.length >= 0){
			for(var i = 0; i < SHOWHIDE.length; i++){ 
				var element = document.getElementById(SHOWHIDE[i]);
				var opacity = 1;
		        element.dataset.state = "hide";
		        element.style.opacity = opacity;
	       	}
		}

		BODY = [];
	};

	this.actionBars = function(){

        var element = document.getElementById("btn-bars"+number);
        var enable = element.dataset.state;

        if(enable !== "hide"){
            for(i = 0; i < SHOWHIDE.length; i++)
            	show(SHOWHIDE[i]);
            element.dataset.state = "hide";
        }else{
        	for(i = 0; i < SHOWHIDE.length; i++)
            	hide(SHOWHIDE[i]);
            element.dataset.state = "show";
        }
    };

	this.export = function(){
		var head = JSON.stringify(fillExportHead()),
			body = JSON.stringify(BODY),
			data1 = btoa(head),
			data2 = btoa(body),
			name = window.prompt("ingrese nombre");

		if(name)
			window.open('../controller/exportCSV.php?data1="'+data1+'"&data2="'+data2+'"&name='+name);
	}

	function fillExportHead(){
		var array = [];

		for(var i = 1; i < SHOWHIDE.length; i++)
			array.push($("#"+SHOWHIDE[i]).text());

		return array;
	}

	function addShowHide(limit){

		var showHide = document.getElementsByClassName("showHide"+number);

	    for(var i = 0; i < showHide.length; i++){
	        showHide[i].onclick = function(){
	            var column, enable, opacity,
	                element = this;

	            column = TABLE.column(element.dataset.columnindex);

	            column.visible(!column.visible());

	            enable = element.dataset.state;

	            if(enable !== "show"){
	                opacity = 0.5;
	                element.dataset.state = "show";
	            }else{
	                opacity = 1;
	                element.dataset.state = "hide";
	            }

	            element.style.opacity = opacity;
	            $("#"+ID).css({"width": "100%"});
	        }
	        if(limit){
	        	if(i > limit)
	        		showHide[i].click();	
	        }
	    }
	}

	function createFoot(){
		$('#'+ID+' tfoot th').each(function(){

	       	/*var placeHolderTitle = $('#table-info #thead-2 th').eq($(this).index()).text();*/

	        $(this).html('<input type="text" class="form-control input input-sm" placeholder = "" />');
	    });

	    TABLE.columns().every(function () {
	        var column = this;
	        $(this.footer()).find('input').on('keyup change', function () {
	            column.search(this.value).draw();
	        });
	    });
	}

    function hide(element) {

        var dur = 1000,
            el = element;

        if(typeof(el) === "string")
            el = document.getElementById(element);

        $(el).hide("linear");
    }

    function show(element) {

        duration = 1000;

        if(typeof(element) === "string")
            element = document.getElementById(element);

        $(element).show("swing");
    }
}
