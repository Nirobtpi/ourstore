// $(document).ready(function() {
//     $('#addrow').click(function() {
//         alert("Hello! I am an alert box!!");
//         $('#Append').append('<tr> <td><select name="product" class="form-control" id="product"><option value="">Select Product</option><option value="">Hp</option><option value="">Acer</option><option value="">Asus</option><option value="">Walton</option></select></td> <td><select name="" class="form-control" id=""><option value="">Select Manufacture</option><option value="">Manufacture Name</option><option value="">Manufacture Name</option><option value="">Manufacture Name</option><option value="">Manufacture Name</option></select></td><td><input type="text" class="form-control" name="" placeholder="Group Name" id=""></td><td><input type="date" class="form-control" name="" placeholder="Expire" id=""></td> <td><input type="number" class="form-control" name="" placeholder="Quantity" id=""></td><td><input type="number" class="form-control" name="" placeholder="Item Price" id=""></td><td><input type="number" class="form-control" name="" placeholder="Manufacture Price" id=""> <td><a  href="javascript:void(0)" onclick="return confirm("Are You Sure?)" class="btn btn-sm btn-danger remove"><i class="fa fa-times"></i></a></td></tr>')
//     })
//     $('tbody').on('click','.remove',function(){
//         $(this).parent().parent().remove();
//     })
// });
$(document).ready(function() {
    $('#addrow').click(function() {
        alert("Hello! I am an alert box!!");
        $('#Append').append('<tr><td><select name="product" class="form-control" id="product"><option value="Hp">Hp</option><option value="Acer">Acer</option><option value="Asus">Asus</option><option value="Walton">Walton</option></select></td><td><select name="" class="form-control" id=""><option value="Hp">Hp</option><option value="Asus">Asus</option><option value="Dell">Dell</option><option value="Walton">Walton</option></select></td><td><input type="text" class="form-control" name="group_name" placeholder="Group Name"></td><td><input type="date" class="form-control" name="expire_date" placeholder="Expire" id=""></td><td><input type="number" class="form-control" name="quantity" placeholder="Quantity" id=""></td><td><input type="number" class="form-control" name="per_item_price" placeholder="Item Price" id=""></td><td><input type="number" class="form-control" name="per_item_m_price" placeholder="Manufacture Price" id=""></td><td><a onclick="return confirm("Are You Sure?")" href="javascript:void(0)" class="btn btn-sm btn-danger remove"><i class="fa fa-times"></i></a></td></tr>')
    })
    $('tbody').on('click','.remove',function(){
        $(this).parent().parent().remove();
    })
});
