<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$item = "";
foreach($items as $values)
{

    if ($item != "") {$item .= ",";}
    $item .= '{"item_id" : "'.$values['item_id'] . '",';
    $item .= '"barcode":"'.$values['barcode'] . '", ';
    $item .= '"name":"'.$values['name'] . '", ';
    $item .= '"service":"'.$values['service'] . '", ';
    $item .= '"size":"'.$this->M_sizes->get_sizeName($values['size_id']) . '",';
    $item .= '"color":"'.$this->M_colors->get_colorName($values['color_id']) . '",';
    $item .= '"size_id":"'.$values['size_id']. '",';
    $item .= '"color_id":"'.$values['color_id'] . '",';
    $item .= '"quantity":"'.$values['quantity'] . '",';
    $item .= '"avg_cost":"'.$values['avg_cost'] . '", ';
    $item .= '"unit_price":"'.$values['unit_price'] . '", ';
    $item .= '"re_stock_level":"'.$values['re_stock_level'] . '"} ';
    
    
}
$item = '['.$item.']';
echo ($item);

?>