<?php /* expects: $part, $subtopics, $errors, $submitLabel, $cancelUrl */ ?>
<form method="post" enctype="multipart/form-data" class="form">
  <?php if ($errors): ?>
    <ul class="errors"><?php foreach ($errors as $m): ?><li><?= e($m) ?></li><?php endforeach; ?></ul>
  <?php endif; ?>

  <label>Name
    <input name="name" maxlength="100" required value="<?= e($part['name']) ?>" data-count="nameCount">
    <small><span id="nameCount">0</span>/100</small>
  </label>

  <label>Description
    <textarea name="description" maxlength="255" rows="3" data-count="descCount"><?= e($part['description']) ?></textarea>
    <small><span id="descCount">0</span>/255</small>
  </label>

  <div class="row">
    <label>Price (₱)
      <input name="price" type="number" step="0.01" min="0" required value="<?= e($part['price']) ?>">
    </label>
    <label>Subtopic
      <select name="subtopic_id">
        <?php foreach ($subtopics as $s): ?>
          <option value="<?= $s['id'] ?>" <?= (int)$part['subtopic_id'] === (int)$s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>

  <label>Picture
    <input type="file" name="picture" id="pic" accept="image/jpeg,image/png,image/webp">
    <small>JPG, PNG, or WEBP. Max 2 MB.<?= !empty($part['picture']) ? ' Leave empty to keep the current picture.' : '' ?></small>
  </label>
  <div class="preview">
    <img id="prev" alt="Picture preview" <?= !empty($part['picture']) ? 'src="uploads/' . e($part['picture']) . '"' : 'hidden' ?>>
  </div>

  <div class="actions">
    <button class="btn primary"><?= e($submitLabel) ?></button>
    <a class="btn" href="<?= e($cancelUrl) ?>">Cancel</a>
  </div>
</form>
<script>
document.querySelectorAll('[data-count]').forEach(el => {
  const out = document.getElementById(el.dataset.count);
  const upd = () => out.textContent = el.value.length;
  el.addEventListener('input', upd); upd();
});
document.getElementById('pic').addEventListener('change', e => {
  const f = e.target.files[0], img = document.getElementById('prev');
  if (f) { img.src = URL.createObjectURL(f); img.hidden = false; }
});
</script>
