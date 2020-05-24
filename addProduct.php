<?php


//include config.php to connect database
include_once("config.php");
$conn = config::connection();



$sql = "SELECT * FROM  products";
$statement = $conn->prepare($sql);
$statement ->execute();
$products = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="products.css">
    

    <title>Document</title>
</head>

<!--- Add Form Group ---->
<body>
    <div class= "container">
        <form action= 'addProduct.php' method="POST">

            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                <input class="form-control" name = "title" id="title">
                </div>
            </div>
            <div class="form-group row">
                <label for="artist" class="col-sm-2 col-form-label">Artist</label>
                <div class="col-sm-10">
                    <input class="form-control" name = "artist" id="artist" ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <input class="form-control" name = "description" id="description"?>
                </div>
            </div>

            <div class="form-group row">
                <label for="artist" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input class="form-control" name = "price" id="price"?>
                </div>
            </div>

            <div class="form-group row">
                <label for="artist" class="col-sm-2 col-form-label">Quantity</label>
                <div class="col-sm-10">
                    <input class="form-control" name = "quantity" id="quantity"?>
                </div>
            </div>

            <div class="form-group">
                      <label for="exampleFormControlFile1">Select Image</label>
                      <input type="file" class="form-control-file" id="image" name="image">

            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" name ="submit" id = "submit" class="btn btn-primary">Add</button>

                </div>
            </div>

        </form>
    
    
    </div>

</body>
</html>

<?php
    

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
        
        //get variables in input
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $artist = $_POST['artist'];
        $quantity = $_POST['quantity'];
        $image = $_POST['image'];
        $path = "images/";
        $image_path= $path.$image;

        // check added or not
        if(insertDetails($conn,$title,$price,$description,$artist,$image_path,$quantity))
        {
            echo "<div class='alert alert-success'>Product added</div>";
            
        }
        
        else{
        echo "<div class='alert alert-danger'>Something Wrong</div>";
        }   
        
        
       
    }

    function insertDetails($conn,$title,$price,$description,$artist,$image,$quantity){
        $query = "INSERT INTO products (title,artist,picture,description,timestamp,quantity,price) VALUES ('$title','$artist','$image','$description',NOW(),'$quantity','$price')";
        if($conn->exec($query)){
            return true;
        }
        return false;
        
        
        

    }
?>