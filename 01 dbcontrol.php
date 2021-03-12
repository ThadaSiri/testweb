<?php
    class db{
        private $db;
        private $debug_mode;
        public function __construct($user,$pass,$db,$debug){
            $this->debug_mode = $debug;
            $this->db = new mysqli("localhost",$user,$pass,$db);
            $this->db->set_charset("utf8");
            if($this->db->connect_errno){
                echo "Database connect fail {$this->db->connect_error}";
                exit();
            }else{
                $this->text_debug("Database Connect success");
            }
        }

        public function query($sql){
            $result = $this->db->query($sql);
            $data = $result->fetch_all(MYSQLI_ASSOC);
            if($this->debug_mode==true) print_r($data);
            return $data;
        }

        public function close(){
            $this->db->close();
        }

        private function text_debug($text){
            if($this->debug_mode == true){
                echo $text;
            }
        }
    }
    //$my_db = new db("Thada","Adx9SpOU6NVAi7AF","book",true);
    //$my_db->query("select * from user");
?>