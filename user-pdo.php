<?php

class Userpdo {

    private $_id;
    public $_login;
    public $_password;
    public $_email;
    public $_firstname;
    public $_lastname;
    private $_link;

    public function register($_login, $_password, $_email, $_firstname, $_lastname)
    {
        $_login = htmlspecialchars($_login);
        $_password = htmlspecialchars($_password);
        $_email = htmlspecialchars($_email);
        $_firstname = htmlspecialchars($_firstname);
        $_lastname = htmlspecialchars($_lastname);

        $this->_login = $_login;
        $this->_password = $_password;
        $this->_email = $_email;
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;


        $link= new PDO('mysql:host=localhost;dbname=classes', 'root', '');
        $this->_link = $link;
        $SQL = "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$_login', '$_password', '$_email', '$_firstname', '$_lastname')";
        $query = $link->query($SQL);
        $SQL2 = "SELECT * from utilisateurs WHERE login = '$_login'";
        $query2 =  $link->query($SQL2); 
        $resultat = $query2->fetch(PDO::FETCH_ASSOC);
        return $resultat;
    }

    public function connect($_login, $_password) {

        $_login = htmlspecialchars($_login);
        $_password = htmlspecialchars($_password);

        $this->_login = $_login;
        $this->_password = $_password;

        $link= new PDO('mysql:host=localhost;dbname=classes', 'root', '');
        $this->_link = $link;
        $SQL = "SELECT * FROM utilisateurs WHERE login = '$_login'";
        $query = $link->query($SQL);
        $resultat = $query->fetch(PDO::FETCH_ASSOC);

        
        
        if( $resultat == null){
            echo "il y a une erreur.";
            $this->disconnect();
        }
        else{
            if($_password == $resultat['password']){
                $this->_login = $resultat['login'];
                $this->_password = $resultat['password'];
                $this->_email = $resultat['email'];
                $this->_firstname = $resultat['firstname'];
                $this->_lastname = $resultat['lastname'];
                echo 'vous êtes bien connecté ' . $_login;
                return $resultat;
            }else{
                echo 'il y a une erreur.';
                $this->disconnect();
            }
        }
    }

    public function disconnect() {
                $this->_login = '';
                $this->_password = '';
                $this->_email = '';
                $this->_firstname = '';
                $this->_lastname = '';
                echo 'Vous êtes bien déconnecté.';
            }
    
    public function delete() {
        $_login = $this->_login;
        
        $link= new PDO('mysql:host=localhost;dbname=classes', 'root', '');
        $this->_link = $link;
        $SQL = "DELETE FROM utilisateurs WHERE login = '$_login'";
        $query = $link->query($SQL);
        //mysqli_query($link, $SQL);
            echo  'vous êtes bien mort.';
        
    }
    
    public function update($_login, $_password, $_email, $_firstname, $_lastname){
        $_login = htmlspecialchars($_login);
        $_password = htmlspecialchars($_password);
        $_email = htmlspecialchars($_email);
        $_firstname = htmlspecialchars($_firstname);
        $_lastname = htmlspecialchars($_lastname);

        $_ancienlog = $this->_login;
        $this->_login = $_login;
        $this->_password = $_password;
        $this->_email = $_email;
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;
        
        $link= new PDO('mysql:host=localhost;dbname=classes', 'root', '');
        $this->_link = $link;
        $SQL = "UPDATE utilisateurs SET login='$_login', password='$_password', email='$_email', firstname='$_firstname', lastname='$_lastname' WHERE login ='$_ancienlog'";
        $query = $link->query($SQL);                                 
        echo '<br>les info ont bien été changé.';
        
    }

    public function isConnected() {
        if(!($this->_login == '')){
            return true;
        }
        else{
            return false;
        }
    }

    public function getAllInfos() {
        
        $link= new PDO('mysql:host=localhost;dbname=classes', 'root', '');
        $this->_link = $link;
        $SQL = "SELECT * FROM utilisateurs";
        $query = $link->query($SQL);
        $resultat = $query->fetch(PDO::FETCH_ASSOC);
        return ['login' => $this->_login,
                'password' => $this->_password,
                'email' => $this->_email,
                'firstname' => $this->_firstname,
                'lastname' => $this->_lastname];
    }

    public function getLogin() {

        return ['login' => $this->_login];
    }

    public function getEmail() {

        return ['email' => $this->_email];
    }

    public function getFirstname() {

        return ['firstname' => $this->_firstname];
    }

    public function getLastname() {

        return ['lastname' => $this->_lastname];
    }

    public function refresh() {

        $_login = $this->_login;
        $link = $this->_link;
        $SQL = "SELECT * FROM utilisateurs WHERE login = '$_login'";
        $query = $link->query($SQL);
        $resultat = $query->fetch(PDO::FETCH_ASSOC);

        $this->_id = $resultat['id'];
        $this->_login = $resultat['login'];
        $this->_password = $resultat['password'];
        $this->_email =  $resultat['email'];
        $this->_firstname = $resultat['firstname'];     
        $this->_lastname = $resultat['lastname'];                       
    }
}


?>