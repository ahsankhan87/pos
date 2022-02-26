
<div class="row">
    <div class="col-sm-12">
   
<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('',$attributes);

?>
<div class="form-group">
  <label class="control-label col-sm-2" for="Name">Reference:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="reference" name="reference" placeholder="Reference" />
  </div>
</div>

<div class="form-group"><label class="control-label col-sm-2" for="type">Type:<span class="required text-danger">* </span></label>
  <div class="col-sm-10">
  <?php 
  $option = array('0'=>'Assemble','1'=>'Unassemble');//'2'=>'Advance Manufacture'
  echo form_dropdown('type',$option,'','class="form-control" id="type"');
  ?>
  </div>
</div>

<div class="form-group"><label class="control-label col-sm-2" for="mfg_item_id">Items:<span class="required text-danger">* </span></label>
  <div class="col-sm-10">
  <?php 
  echo form_dropdown('mfg_item_id',$mfg_items,'','class="form-control select2me" id="mfg_item_id"');
  ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="qty">Quantity:<span class="required text-danger">* </span></label>
  <div class="col-sm-10">
    <input type="number" class="form-control" id="qty" name="qty" value="1" placeholder="Quantity" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Date">Date:<span class="required text-danger">* </span></label>
  <div class="col-sm-10">
    <input type="date" value="<?php echo date("Y-m-d");?>" class="form-control" id="Date" name="date" placeholder="Date" />
  </div>
</div>


<div class="form-group">
  <label class="control-label col-sm-2" for="labor_cost">Labour Cost:</label>
  <div class="col-sm-10">
    <input type="number" class="form-control" id="labor_cost" name="labour_cost" placeholder="Labour Cost" />
  </div>
</div>

<div class="form-group"><label class="control-label col-sm-2" for="labour_cost_ac">Credit Labour Account:</label>
  <div class="col-sm-10">
  <?php 
  echo form_dropdown('labour_cost_ac',$accountDDL,'','class="form-control select2me" id="labour_cost_ac"');
  ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="overhead_cost">Overhead Cost:</label>
  <div class="col-sm-10">
    <input type="number" class="form-control" id="overhead_cost" name="overhead_cost" placeholder="Overhead Cost" />
  </div>
</div>

<div class="form-group"><label class="control-label col-sm-2" for="overhead_cost_ac">Credit Overhead Account:</label>
  <div class="col-sm-10">
  <?php 
  echo form_dropdown('overhead_cost_ac',$accountDDL,'','class="form-control select2me" id="overhead_cost_ac"');
  ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="description">Description:</label>
  <div class="col-sm-10">
    <textarea name="description" class="form-control"></textarea>
    
  </div>
</div>

<?php 

echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
echo '<div class="col-sm-10">';
echo form_submit('submit','Add Workorder','class="btn btn-success" id="btnSubmit"');
echo '<img id="loader" width="20" src="'.base_url().'images/wait.gif" alt="Spinner" />';
echo '</div></div>';

echo form_close();

?>
</div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
<script>
jQuery(document).ready(function() {

  var site_url = '<?php echo site_url($langs); ?>';
  var path = '<?php echo base_url(); ?>';
  $("#loader").css("display", "none");
    
  ////////////////////////
  //GET REFERENCE NO
  $.ajax({
        url: site_url+"/mfg/C_workorders/getMAXReferenceNo",
        type: 'GET',
        //dataType: 'json', // added data type
        success: function(data) 
        {
          //console.log(data);
          var ref_no = (data == '' ? 0 : parseInt(data))+1;
          var d = new Date();
          let reference_no = 'WO-'+d.getFullYear()+'-'+ref_no;
          $('#reference').val(reference_no);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
  });
  ///////////////////

  $("form").submit(function(event){
    // Stop form from submitting normally
    event.preventDefault();
    //disable the submit button
    $("#btnSubmit").attr("disabled", true);
    $("#loader").css("display", "block");
    
    /* Serialize the submitted form control values to be sent to the web server with the request */
    var formValues = $(this).serialize();
    
    var item_id = $('#mfg_item_id').val();
    var qty = $('#qty').val();
    var date = $('#date').val();
    
    if(item_id == 0){
        toastr.error("Please select item",'Error!');
        $("#btnSubmit").attr("disabled", false);
        $("#loader").css("display", "none");
        
      } else if(date == 0){
        toastr.error("Please select date",'Error!');
        $("#btnSubmit").attr("disabled", false);
        $("#loader").css("display", "none");
      
      } else if(qty == 0){
        toastr.error("Please enter quantity",'Error!');
        $("#btnSubmit").attr("disabled", false);
        $("#loader").css("display", "none");
        
      } else {
        
        //////////////////////
        //CHECK Bill of material BOM ITEM IF EXIST
        $.ajax({
          url: site_url+"/mfg/C_workorders/item_exist_in_bom/"+item_id,
          type: 'GET',
          //dataType: 'json', // added data type
          success: function(data) {
            if (data) {
              //////////////////////
              //CHECK QTY IF EXIST THEN SAVE MANUFACTURING FORM
              $.ajax({
                url: site_url+"/mfg/C_workorders/checkItemQty/"+item_id+"/"+qty,
                type: 'GET',
                //dataType: 'json', // added data type
                success: function(data) {
                  
                  if (data == 1) {

                    //Send the form data using post
                    $.post(site_url+"/mfg/C_workorders/create/", formValues, function(data){
                      //Display the returned data in browser
                      //$("#result").html(data);
                      toastr.success("Data saved successfully",'Success');
                      console.log(data);
                      
                      $("#btnSubmit").attr("disabled", false);
                      $("#loader").css("display", "none");
                      setTimeout(function(){
                        window.location.href = site_url+'/mfg/C_workorders';
                      }, 2000);

                    });
                  } else {
                    toastr.error("The work order cannot be processed because there is an insufficient quantity for component",'Error!');
                    $("#btnSubmit").attr("disabled", false);
                    $("#loader").css("display", "none");
        
                  }
                  ////////////////
                },
                error: function (xhr, ajaxOptions, thrownError) {
                  console.log(xhr.status);
                  console.log(thrownError);
                }
              });
              ///////////////////////
              ///////////////////////

            } else {
              toastr.error("The selected item to manufacture does not have a bill of material",'Error!');
              $("#btnSubmit").attr("disabled", false);
              $("#loader").css("display", "none");
        
            }
            ////////////////
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
          }
        });
        ///////////////////////
        ///////////////////////
      }
      
  });
});
</script>