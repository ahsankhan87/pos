<div class="row">
    <div class="col-sm-12">
    
        <div class="modal-body">
            <form class="form-horizontal" id="purchaseFileForm" action="">
               
                <div class="form-group">
                    <label class="control-label col-sm-3" for="purchase_file">File (gif,jpg,png,pdf,doc,docx):</label>
                    <div class="col-sm-9">
                    <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">
                    <input type="file" class="form-control" name="purchase_file" id="purchase_file" required="">
                    </div>
                </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
    </div>
 
</div>
<script>
$(document).ready(function() {

    var site_url = '<?php echo site_url($langs); ?>';
    var path = '<?php echo base_url(); ?>';
 
    $("#purchaseFileForm").submit(function(event){
            // Stop form from submitting normally
            event.preventDefault();
            var invoice_no = $('#invoice_no').val(); //GET INVOICE NO FROM URL
            
            /* Serialize the submitted form control values to be sent to the web server with the request */
            // var formValues = $(this).serialize();
            var formData = new FormData(this);
            var files = $('#purchase_file')[0].files;
            
            if(files != undefined){
                formData.append('purchase_file',files[0]);
            }
      
            if ($('#purchase_file').val() == 0) {
                toastr.error("Please select file",'Error!');
            } else {
                
                console.log(site_url+"/trans/C_receivings/upload_purchase_file/"+invoice_no);

                    // Send the form data using post
                    $.ajax({
                        url : site_url+"/trans/C_receivings/upload_purchase_file/"+invoice_no, 
                        type: 'POST',
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data, textStatus, jqXHR){
                            // Display the returned data in browser
                            //$("#result").html(data);
                                if(data == '1')
                                {
                                    toastr.success("Data saved successfully",'Success');
                                    window.location.href = site_url+"/trans/C_receivings/allPurchases";
                                }else
                                {
                                    toastr.error(data,'Error');
                                
                                }
                                console.log(data);
                        
                            },
                        error: function(jqXHR, textStatus, errorThrown){
                            //if fails     
                            console.log(jqXHR+' '+textStatus);
                        }
                
                    });
            }
        });

});
</script>