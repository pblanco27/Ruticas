$(document).ready(function(){
	$('#provincia').on('change',function(){
		limpiarDestino();
		var idProvincia = $(this).val();
		if(idProvincia){
			$.ajax({
				type:'POST',
				url:'Scripts/armarDireccion.php',
				data:'idProvincia='+idProvincia,
				success:function(html){
					if (html != ''){
						$('#canton').html(html);
					} else {
						$('#canton').html('<option value="">Seleccione una provincia primero</option>');
					}
					$('#distrito').html('<option value="">Seleccione un cantón primero</option>');
				}
			}); 
		} else {
			$('#canton').html('<option value="">Seleccione una provincia primero</option>');
			$('#distrito').html('<option value="">Seleccione un cantón primero</option>');
		}
	});
	$('#canton').on('change',function(){
		limpiarDestino();
		var idCanton = $(this).val();
		if(idCanton){
			$.ajax({
				type:'POST',
				url:'Scripts/armarDireccion.php',
				data:'idCanton='+idCanton,
				success:function(html){
					if (html != ''){
						$('#distrito').html(html);
					}else{
						$('#distrito').html('<option value="">Seleccione un cantón primero</option>');
					}
				}
			}); 
		}else{
			$('#distrito').html('<option value="">Seleccione un cantón primero</option>');
		}
	});
});