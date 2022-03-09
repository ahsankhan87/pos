$(document).ready(function(){
 
 var site_url = "http://localhost/pos_new/index.php"; 
 //var site_url = "http://khybersoft.com/accounts/index.php"; //for online site
 
//auto load dropdwon in Sales form.
 $("#item_id").change(function(){
    
       /*dropdown post i.e used in sales page *///  
         $.ajax({  
            url:site_url+"/pos/c_sales/buildItemOptionsDDL",  
            data: {item_id:$(this).val()},  
            type: "POST",  
            success:function(data){  
            $("#item_options").html(data);  
            
         }
         });
                     
    });
    
 $("#item_id").change(function(){
    
       /*dropdown post i.e used in sales page *///  
         $.ajax({  
            url:site_url+"/pos/c_sales/buildItemSalePrice",  
            data: {item_id:$(this).val()},  
            type: "POST",  
            success:function(data){  
            $("#sale_price").val(data);  
            
         }
         });
                     
    });
///END////////////////////////
 
 /*dataTables  *///
 $('#dataTables-example').DataTable({
                responsive: true,
 
        });
        
 $('#example').DataTable( {
        "ajax": "http://localhost/pos_new/asset/data.json",
        "columns": [
            { "data": "name" },
            { "data": "position" },
            { "data": "office" },
            { "data": "extn" },
            { "data": "start_date" },
            { "data": "salary" }
        ]
    } );
    
 /*datepicker
 $('.datepicker').datepicker()
*///


//Left Side Main manu 
/////////////////////
 $('.manu-slider-arrow').click(function(){
     
     //when click then the manu will hide to left
     if($(this).hasClass('hide-icon')){
        
	    $( ".manu-slider-arrow, #main_nav").animate({
          left: "-200px"
		  }, 700, function() {
            // Animation complete.
          });
          
          //$("#page-wrapper").css('width','100%');
          //animate({backgroundColor:'red',left:'-200',width:'1200px'},700);
          
		  $(this).removeClass('hide-icon').addClass('show-icon'); 
          
          
        }
        else {   	
	    $( ".manu-slider-arrow, #main_nav" ).animate({
          left: "0px"
		  }, 700, function() {
            // Animation complete.
          });
          
          //$(".manu-slider-arrow").animate({left:"210"},700);
        //  $("#page-wrapper").animate({backgroundColor:'blue',left:'0'},700);
          
          $(this).removeClass('show-icon').addClass('hide-icon'); 
           
        }
     
    
        //   $('#main_nav').toggle("slide", {direction:'left'},function(){
            
           });
//Left side main manu End 
/////////////////////////

//btn in receiving form for Color and sizes      
$('#color-btn').click(function(){
    $('#color-panel-btn').css('display','none');
    $("#color-panel").css('display','block');
    
});
$('#size-btn').click(function(){
    $('#size-panel-btn').css('display','none');
    $("#size-panel").css('display','block');
});
///////////////



});
 
 