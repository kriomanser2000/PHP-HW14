<?php
session_start();
if (!isset($_SESSION['loggedin']) || (time() - $_SESSION['start_time'] > 3600))
{
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
$_SESSION['start_time'] = time();
include 'db.php';
$sector_count = $db->query("SELECT COUNT(*) FROM Sector")->fetchColumn();
$category_count = $db->query("SELECT COUNT(*) FROM Category")->fetchColumn();
$product_count = $db->query("SELECT COUNT(*) FROM Product")->fetchColumn();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main Web</title>
</head>
<body>
<h1>Main Page</h1>
<p>Number of Sectors: <?= $sector_count ?></p>
<p>Number of Categories: <?= $category_count ?></p>
<p>Number of Products: <?= $product_count ?></p>
<form method="get" action="sectrEntrAdminBD2.php">
    <button type="submit">Add Sector</button>
</form>
<form method="get" action="category.php">
    <button type="submit" <?= $sector_count > 0 ? '' : 'disabled' ?>>Add Category</button>
</form>
<form method="get" action="product.php">
    <button type="submit" <?= $category_count > 0 ? '' : 'disabled' ?>>Add Product</button>
</form>
<form method="post" action="logoutEntrAdminBD2.php">
    <button type="submit">Log Out</button>
</form>
</body>
</html>