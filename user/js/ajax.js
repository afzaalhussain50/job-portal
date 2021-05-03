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





	var eduRecords = $('#eduList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"process.php",
			type:"POST",
			data:{action:'listEdu'},
			dataType:"json"
		},
		"pageLength": 10
	});
	$('#addEdu').click(function(){
		$('#eduModal').modal('show');
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Education");
		$('#actionEdu').val('addEdu');
		$('#saveEdu').val('Add');
	});
	$("#eduList").on('click', '.update', function(){
		var eduId = $(this).attr("id");
		var action = 'getEdu';
		$.ajax({
			url:'process.php',
			method:"POST",
			data:{eduId:eduId, action:action},
			dataType:"json",
			success:function(data){
				$('#eduModal').modal('show');;
				$('#eduId').val(data.id);
				$('#degree').val(data.degree);
				$('#institute').val(data.institute);
				$('#from_date_edu').val(data.from_date.split(" ")[0]);
				$('#to_date_edu').val(data.to_date.split(" ")[0]);
				$('#obtained_marks').val(data.obtained_marks);
				$('#total_marks').val(data.total_marks);
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Education");
				$('#actionEdu').val('updateEdu');
				$('#saveEdu').val('Save');
			}
		})
	});
	$("#eduModal").on('submit','#eduForm', function(event){
		event.preventDefault();
		$('#saveEdu').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"process.php",
			method:"POST",
			data:formData,
			success:function(data){
				$('#eduModal').modal('hide');
				$('#saveEdu').attr('disabled', false);
				eduRecords.ajax.reload();
			}
		})
	});
	$("#eduList").on('click', '.delete', function(){
		var eduId = $(this).attr("id");
		var action = "deleteEdu";
		if(confirm("Are you sure you want to delete this education?")) {
			$.ajax({
				url:"process.php",
				method:"POST",
				data:{eduId:eduId, action:action},
				success:function(data) {
					eduRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});







	var cerRecords = $('#cerList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"process.php",
			type:"POST",
			data:{action:'listCer'},
			dataType:"json"
		},
		"pageLength": 10
	});
	$('#addCer').click(function(){
		$('#cerModal').modal('show');
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Certificate");
		$('#actionCer').val('addCer');
		$('#saveCer').val('Add');
		//alert('ok');
	});
	$("#cerList").on('click', '.update', function(){
		var cerId = $(this).attr("id");
		var action = 'getCer';
		$.ajax({
			url:'process.php',
			method:"POST",
			data:{cerId:cerId, action:action},
			dataType:"json",
			success:function(data){
				$('#cerModal').modal('show');;
				$('#cerId').val(data.id);
				$('#certificate').val(data.certificate);
				$('#certification_date').val(data.certification_date.split(" ")[0]);
				$('#cer_description').val(data.description);
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Certificate");
				$('#actionCer').val('updateCer');
				$('#saveCer').val('Save');
			}
		})
	});
	$("#cerModal").on('submit','#cerForm', function(event){
		event.preventDefault();
		$('#saveCer').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"process.php",
			method:"POST",
			data:formData,
			success:function(data){
				$('#cerModal').modal('hide');
				$('#saveCer').attr('disabled', false);
				cerRecords.ajax.reload();
			}
		})
	});
	$("#cerList").on('click', '.delete', function(){
		var cerId = $(this).attr("id");
		var action = "deleteCer";
		if(confirm("Are you sure you want to delete this certificate?")) {
			$.ajax({
				url:"process.php",
				method:"POST",
				data:{cerId:cerId, action:action},
				success:function(data) {
					cerRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
});