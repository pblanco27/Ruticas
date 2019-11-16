$(document).ready(function(){
	$('#provinciaPartida').on('change',function(){
		var idProvincia = $(this).val();
		if(idProvincia){
			$.ajax({
				type:'POST',
				url:'Scripts/armarDireccion.php',
				data:'idProvincia='+idProvincia,
				success:function(html){
					if (html != ''){
						$('#cantonPartida').html(html);
					} else {
						$('#cantonPartida').html('<option value="">Seleccione una provincia primero</option>');
					}
					$('#distritoPartida').html('<option value="">Seleccione un cantón primero</option>');
				}
			}); 
		} else {
			$('#cantonPartida').html('<option value="">Seleccione una provincia primero</option>');
			$('#distritoPartida').html('<option value="">Seleccione un cantón primero</option>');
		}
	});
	$('#cantonPartida').on('change',function(){
		var idCanton = $(this).val();
		if(idCanton){
			$.ajax({
				type:'POST',
				url:'Scripts/armarDireccion.php',
				data:'idCanton='+idCanton,
				success:function(html){
					if (html != ''){
						$('#distritoPartida').html(html);
					}else{
						$('#distritoPartida').html('<option value="">Seleccione un cantón primero</option>');
					}
				}
			}); 
		}else{
			$('#distritoPartida').html('<option value="">Seleccione un cantón primero</option>');
		}
	});
});