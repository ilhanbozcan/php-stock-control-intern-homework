<?php
session_start();

include_once("config.php");
$conn = config::connection();

//get id to delete
$id = $_GET["id"];

$sql = "DELETE  FROM  products WHERE ID = $id ";
$statement = $conn->prepare($sql);
$statement ->execute();

//msg added in session to show in index
$_SESSION['msg'] = "Product has been deleted";


header("location: index.php");
