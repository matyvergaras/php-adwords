var comentarioVisible = 1;

function abreForm()
{
	if($("#page-form").css("display") == "none")
		$("#page-form").css("display", "block");
	$('html,body').animate({
		    scrollTop: $("#page-form").offset().top - 70
		}, 1000);
}

function activaExplicacion(indice)
{
	for(i=1; i<=7; i++)
	{
		$("#explicacion" + i).removeClass("active");
		$("#text-detalle-explicacion" + i).css("display", "none");
	}

	$("#explicacion" + indice).addClass("active");
	$("#text-detalle-explicacion" + indice).css("display", "block");
}

function bordegris(index)
{
	if(index == 4)
	{
		if($("#acepto").is(":checked"))
			$("#check-acepto").css("border", "0px");
	}
	else
	{
		var textos = [["#txtNombre", "largo"], ["#txtApellido", "largo"], ["#txtCorreoAdwords", "correo"], ["#txtCorreoContacto", "correo"]];
		$(textos[index][0]).css("border", "1px solid grey");
	}
}

function borderojo(valor)
{
	if(valor == "#acepto")
		$("#check-acepto").css("border", "1px solid red");
	else
		$(valor).css("border", "1px solid red");
}

function cambiaActiveScroll(id)
{
	for(i=2; i<=5; i++)
	{
		$("#li" + i).removeClass("active");
		$("#element" + i).removeClass("active");
	}

	var indice = 0;
	if(id != "page-form")
		indice = id.replace("page", "");

	if(indice > 1)
	{
		$("#li" + indice).addClass("active");
		$("#element" + indice).addClass("active");
	}
}

function cambiaActiveScrollUser()
{
	var position = $(this).scrollTop();

	$('.section').each(function() {
        var target = $(this).offset().top-70;
        var id = $(this).attr('id');
        
        if (position >= target) {
            if(id == "page-form")
            {
            	if($("#page-form").css("display") == "block")
            		cambiaActiveScroll(id);
            }
            else
            {
            	cambiaActiveScroll(id);
            }
        }
    });
}

function cambiaAncla(indice)
{
	if(indice > 1)
	{
		$('html,body').animate({
		    scrollTop: $("#page" + indice).offset().top - 70
		}, 1000);
	}
}

function cambio()
{
	if(comentarioVisible == 3)
	{
		$("#comentario" + comentarioVisible).toggle("slide");
		$("#comentario1").toggle("slide");
		comentarioVisible = 1;
	}
	else
	{
		$("#comentario" + comentarioVisible).toggle("slide");
		$("#comentario" + (comentarioVisible+1)).toggle("slide");
		comentarioVisible++;
	}

}

function centradoVertical()
{
	var alto = $("#derecha").height();
	var altoTextos = $("#textos-derecha").height();
	var resultado = (alto/2) - (altoTextos/2);
	$("#textos-derecha").css("margin-top", resultado);
}

function centraMenu()
{
	var ancho = $(".navbar-default").width();
	var anchoMenu = $(".navbar-nav").width();
	var margen = (ancho/2) - (anchoMenu/2);
	$(".navbar-nav").css("margin-left", margen);
}

function chevronSiguiente()
{
	if($("#page-form").css("display") == "none")
	{
		$('html,body').animate({
		    scrollTop: $("#page2").offset().top - 70
		}, 1000);
	}
	else
	{
		$('html,body').animate({
		    scrollTop: $("#page-form").offset().top - 70
		}, 1000);
	}
}

function generaGrafico1(label, color, pInicial, pFinal)
{
	var ctx = document.getElementById("circulo-ejemplo-1");
	var data = {
	    labels: [
	        label,
	        "Puedes Mejorar"
	    ],
	    datasets: [
	        {
	            data: [pInicial, pFinal],
	            backgroundColor: [
	                color,
	                "#f7f7f7"
	            ]
	        }]
	};


	var myChart = new Chart(ctx, {
	    type: 'doughnut',
	    data: data,
	    options: {
	    	responsive: false,
	    	cutoutPercentage: 80,
	    	legend: {
	    		display: false
	    	}
	    }
	});
}

function generaGrafico2(label, color, pInicial, pFinal)
{
	var ctx = document.getElementById("circulo-ejemplo-2");
	var data = {
	    labels: [
	        label,
	        "Puedes Mejorar"
	    ],
	    datasets: [
	        {
	            data: [pInicial, pFinal],
	            backgroundColor: [
	                color,
	                "#f7f7f7"
	            ]
	        }]
	};


	var myChart = new Chart(ctx, {
	    type: 'doughnut',
	    data: data,
	    options: {
	    	responsive: false,
	    	cutoutPercentage: 80,
	    	legend: {
	    		display: false
	    	}
	    }
	});
}

function generaGrafico3(label, color, pInicial, pFinal)
{
	var ctx = document.getElementById("circulo-ejemplo-3");
	var data = {
	    labels: [
	        label,
	        "Puedes Mejorar"
	    ],
	    datasets: [
	        {
	            data: [pInicial, pFinal],
	            backgroundColor: [
	                color,
	                "#f7f7f7"
	            ]
	        }]
	};


	var myChart = new Chart(ctx, {
	    type: 'doughnut',
	    data: data,
	    options: {
	    	responsive: false,
	    	cutoutPercentage: 80,
	    	legend: {
	    		display: false
	    	}
	    }
	});
}

function inicioTimer()
{
	var miVar = setInterval(cambio, 5000);
}

function modificaAltura()
{
	if($(window).width() >= 992)
	{
		var menu = 70;
		var altura = $(window).height();
		var exacta = altura - menu;
		$("#page1").height(exacta);
		$("#page-form").height(exacta);
		$(".form-columna").height(exacta);
		$("#page2").height(exacta);
		$("#page3").height(exacta);
		$("#page4").height(exacta);
		$("#page5").height(exacta);
	}
}

function poneLabel(numerico, kpi)
{
	alert("hola");
	var introducir = "<div class='label-porcentaje'>"+kpi+"<br />"+numerico+"</div>";
	$("#circulo-ejemplo-1").html($("#circulo-ejemplo-1").html() + introducir);
}

function validacorreo(valor) {
    var re = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
    return re.test($(valor).val());
}

function validaform()
{
	var textos = [["#txtNombre", "largo"], ["#txtApellido", "largo"], ["#txtCorreoAdwords", "correo"], ["#txtCorreoContacto", "correo"]];
	var vacio = false;
	var pos = -1;
	var val = "";

	for(i=0; i<textos.length; i++)
	{

		if(textos[i][1] == "largo")
		{
			val = "largo";
			if(!validalargo(textos[i][0], 2))
			{
				vacio = true;
				pos = i;
				break;
			}
		}
		else if(textos[i][1] == "correo")
		{
			val = "correo";
			if(!validacorreo($(textos[i][0])))
			{
				vacio = true;
				pos = i;
				break;
			}
		}
	}	
	
	if(vacio == true)
	{
		if(val == "largo")
			alert("Debe completar todos los campos");
		if(val == "correo")
			alert("Ingrese un correo válido");
		borderojo(textos[pos][0]);
		$(textos[pos][0]).val("");
		return false;
	}
	else
	{
		if($("#acepto").is(":checked"))
			return true;
		else
		{
			alert("Debe aceptar los términos y condiciones");
			borderojo("#acepto");
			return false;
		}
	}
}

function validalargo(valor, largo)
{
	if($(valor).val().trim().length > largo)
		return true;
	else
		return false;
}