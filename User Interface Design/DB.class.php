<?php
class DB {
    private $connection; 

    public function __construct() {
        global $CONFIG;

        $this->connection = odbc_connect($CONFIG['db']['name'], $CONFIG['db']['username'], $CONFIG['db']['password']);
        if (!$this->connection) {
            die("Could not connect to database.");
        }
    }

    public function query($query, $data = array()) {
        global $numqueries;

        $stmt = odbc_prepare($this->connection, $query);
        if (!$stmt) {
            die("Database query preparation failed:\n$query\n" . odbc_errormsg($this->connection));
        }

        $res = odbc_execute($stmt, $data);
        if (!$res) {
            $error = odbc_errormsg($this->connection);
            odbc_free_result($stmt); 
            die("Database query execution failed:\n$query\n$error");
        }

        $numqueries++;
        return new Result($stmt);
    }


}
?>
