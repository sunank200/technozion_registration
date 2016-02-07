/**
 * Created by anikdas on 10/2/14.
 */

$('#signup-inputCollege').on('change',function(){
    if($('#signup-inputCollege').val()!="others")
        $('#signup-o-inputCollege').val($("#signup-inputCollege option:selected").text());
    else
        $('#signup-o-inputCollege').val('');
})

$('#signup-inputCity').on('change',function(){
    if($('#signup-inputCity').val()!="others")
        $('#signup-cityname').val($("#signup-inputCity option:selected").text());
    else
        $('#signup-cityname').val('');
})