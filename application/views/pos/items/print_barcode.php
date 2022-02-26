<html>
<head>
<style>
p.inline {display: inline-block;}
span { font-size: 13px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
</style>
</head>
<body onload="window.print();">
<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.min.js"></script>
        
	<div style="margin:0">
		<?php
        include('barcode128.php');
       // var_dump($Items);
		$product = @$Items[0]['name'];
		$product_id = @$Items[0]['item_id'];
        $rate = @$Items[0]['unit_price'];
        $barcode = @$Items[0]['barcode'];
        //echo '<div class="hidden-print"><h3>'.$product.'</h3></div>';
		for($i=1;$i<=$print_qty;$i++){
            echo "<div><p>$product</p>";
            echo "<p><svg id='barcode'></svg></p>&nbsp&nbsp&nbsp&nbsp";
            echo '</div>';// echo "<p class='inline'><span ><b>Item: $product</b></span>".bar128(stripcslashes($product_id))."<span ><b>Price: ".$rate." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
		}

		?>
                
        <script>
        JsBarcode("#barcode", '<?php echo $barcode ?>',{
            text:'<?php echo $barcode ?>',
             height: 25
        });
        
        </script>
	</div>
</body>
</html>