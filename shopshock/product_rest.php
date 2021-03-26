<?php
    include_once("class.db.php");
    if($_SERVER["REQUEST_METHOD"]=='GET'){
        echo json_encode(product_list(),JSON_UNESCAPED_UNICODE);
    }

    function product_list(){
        $db = new database();
        $db->connect();
        $result = $db->query(" SELECT product.Product_id, product.Product_code, product.Product_Name,
		                        unit.Unit_name, brand.Brand_name, product.Cost, product.Stock_Quantity
                                FROM product,unit,brand
                                WHERE product.Unit_ID = unit.Unit_id AND product.Brand_ID = brand.Brand_id");
        $db->close();
        return $result;
    }
?>