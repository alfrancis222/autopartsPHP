<?php
require 'config.php';
$title = 'Collection';
$subs = $pdo->query('SELECT * FROM subtopics ORDER BY id')->fetchAll();
$st = (int)($_GET['st'] ?? 0);
if ($st) {
  $q = $pdo->prepare('SELECT p.*, s.name AS sname FROM parts p JOIN subtopics s ON s.id = p.subtopic_id WHERE p.is_deleted = 0 AND p.subtopic_id = ? ORDER BY p.id');
  $q->execute([$st]);
} else {
  $q = $pdo->query('SELECT p.*, s.name AS sname FROM parts p JOIN subtopics s ON s.id = p.subtopic_id WHERE p.is_deleted = 0 ORDER BY p.id');
}
$rows = $q->fetchAll();
require 'header.php';
?>
<div class="bar">
  <h1>Collection</h1>
  <a class="btn primary" href="add.php<?= $st ? '?st=' . $st : '' ?>">Add new collection</a>
</div>

<nav class="tabs">
  <a href="collection.php" class="<?= !$st ? 'on' : '' ?>">All</a>
  <?php foreach ($subs as $s): ?>
    <a href="collection.php?st=<?= $s['id'] ?>" class="<?= $st === (int)$s['id'] ? 'on' : '' ?>"><?= e($s['name']) ?></a>
  <?php endforeach; ?>
</nav>

<?php if (!$rows): ?>
  <p class="empty">No parts here yet. Add the first one with "Add new collection".</p>
<?php else: ?>
<div class="scroll">
<table>
  <thead><tr><th>ID</th><th>Pic</th><th>Name</th><th>Description</th><th>Price</th><th>Subtopic</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= $r['id'] ?></td>
      <td><?= $r['picture'] ? '<img class="thumb" src="uploads/' . e($r['picture']) . '" alt="">' : '<span class="thumb none">No pic</span>' ?></td>
      <td><?= e($r['name']) ?></td>
      <td class="desc"><?= e($r['description']) ?></td>
      <td><?= peso($r['price']) ?></td>
      <td><?= e($r['sname']) ?></td>
      <td class="acts">
        <a href="edit.php?id=<?= $r['id'] ?>">Edit</a>
        <form method="post" action="delete.php" onsubmit="return confirm('Move this part to Deleted items?')">
          <input type="hidden" name="id" value="<?= $r['id'] ?>">
          <button class="link danger">Delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php endif; ?>
<?php require 'footer.php'; ?>
