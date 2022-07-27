<?php
include "classes/BaseClass.php";
include "classes/User.php";
include "classes/Product.php";
$salt = 'Test@re@123';
session_start();

 $conn = mysqli_connect('45.15.23.59','root','Sco@l@it123','national-03-adina');

 function runQuery($queryParam) {
     global $conn;
     $query = mysqli_query($conn, $queryParam);
     if(!$query) {
         die("MySql error on query: $queryParam -".mysqli_error($conn));
     }
     if(is_bool($query)){
         return mysqli_insert_id($conn);
     } else {
         return $query->fetch_all(MYSQLI_ASSOC);
     }

 }

 function checkLogin() {
     if(!isset($_SESSION['user_id'])) {
         header('Location: login.php');
     }
 }

