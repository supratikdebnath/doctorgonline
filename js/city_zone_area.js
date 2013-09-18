$(document).ready(function(){
$("#city").change(function(){
$.ajax
({
	type: "POST",
	url: "ajax_zone.php",
	data: "city="+$('select#city').val(),
	success: function(msg)
		{
			$("#putvalue").html(msg);
			
					$("#zone_id").change(function(){
		
				$.ajax
				({
					type: "POST",
					url: "ajax_area.php",
					data: "area="+$('select#zone_id').val(),
					success: function(msg1)
						{
							$("#area").html(msg1);
						} 
				});
		});

		} 
});
});
		$("#zone_id").change(function(){
		
				$.ajax
				({
					type: "POST",
					url: "ajax_area.php",
					data: "area="+$('select#zone_id').val(),
					success: function(msg1)
						{
							$("#area").html(msg1);
						} 
				});
		});

});