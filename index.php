<?php
include 'functions.php';
?>
<html lang="en">
<?php
include "parts/head.php";
//$user = new User();
$user = User::findOneBy('id',25);
var_dump($user);
//$product= new Product();
//$product->name='Laptop';
//$product->save();

?>
<body>
<div class="container">
</div>
</body>
</html>
