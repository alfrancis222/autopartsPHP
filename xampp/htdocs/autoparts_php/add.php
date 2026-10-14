<?php
require 'config.php';
$title = 'Add new collection';
$subtopics = $pdo->query('SELECT * FROM subtopics ORDER BY id')->fetchAll();
$part = ['name' => '', 'description' => '', 'price' => '', 'picture' => null, 'subtopic_id' => (int)($_GET['st'] ?? $subtopics[0]['id'])];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $part = array_merge($part, post_part());
  $errors = validate_part($pdo, $part);
  $img = null; $err = null;
  if (!$errors) {
    $img = save_image($_FILES['picture'] ?? [], $err);
    if ($err) $errors[] = $err;
  }
  if (!$errors) {
    $pdo->prepare('INSERT INTO parts (subtopic_id, name, description, price, picture) VALUES (?,?,?,?,?)')
        ->execute([$part['subtopic_id'], $part['name'], $part['description'], $part['price'], $img]);
    flash('Successfully added new collection.');
    header('Location: collection.php?st=' . $part['subtopic_id']); exit;
  }
}
$submitLabel = 'Add'; $cancelUrl = 'collection.php';
require 'header.php';
?>
<h1>Add new collection</h1>
<?php require '_form.php'; require 'footer.php'; ?>
