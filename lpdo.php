<?php

class Lpdo {

    private $_host;
    private $_username;
    private $_password;
    private $_db;
    private $_query = '';
    private $_link;
    private $_table = '';

    
public function __construct($_host, $_username, $_password, $_db) 
{
  $_link = mysqli_connect($_host, $_username, $_password, $_db);
  $this->_db = $_db;
  $this->_link = $_link;

}

public function disconnect() {
    $this->_login = '';
    $this->_password = '';
    $this->_email = '';
    $this->_firstname = '';
    $this->_lastname = '';
    $_link = $this->_link;
    mysqli_close($_link);
    echo 'Deconnexion effectué.';
}

public function connect($_host, $_username, $_password, $_db)
{
    if(isset($this->_link)){
        $this->disconnect();
    $_link = mysqli_connect($_host, $_username, $_password, $_db);
    $this->_link = $_link;
    }
}


public function __destruct()
{
    $this->close();
}

public function close()
{
$_link = $this->_link;
mysqli_close($_link);
}

public function execute($_query)
{
    $_link = $this->_link;
    $SQL = mysqli_query($_link, $_query);
    $this->_query = $_query;
    $resultat = mysqli_fetch_assoc($SQL);
        return $resultat;
}

public function getLastQuery()
{
if($this->_query == '')
{
return false;
}
else
    {
    $_query= $this->_query;
    return $_query; 
    }
}

public function getLastResult()
{
    if($this->_query == '')
    {
    return false;
    }
    else
        {
        $_query= $this->_query;
        $_link = $this->_link;
        $SQL = mysqli_query($_link, $_query);
        $resultat = mysqli_fetch_assoc($SQL);
        return $resultat;
        }
}

public function getTables()
{
    $_db = $this->_db;
    $_link = $this->_link;
    $SQL = mysqli_query($_link, "SELECT table_name FROM information_schema.tables WHERE table_schema = '$_db'");
    $resultat = mysqli_fetch_assoc($SQL);
    return $resultat;

}

public function getFields($_table)
{
    if($_table == '')
    {
    return false;
    }
    else
        {
            $_link = $this->_link;
            $SQL = mysqli_query($_link, "SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where table_name = '$_table'");
            $resultat = mysqli_fetch_all($SQL);
            return $resultat;
        }
}

}

?>


 