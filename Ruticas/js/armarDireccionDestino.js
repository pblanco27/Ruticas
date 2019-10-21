$(document).ready(function(){
	$('#provinciaDestino').on('change',function(){
		var idProvincia = $(this).val();
		if(idProvincia){
			$.ajax({
				type:'POST',
				url:'Scripts/armarDireccion.php',
				data:'idProvincia='+idProvincia,
				success:function(html){
					if (html != ''){
						$('#cantonDestino').html(html);
					} else {
						$('#cantonDestino').html('<option value="">Seleccione una provincia primero</option>');
					}
					$('#distritoDestino').html('<option value="">Seleccione un cantón primero</option>');
				}
			}); 
		} else {
			$('#cantonDestino').html('<option value="">Seleccione una provincia primero</option>');
			$('#distritoDestino').html('<option value="">Seleccione un cantón primero</option>');
		}
	});
	$('#cantonDestino').on('change',function(){
		var idCanton = $(this).val();
		if(idCanton){
			$.ajax({
				type:'POST',
				url:'Scripts/armarDireccion.php',
				data:'idCanton='+idCanton,
				success:function(html){
					if (html != ''){
						$('#distritoDestino').html(html);
					}else{
						$('#distritoDestino').html('<option value="">Seleccione un cantón primero</option>');
					}
				}
			}); 
		}else{
			$('#distritoDestino').html('<option value="">Seleccione un cantón primero</option>');
		}
	});
});