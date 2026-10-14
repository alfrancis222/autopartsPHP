<?php
require 'config.php';
$title = 'Edit collection';
$id = (int)($_GET['id'] ?? 0);
$q = $pdo->prepare('SELECT * FROM parts WHERE id = ? AND is_deleted = 0');
$q->execute([$id]);
$part = $q->fetch();
if (!$part) { header('Location: collection.php'); exit; }
$subtopics = $pdo->query('SELECT * FROM subtopics ORDER BY id')->fetchAll();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old = $part['picture'];
  $part = array_merge($part, post_part());
  $errors = validate_part($pdo, $part, $id);
  $img = null; $err = null;
  if (!$errors) {
    $img = save_image($_FILES['picture'] ?? [], $err);
    if ($err) $errors[] = $err;
  }
  if (!$errors) {
    if ($img) remove_image($old);
    $pdo->prepare('UPDATE parts SET subtopic_id=?, name=?, description=?, price=?, picture=? WHERE id=?')
        ->execute([$part['subtopic_id'], $part['name'], $part['description'], $part['price'], $img ?: $old, $id]);
    flash('Successfully edited collection.');
    header('Location: collection.php?st=' . $part['subtopic_id']); exit;
  }
  $part['picture'] = $old;
}
$submitLabel = 'Save changes'; $cancelUrl = 'collection.php';
require 'header.php';
?>
<h1>Edit collection</h1>
<?php require '_form.php'; require 'footer.php'; ?>
