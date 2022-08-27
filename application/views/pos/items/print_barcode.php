<html>

<head>
    <style>
        .barcode-container {
            display:block;
            width: 60mm;
            text-align: center;
            margin:0 auto;
            background-color: #fff;
        }

       .barcode-img p.inline {
            display: inline;
            margin-top: -50px;
            
        }
        p{
            margin:0;
        }
        span {
            font-size: 13px;
        }
    </style>
    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0mm;
            /* this affects the margin in the printer settings */
        }
        .barcode-container {
            display:block;
            width: 60mm;
            text-align: center;
            margin:0 auto;
            
        }
    </style>
</head>

<body onload="window.print();">
    <script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.min.js"></script>

    <div class="barcode-container">
        <?php
        include('barcode128.php');
        // var_dump($Items);
        $product = substr(@$Items[0]['name'],0,15);
        $product_id = @$Items[0]['item_id'];
        $rate = @$_SESSION['home_currency_symbol'].' '. number_format(@$Items[0]['unit_price']);
        $barcode = @$Items[0]['barcode'];
        //echo '<div class="hidden-print"><h3>'.$product.'</h3></div>';
        for ($i = 1; $i <= $print_qty; $i++) {
            echo "<div class='barcode-img'><p>$product</p>";
            echo "<p><svg id='barcode'></svg></p>&nbsp&nbsp&nbsp&nbsp";
            echo '</div>'; // echo "<p class='inline'><span ><b>Item: $product</b></span>".bar128(stripcslashes($product_id))."<span ><b>Price: ".$rate." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
        }

        ?>

        <script>
            JsBarcode("#barcode", '<?php echo $barcode ?>', {
                text: '<?php echo $rate ?>',
                height: 25
            });
        </script>
    </div>
</body>

</html>