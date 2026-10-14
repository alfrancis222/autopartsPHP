<?php
require 'config.php';
$title = 'Deleted items';
$rows = $pdo->query('SELECT p.*, s.name AS sname FROM parts p JOIN subtopics s ON s.id = p.subtopic_id WHERE p.is_deleted = 1 ORDER BY p.deleted_at DESC')->fetchAll();
require 'header.php';
?>
<div class="bar"><h1>Deleted items</h1></div>
<?php if (!$rows): ?>
  <p class="empty">Nothing here. Parts you delete from the collection will show up so you can restore them.</p>
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
      <td class="acts"><a href="restore.php?id=<?= $r['id'] ?>">Restore</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php endif; ?>
<?php require 'footer.php'; ?>
