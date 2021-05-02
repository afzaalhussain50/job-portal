$(document).ready(function(){	
	var expRecords = $('#expList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"process.php",
			type:"POST",
			data:{action:'listExp'},
			dataType:"json"
		},
		"pageLength": 10
	});		
	$('#addExp').click(function(){
		$('#expModal').modal('show');
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Experience");
		$('#action').val('addExp');
		$('#save').val('Add');
	});		
	$("#expList").on('click', '.update', function(){
		var expId = $(this).attr("id");
		var action = 'getExp';
		$.ajax({
			url:'process.php',
			method:"POST",
			data:{expId:expId, action:action},
			dataType:"json",
			success:function(data){
				$('#expModal').modal('show');;
				$('#expId').val(data.id);
				$('#org_name').val(data.org_name);
				$('#designation1').val(data.designation);
				$('#description').val(data.description);
				$('#from_date').val(data.from_date.split(" ")[0]);
				$('#to_date').val(data.to_date.split(" ")[0]);
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Experience");
				$('#action').val('updateExp');
				$('#save').val('Save');
			}
		})
	});
	$("#expModal").on('submit','#expForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"process.php",
			method:"POST",
			data:formData,
			success:function(data){
				$('#expModal').modal('hide');
				$('#save').attr('disabled', false);
				expRecords.ajax.reload();
			}
		})
	});		
	$("#expList").on('click', '.delete', function(){
		var expId = $(this).attr("id");
		var action = "deleteExp";
		if(confirm("Are you sure you want to delete this experience?")) {
			$.ajax({
				url:"process.php",
				method:"POST",
				data:{expId:expId, action:action},
				success:function(data) {					
					expRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
});