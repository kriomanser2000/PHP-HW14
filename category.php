<?php
include 'db.php';
$sectors = $db->query("SELECT id, name FROM Sector")->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name = trim($_POST['name']);
    $sector_id = $_POST['sector'];
    $stmt = $db->prepare("SELECT * FROM Category WHERE name = :name AND sector_id = :sector_id");
    $stmt->execute([':name' => $name, ':sector_id' => $sector_id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($category)
    {
        $error = "Category already exists.";
    }
    else
    {
        $stmt = $db->prepare("INSERT INTO Category (name, sector_id) VALUES (:name, :sector_id)");
        $stmt->execute([':name' => $name, ':sector_id' => $sector_id]);
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
    <title>Category</title>
</head>
<body>
<form method="post" action="category.php">
    <label for="name">Category Name: </label>
    <input type="text" id="name" name="name" required>
    <label for="sector">Select Sector: </label>
    <select id="sector" name="sector" required>
        <option value="">Select a Sector</option>
        <?php foreach ($sectors as $sector): ?>
            <option value="<?= $sector['id']; ?>"><?= $sector['name']; ?></option>
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
<?php if (isset($error)): ?>
    <p><?= $error ?></p>
<?php endif; ?>
</body>
</html>