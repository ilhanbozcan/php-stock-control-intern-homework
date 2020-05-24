<?php



include_once("config.php");
$conn = config::connection();

//get id for products info
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE ID = '$id'";

$statement = $conn->prepare($sql);
$statement ->execute();
$object = $statement->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Document</title>
</head>


<!--- Form Group to edit  --->
<body>
    <div class="container">

        <div class="header">
            <h2>EDIT</h2>
        </div>
   


        <form action= "edit.php?id=<?=$id;?> " method="POST">

        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
            <input class="form-control" name = "title" id="title"value =<?="'$object->title'"; ?>>
            </div>
        </div>
        <div class="form-group row">
            <label for="artist" class="col-sm-2 col-form-label">Artist</label>
            <div class="col-sm-10">
                <input class="form-control" name = "artist" id="artist" value =<?= "'$object->artist'" ; ?>>
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <input class="form-control" name = "description" id="description" value =<?="'$object->description'"; ?>>
            </div>
        </div>

        <div class="form-group row">
            <label for="artist" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input class="form-control" name = "price" id="price" value =<?="'$object->price'"; ?>>
            </div>
        </div>

        <div class="form-group row">
            <label for="artist" class="col-sm-2 col-form-label">Quantity</label>
            <div class="col-sm-10">
                <input class="form-control" name = "quantity" id="quantity" value =<?="'$object->quantity'"; ?>>
            </div>
        </div>

        

        <div class="form-group">
                      <label for="exampleFormControlFile1">Select Image</label>
                      <input type="file" class="form-control-file" id="image" name="image" value = <?="'$object->picture'"; ?> >

        </div>

        <div class="form-group row">
            <div class="col-sm-10">
            <button type="submit" name ="submit" id = "submit" class="btn btn-primary">Edit</button>

            </div>
        </div>

        </form>
    </div>




    
<?php
   
    function Update($conn,$title_change,$artist_change,$description_change,$price_change,$image_change,$id,$quantity_change){
        
        //set new info
        $query = $conn -> prepare(" UPDATE `products` SET `title` = '$title_change', `artist` = '$artist_change',
                                                        `description` = '$description_change',`price` = '$price_change',`picture` = '$image_change',
                                                        `quantity` = $quantity_change, `timestamp` = NOW()    WHERE `ID` = '$id'");
        $query -> execute();

        //locate index.php
        header("Location: index.php");

        
    } 

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){  
        #echo $id;
        

       
        // get changed info from input
        $title_change = $_POST['title'];
        $artist_change = $_POST['artist'];
        $description_change = $_POST['description'];
        $price_change = $_POST['price'];
        $quantity_change = $_POST['quantity'];
        $image_change = $_POST['image'];
        $path =  "images/";
        $image_change = $path.$image_change;
        
        Update($conn,$title_change,$artist_change,$description_change,$price_change,$image_change,$id,$quantity_change);
      
        
        
   
        


    }
    
    

?>


    
</body>
</html>

