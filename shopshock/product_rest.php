<?php 
    session_start();
?>
<?php
    include_once("class.db.php");
    if($_SERVER["REQUEST_METHOD"]=='GET'){
        echo json_encode(product_list(),JSON_UNESCAPED_UNICODE);
    }else if($_SERVER["REQUEST_METHOD"]=='POST'){
        echo json_encode(create_bill($_POST));
    }else if($_SERVER["REQUEST_METHOD"]=='DEL'){
        echo json_encode([del_bill_detial($_REQUEST)]);
    }
    function product_list(){
        $db = new database();
        $db->connect();
        $sql = "SELECT Product_id,Product_code,Product_Name,
                       brand.Brand_name, unit.Unit_name,
                       product.Cost, product.Stock_Quantity
                FROM  product,brand,unit 
                WHERE product.Brand_ID = brand.Brand_id
                and   product.Unit_ID  = unit.Unit_id";
        $result = $db->query($sql);
        $db->close();
        return $result;
    }
    function create_bill(){
        $db = new database();
        $db->connect();
        $sql = "SELECT Bill_id, Bill_Status FROM bill order by Bill_id desc limit 1";
        $bill_id = 1;
        $bill_result = $db->query($sql);
        $p_id    = $_POST['p_id'];
        $p_price = $_POST['p_price'];
        $p_qty   = $_POST['p_qty'];
        if(sizeof($bill_result)==0){
            $sql = "INSERT INTO bill(Bill_id, Cus_ID, Bill_Status) VALUES ({$bill_id},{$_SESSION['cus_id']},0)";
            $result = $db->exec($sql);
            $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price) 
                    VALUES (1,{$p_id},{$p_qty},{$p_price})";
            $result = $db->exec($sql);
        }else{
            $sql = "SELECT Bill_id, Bill_Status FROM bill WHERE Cus_ID={$_SESSION['cus_id']} order by Bill_id desc limit 1";
            $user_bill_result = $db->query($sql);
            if(sizeof($user_bill_result)==1&&$user_bill_result[0][1]==0){
                $bill_id = $user_bill_result[0][0];
                $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price) 
                VALUES ({$bill_id},{$p_id},{$p_qty},{$p_price})";
                $result = $db->exec($sql);
                if($result==0){
                    //update product
                    $sql = "UPDATE bill_detail SET Quantity={$p_qty},Unit_Price={} WHERE Bill_id = {$bill_id} AND Product_ID = {$p_id}";
                    $result = $db->exec($sql);
                }
            }else{
                //create new bill
                $bill_id = $bill_result[0][0]+1;
                $sql = "INSERT INTO bill(Bill_id, Cus_ID, Bill_Status) VALUES ({$bill_id},{$_SESSION['cus_id']},0)";
                $result = $db->exec($sql);
                $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price) 
                        VALUES ({$bill_id},{$p_id},{$p_qty},{$p_price})";
                $result = $db->exec($sql);
            }
            //show_shoppingcart
            $sql = "SELECT * FROM bill where Bill_id={$bill_id}";
            $user_bill_result = $db->query($sql,MYSQLI_NUM);
            $sql = "SELECT product.Product_id, product.Product_code, product.Product_Name, Quantity,Unit_Price, 
                                (Quantity*Unit_Price) AS Total 
                    FROM bill_detail, product 
                    WHERE bill_detail.Product_ID = product.Product_id AND Bill_id={$bill_id}";
            $user_bill_result2 = $db->query($sql,MYSQLI_NUM);
        }
        $db->close();
        $myresult = [$user_bill_result[0], $user_bill_result2];
        return $myresult;
    }

    function del_bill_detial(){
        $db = new database();
        $db->connect();
        $sql = "DELETE FROM bill_detail WHERE Bill_id={$_GET['bill_id']} AND Product_ID={$_GET['id']}";
        //echo json_encode($sql);
        $result = $db->exec($sql);
        $db->close();
        return $result;
    }
?>