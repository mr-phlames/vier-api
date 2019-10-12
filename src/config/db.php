<?php
    class Database {
        private $host = '';
        private $user = '';
        private $password = '';
        private $dbname = '';
        // private $user = 'id11174187_root';
        // private $password = 'Templerun3000';
        // private $dbname = 'id11174187_vierdb';

        public function connect($host, $user, $password, $dbname, $connectionType = "PDO") {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->dbname = $dbname;
            if($connectionType == 'PDO' || $connectionType == 'pdo') {
                return $this->connectPDO();
            } else {
                return $this->connectMysqli();
            }
        }

        public function connectMysqli() {
            try {
                $connection = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);
                return $connection;
            } catch (\Exception $e) {
                echo $e;
            }
        }

        // Connect
        public function connectPDO() {
            try {
                $connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $connection;
            } catch (\Exception $e) {
                echo $e;
            }
        }
    }
