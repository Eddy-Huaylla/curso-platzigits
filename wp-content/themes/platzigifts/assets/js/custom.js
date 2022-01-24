(function ($) {
	$('#categorias-productos').change( function () {
		$.ajax({
			url    : _PG.ajaxurl,
			method : 'POST',
			data   : {
				"action"    : "pgFiltroProductosCategoria",
				"categoria" : $(this).find(':selected').val()
			},
			beforeSend : function () {
				$('#resultado-productos').html('Cargando...');
			},
			success : function ( data ) {
				var html = "";
				data.forEach( function( item ) {
					var html_item = '<div class="col-4">';
					html_item +='<figure>'+ item.image_con_elemento +'</figure>';
					html_item += '<h4 class="my-3 text-center">';
					html_item += '<a href="' + item.link + '">';
					html_item += item.title;
					html_item += '</a>';
					html_item += '</h4>';
					html_item += '</div>';

					html += html_item;
				});

				$('#resultado-productos').html(html);
			},
			error : function ( error ) {
				console.log( error );
			}
		});
	});

	$(document).ready( function () {
		$.ajax({
			url    : _PG.apiurl+'/novedades/3',
			method : 'GET',
			beforeSend : function () {
				$('#resultados-novedades').html('Cargando...');
			},
			success : function ( data ) {
				var html = "";
				data.forEach( function( item ) {
					var html_item = '<div class="col-4">';
					html_item +='<figure>'+ item.image_con_elemento +'</figure>';
					html_item += '<h4 class="my-3 text-center">';
					html_item += '<a href="' + item.link + '">';
					html_item += item.title;
					html_item += '</a>';
					html_item += '</h4>';
					html_item += '</div>';

					html += html_item;
				});

				$('#resultados-novedades').html(html);
			},
			error : function ( error ) {
				console.log( error );
			}
		});
	})
})(jQuery);
