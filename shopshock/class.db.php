<?php
    class database{
        private $db;
        function connect(){
            $this->db = new mysqli("localhost","Thada","Adx9SpOU6NVAi7AF","shopshock");
            $this->db->set_charset("utf8");
            if($this->db->connect_errno) echo "Error something";
        }

        function query($sql, $option=MYSQLI_NUM){
            $result = $this->db->query($sql);
            return $result->fetch_all($option);
        }

        function exec($sql){
            return $this->db->query($sql);
        }

        function close(){
            $this->db->close();
        }
    }

    /*$db = new database();
    $db->connect();
    print_r($db->query("select * from product"));
    $db->close();*/
?>