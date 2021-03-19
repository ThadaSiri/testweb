<?php
    include_once "01 dbcontrol.php";
    include_once "util.php";
    $debug_mode = false;

    if($_SERVER['REQUEST_METHOD']=='GET'){
        echo json_encode(get_data($debug_mode));

    }else if($_SERVER['REQUEST_METHOD']=='POST'){
        text_debug("POST may be support next time<br>", $debug_mode);
        if(isset($_POST["new_id"]) && isset($_POST["new_name"]) && isset($_POST["hiyaa"])){
            $new_id = $_POST["new_id"];
            $new_name = $_POST["new_name"];
            insert_newdata($new_id, $new_name ,$debug_mode);
            echo json_encode(get_data($debug_mode));
        }
    }else{
        http_response_code(405); //Error unsupport by current version
    }

    function get_data($debug_mode){
        $my_db = new db("Thada","Adx9SpOU6NVAi7AF","book", $debug_mode);
        $data = $my_db->sel_data("select * from user");
        //echo json_encode($data);
        $my_db->close();
        return $data;
    }

    function insert_newdata($new_id, $new_name, $debug_mode){
        $my_db = new db("Thada","Adx9SpOU6NVAi7AF","book", $debug_mode);
        $sql = "INSERT INTO user(id, name) VALUES ({$new_id},{$new_name})";
        $data = $my_db->query($sql);
        $my_db->close();
    }
?>