<?php
include 'db.php';
$categories = $db->query("SELECT id, name FROM Category")->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $make = trim($_POST['make']);
    $model = trim($_POST['model']);
    $country = trim($_POST['country']);
    $description = trim($_POST['description']);
    $category_id = $_POST['category'];
    $errors = [];
    if (empty($name) || strlen($name) > 20)
    {
        $errors[] = "Invalid name";
    }
    if (empty($make) || strlen($make) > 20)
    {
        $errors[] = "Invalid make";
    }
    if (empty($model) || strlen($model) > 20)
    {
        $errors[] = "Invalid model";
    }
    if (empty($country) || strlen($country) > 20)
    {
        $errors[] = "Invalid country";
    }
    if ($price <= 0)
    {
        $errors[] = "Invalid price";
    }
    if (empty($errors))
    {
        $stmt = $db->prepare("INSERT INTO Product (name, price, make, model, country, description, category_id)
                              VALUES (:name, :price, :make, :model, :country, :description, :category_id)");
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':make' => $make,
            ':model' => $model,
            ':country' => $country,
            ':description' => $description,
            ':category_id' => $category_id
        ]);
        header('Location: main.php');
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>
</head>
<body>
<form method="post" action="product.php">
    <label for="name">Product Name: </label>
    <input type="text" id="name" name="name" required>
    <label for="price">Price: </label>
    <input type="number" id="price" name="price" required>
    <label for="make">Make: </label>
    <input type="text" id="make" name="make" required>
    <label for="model">Model: </label>
    <input type="text" id="model" name="model" required>
    <label for="country">Country: </label>
    <input type="text" id="country" name="country" required>
    <label for="description">Description: </label>
    <textarea id="description" name="description"></textarea>
    <label for="category">Select Category: </label>
    <select id="category" name="category" required>
        <option value="">Select a Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" id="addBtn" disabled>Add</button>
</form>
    <script>
        const inputs = document.querySelectorAll('input[required], select[required]');
        const addBtn = document.getElementById('addBtn');
        inputs.forEach(input =>
        {
            input.addEventListener('input', () =>
            {
                let allFilled = true;
                inputs.forEach(input =>
                {
                    if (!input.value)
                    {
                        allFilled = false;
                    }
                });
                addBtn.disabled = !allFilled;
            });
        });
    </script>
<?php if (isset($errors) && !empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>