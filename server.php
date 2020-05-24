<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "STOKS";



if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['connectDB'])){

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    #DB created
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->exec($sql);
    $sql = "use $dbname";
    $conn->exec($sql);

    if(tableExists($conn,'products')== FALSE){
    
        #Create products table

        $sql = "CREATE TABLE IF NOT EXISTS products (
            ID int(11) AUTO_INCREMENT PRIMARY KEY,
            title varchar(255) NOT NULL,
            artist varchar(255) NOT NULL,
            picture varchar(255) NOT NULL,
            description varchar(255) NOT NULL,
            timestamp varchar(255) NOT NULL,
            quantity int NOT NULL,
            price int NOT NULL)";

        $conn->exec($sql);

            
        #### create initial products
       
        $sql = "INSERT INTO products (title,artist,picture,description,timestamp,quantity,price) VALUES ('Pink Floyd','Pink Floyd','images/pink_floyd.png','Best MJ Album',NOW(),'15','150')";
        $conn->exec($sql);

        $sql = "INSERT INTO products (title,artist,picture,description,timestamp,quantity,price) VALUES ('Deneme','Queen','images/queen_the_miracle.png','Music Album',NOW(),'8', '350')";
        $conn->exec($sql);


        $sql = "INSERT INTO products (title,artist,picture,description,timestamp,quantity,price) VALUES ('Thriller','Michael Jackson','images/michael_jackson_thriller.jpg','Best MJ Album',NOW(),'5','300')";
        $conn->exec($sql);
        
        $sql = "INSERT INTO products (title,artist,picture,description,timestamp,quantity,price) VALUES ('the Works','Queen','images/queen_the_works.jpg','Music Album',NOW(),'12', '200')";
        $conn->exec($sql);
       

        echo "Succesfully created";


    }
    else{
        echo "DATABASE ALREADY EXISTS";
    }


}

catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}



}

function tableExists($pdo, $table) {

    // Try a select statement against the table
    
    try {
        $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}




?>

<form id="form" action="server.php" method="post">

    <input id = "submit" type="submit" value = "Create DATABASE" name= "connectDB" >
</form>

<input type="button" value="LOGIN" class="loginbutton" id="btnLogin" 
onClick="document.location.href='index.php'">



