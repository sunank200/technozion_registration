$('.numt').change(function (e) {
   // e.preventDefault();
    $('#form-tshirt .sizes').html("");
   var rows = row();
   var numt = $(this).val();
   for(i = 0; i< numt; i++)
   $('#form-tshirt .sizes').append(rows)
    $('#tot').removeClass('hidden');
    $('.total_amt').html(parseInt(1.03*numt*220));
});

function row(){
    return '<div class="form-group">'+
                '<label class="col-sm-4 control-label">Size of T-shirt</label>'+
                '<div class="col-sm-8"><select name="tshirt_size[]" id="inputTshirt_size" class="form-control input-sm" required>'+
                   ' <option value="">-- Select One --</option>'+
                    '<option value="S">Small</option>'+
                    '<option value="M">Medium</option>'+
                    '<option value="L">Large</option>'+
                  '  <option value="XL">XL</option>'+
                    '<option value="XXL">XXL</option>'+
                '</select></div>'+
            '</div>';
}