<?php
//config.php for connect database
include_once('config.php');

// use connection function of config class
$conn = config::connection();

//Session is for messages
session_start();

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
   

    <link rel="stylesheet" href="index.css">
    

    <title>Document</title>
</head>

<!--- For delete notification  --->
<body>
    <?php
        if (isset($_SESSION["msg"])):  ?>
        <div class='alert alert-danger'>
            <?php
                echo $_SESSION["msg"];
                unset($_SESSION["msg"]);
            ?>
        </div>
        <?php endif ?>

    <!--- Form to Search  --->

    <form action="index.php"  method= 'POST'>
        <div class="form-group">
            <label for="exampleInputEmail1">Enter a Album Title or Description to Search</label>
            <input type="text" class="form-control" name="search" aria-describedby="emailHelp" placeholder="Enter title">
            
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" name="searchBtn" class="btn btn-primary">Search</button>
            </div>
        </div>
        
    </form>

    <!--- Form to Filter  --->

    <form class="filter" action="index.php"  method= 'POST'>
        <div class="form-group">
            <label for="Minumum">Minumum Price</label>
            <input type="text" class="form-control" name="minimum"  placeholder="Min">
            
        </div>
        <div class="form-group">
            <label for="Maximum">Maximum Price</label>
            <input type="text" class="form-control" name="maximum"  placeholder="Max">
            
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
                <button type="submit" name="filterBtn" class="btn btn-primary">Filter</button>
            </div>
        </div>
        
    </form>

        <!--- Form to Sort  --->

    <form class="sort" action="index.php"  method= 'POST'>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sort" id="sort" value="sortByQuantity">
            <label class="form-check-label" for="sort">
                Sort by Quantity
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sort" id="sort" value="sortByTitle">
            <label class="form-check-label" for="sort">
                Sort by Title
            </label>
        </div>
        <div class="form-check">
            <div class="col-sm-3">
                <button type="submit" name="sortBtn" class="btn btn-primary">Go</button>
            </div>
        </div>
        
    </form>



    <!--- Products Table  --->

    <div class = "container">
        <div class= "card mt-5">
            <div class="header">
                <h2>PRODUCTS</h2>
            </div>
            <div class="body">
                <table class = table table-bordered>
                    <tr>
                        <td>ID</td>
                        <td>Image</td>
                        <td>Title</td>
                        <td>Artist</td>
                        <td>Description</td>
                        <td>Timestamp</td>
                        <td>Quantity</td>
                        <td>Price</td>
                    </tr>

                    <!--- If search button clicked  --->

                    <?php if(isset($_POST['searchBtn'])): ?>

                        <?php
                        $search = $_POST["search"];
                        //Get products that contains entered text
                        $sql = "SELECT * FROM products WHERE title LIKE '%$search%' OR description LIKE '%$search%' ";
                        $statement = $conn->prepare($sql);
                        $statement ->execute();
                        $products = $statement->fetchAll(PDO::FETCH_OBJ)

                    ?>
                    <!--- If filter button clicked  --->
                    <?php elseif (isset($_POST['filterBtn'])): ?>

                        <?php
                        $minimum = $_POST["minimum"];
                        $maximum = $_POST["maximum"];
                        //Get products that entered interval
                        $sql = "SELECT * FROM products WHERE price BETWEEN '$minimum' AND '$maximum'";
                        $statement = $conn->prepare($sql);
                        $statement ->execute();
                        $products = $statement->fetchAll(PDO::FETCH_OBJ) 
                        ?>

                    <!--- If sort button clicked  --->
                     <?php elseif (isset($_POST['sortBtn'])): ?>

                        <?php
                            #echo "in";

                            $sort = $_POST["sort"];
                            if ($sort == "sortByQuantity" ){
                                //Get Products sort by quantity
                                $sql = "SELECT * FROM products  ORDER BY `quantity`";

                            }
                        
                            if ($sort == "sortByTitle" ){
                                $sql = "SELECT * FROM products  ORDER BY `title`";

                            }
                            $statement = $conn->prepare($sql);
                            $statement ->execute();
                            $products = $statement->fetchAll(PDO::FETCH_OBJ) 
                        ?>


                    <?php endif ?>

                    <!--- If Search and Filter button not clicked get initial products  --->

                    <?php foreach($products as $product): ?>
                    
                    
                    <tr>
                        
                        <td><?=$product->ID;?></td>
                        <td><img class="shop-item-image" src= <?= $product->picture; ?>></td>
                        <td><?=$product->title;?></td>
                        <td><?=$product->artist;?></td>
                        <td><?=$product->description;?></td>
                        <td><?=$product->timestamp;?></td>
                        <td><?=$product->quantity;?></td>
                        <td><?=$product->price;?></td>

                        <td>
                            <a href="edit.php?id=<?=$product->ID;?>" class = "btn btn-info"> Edit</a>
                            <a href="delete.php?id=<?=$product->ID;?>" class = "btn btn-danger"> Delete</a>
                        </td>

                    </tr>

                    <?php endforeach ?>


                </table>
                <a href="addProduct.php" class = "btn btn-success"> Add</a>
            

            </div>

        </div>
    </div>

</body>
</html>

