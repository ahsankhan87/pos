
<div class="row">
    <div class="col-sm-12">
   
<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('',$attributes);

?>
<div class="form-group">
  <label class="control-label col-sm-4" for="Name">Select a manufacturable item:<span class="required text-danger">* </span></label>
  <div class="col-sm-6">
    <?php echo form_dropdown('mfg_item_id',$mfg_items,'','class="form-control select2me" id="mfg_item_id"') ?>
  </div>
</div>

        
<table class="table table-bordered table-condensed"  id="sample_">
        <thead class="thead-dark">
            <tr>
                <th>Sno</th>
                <th><?php echo lang('description'); ?></th>
                <th><?php echo lang('work').' '.lang('center'); ?></th>
                <th><?php echo lang('quantity'); ?></th>
                <th><?php echo lang('action'); ?></th>
            </tr>
        </thead>
        
        <tbody id="bom_data">
       
        </tbody> 
</table>

<div class="form-group">
  <label class="control-label col-sm-2 col-sm-offset-2" for="Name">Component:<span class="required text-danger">* </span></label>
  <div class="col-sm-4">
    <?php echo form_dropdown('item_id',$items,'','class="form-control select2me" id="item_id"') ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2 col-sm-offset-2" for="Name">Work Center:<span class="required text-danger">* </span></label>
  <div class="col-sm-4">
    <?php echo form_dropdown('workcenter_id',$workcenter,'','class="form-control select2me" id="workcenter_id"') ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2 col-sm-offset-2" for="Name">Quantity:<span class="required text-danger">* </span></label>
  <div class="col-sm-4">
    <input type="number" class="form-control" id="qty" min="0" step="0.01" name="qty" placeholder="Quantity"/>
  </div>
</div>

<?php
echo '<div class="form-group"><label class="control-label col-sm-2 col-sm-offset-2" for="submit"></label>';
echo '<div class="col-sm-4">';
echo form_submit('submit','Add','class="btn btn-success"');
echo '</div></div>';

echo form_close();

?>

</div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<script>
$(document).ready(function() {

    var site_url = '<?php echo site_url($langs); ?>';
    var path = '<?php echo base_url(); ?>';

    $('#mfg_item_id').on('change', function() {
        getbillofmaterial(this.value);
        console.log(this.value);
    });

    // Display an info toast with no title
    // toastr.error('Are you the 6 fingered man?');
    // toastr.options.timeOut = 3000; // 3s

    function getbillofmaterial(item_id){
        let bom_div = '';

        $.ajax({
            url: site_url+"/mfg/C_billofmaterial/bom_JSON/"+item_id,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                //console.log(data);
                let i =0;
                $.each(data,function(index, value){
                
                bom_div += '<tr>'+
                                '<td>'+(i+1)+'</td>'+
                                '<td>'+value.item_name+'</td>'+
                                '<td>'+value.workcenter+'</td>'+
                                '<td>'+value.quantity+'</td>'+
                                '<td>'+
                                //'<a href="#" id="'+value.id+'" data-qty='+value.quantity+' data-qty='+value.workcenter+' class="edit_bom">edit</a> | '+
                                '<a href="#" id="'+value.id+'" class="del_bom">Del</a>'+
                                '</td>'+
                            '</tr>';
                            i++;
                });

            $('#bom_data').html(bom_div);
                
                /////////////////////////////
                $('.edit_bom').on('click', function() {
                    var item_id = $(this).attr('id');
                    var workcenter = $(this).attr('data-workcenter');
                    var qty = $(this).attr('data-qty');
                    
                    //$('#item_id').val(null).trigger('change');//Clearing selections;
                    $('#item_id').val(item_id).trigger('change');
                    
                    $('#workcenter_id').val(workcenter);
                    $('#qty').val(qty);
                    console.log(item_id);
                    
                });
                ///////////////////////////

                //////////////////////////
                //DELETE BOM ITEM
                $('.del_bom').on('click', function() {
                    var item_id = $(this).attr('id');
                    $.post(site_url+"/mfg/C_billofmaterial/delete/"+item_id, {'id':item_id}, function(data){
                        // Display the returned data in browser
                        //$("#result").html(data);
                        toastr.success("Item deleted successfully",'Success');
                        console.log(data);
                        getbillofmaterial($('#mfg_item_id').val());
                    });
                    
                });
                ////////////////////////////

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }

    
    $("form").submit(function(event){
            // Stop form from submitting normally
            event.preventDefault();
            
            /* Serialize the submitted form control values to be sent to the web server with the request */
            var formValues = $(this).serialize();
            
            console.log($('#item_id').val());

            if ($('#item_id').val() == 0) {
                toastr.error("Please select manufacturable item",'Error!');
            } else if($('#mfg_item_id').val() == 0){
                toastr.error("Please select component",'Error!');
            } else if($('#workcenter_id').val() == 0){
                toastr.error("Please select work center",'Error!');
            } else if($('#qty').val() == 0){
                toastr.error("Please enter quantity",'Error!');
            } else {
                // Send the form data using post
                $.post(site_url+"/mfg/C_billofmaterial/create/", formValues, function(data){
                    // Display the returned data in browser
                    //$("#result").html(data);
                    toastr.success("Data saved successfully",'Success');
                    console.log(data);
                    getbillofmaterial($('#mfg_item_id').val());
                });
            }
        });

});
</script>