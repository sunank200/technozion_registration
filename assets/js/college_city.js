$("#signup-inputCity").on('change',function(){
	if($('#signup-inputCity option:selected').val()=='others'){
		$('#signup-o-inputCity').show();
		$('#college').html("<select id='signup-inputCollege' class='form-control'><option value='others'>Others</option</select><input type='text' class='form-control' name='otherCollege' placeholder='your college name' id='signup-o-inputCollege'>");
		return;
	}
	else{
	$('#signup-o-inputCollege').hide();
	$('#signup-o-inputCity').hide();
	$('#signup-inputCollege').html("");
 	$.ajax({url:"./home/get_college/"+$('#signup-inputCity').val(),success:function(result){
    var obj = jQuery.parseJSON(result);
    $('#signup-inputCollege').append("<option value=''>Select College</option>");
	$.each(obj, function(key,value) {
  		$('#signup-inputCollege').append("<option value='"+value.college_id+"'>"+value.college+"</option>");
	});
	$('#signup-inputCollege').append("<option value='others'>Others</option>");

}})}});

$('#signup-inputCollege').on('change',function(){
	if($('#signup-inputCollege').val()==('others')){
		$('#signup-o-inputCollege').show();
		return;
	}
	else{
		$('#signup-o-inputCollege').hide();
	}
});
