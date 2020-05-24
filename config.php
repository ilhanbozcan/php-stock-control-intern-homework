<?php
//Config class to use connection in every page 
class config{

    public static function connection(){
        //initial variables
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "STOKS";

        try{
            //connect to database
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        }
        catch(PDOException $e){
            echo $sql . "<br>" . $e->getMessage();

        }


        return $conn;
       

    }
}

?>
