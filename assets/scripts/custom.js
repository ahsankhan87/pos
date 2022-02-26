var Custom = function () {


    return {

        //main function to initiate the module
        init: function () {
			//THIS IS WILL USE IN CREATE MARKS IN STUDENT PAGE
            $("#cash, #bank").change(function () {
                if ($("#cash").is(":checked")) {
                    //$("#bank_accounts").fadeOut('slow').css("display", 'none');
                    $("#bank_accounts").fadeOut('slow');
                }
                else if ($("#bank").is(":checked")) {
                    $("#bank_accounts").fadeIn('slow').css("display", 'block');
                    //$("#bank_accounts").fadeOut('slow');   
                }
            });        
            /////
            
            
            $('#initial_qty_single').on('keyup',function(){
                  //alert('This length is ' + $(this).val().length);
                  if($(this).val().length > 0)
                  {
                    $("input[name='initial_qty\[\]']").prop("disabled", true);
                  }else
                  {
                    $("input[name='initial_qty\[\]']").prop("disabled", false);
                  }
            });
            
            $("input[name='initial_qty\[\]']").on('keyup',function(){
                  //alert('This length is ' + $(this).val().length);
                  if($(this).val().length > 0)
                  {
                    $("input[name='initial_qty_single']").prop("disabled", true);
                  }else
                  {
                    $("input[name='initial_qty_single']").prop("disabled", false);
                  }
            });
            
            
            $('#cost_price').on('keyup',function(){
                  //alert('This length is ' + $(this).val().length);
                  if($(this).val().length > 0)
                  {
                    $("input[name='size_cost_price\[\]']").prop("disabled", true);
                  }else
                  {
                    $("input[name='size_cost_price\[\]']").prop("disabled", false);
                  }
            });
            
            $('#unit_price').on('keyup',function(){
                  //alert('This length is ' + $(this).val().length);
                  if($(this).val().length > 0)
                  {
                    $("input[name='size_unit_price\[\]']").prop("disabled", true);
                  }else
                  {
                    $("input[name='size_unit_price\[\]']").prop("disabled", false);
                  }
            });
            
            $("input[name='size_cost_price\[\]']").on('keyup',function(){
                  //alert('This length is ' + $(this).val().length);
                  if($(this).val().length > 0)
                  {
                    $("input[name='cost_price']").prop("disabled", true);
                  }else
                  {
                    $("input[name='cost_price']").prop("disabled", false);
                  }
            });
            
            $("input[name='size_unit_price\[\]']").on('keyup',function(){
                  //alert('This length is ' + $(this).val().length);
                  if($(this).val().length > 0)
                  {
                    $("input[name='unit_price']").prop("disabled", true);
                  }else
                  {
                    $("input[name='unit_price']").prop("disabled", false);
                  }
            });
        }
    };

}();