<?php

$file = '/home/toolnutc/toolnut.com/html/update_skus.csv';
$f = fopen($file, 'r');
$sqlUpdate = '';
while (($row = fgetcsv($f, 0, ",")) !== FALSE) {
    $sqlUpdate .= "update catalog_product_entity set sku='".$row[1]."' where sku='".$row[0]."';\n";
}
echo $sqlUpdate;