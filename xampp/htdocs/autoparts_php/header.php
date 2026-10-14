<?php $page = basename($_SERVER['SCRIPT_NAME']); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#101316">
<title><?= e($title ?? 'Auto Parts') ?> | Auto Parts</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="top">
  <a class="brand" href="index.php" aria-label="Auto Parts home">
    <span class="brand-mark" aria-hidden="true">↗</span>
    <span>AUTO<span class="brand-light">PARTS</span></span>
  </a>
  <button class="menu-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">☰</button>
  <nav class="main-nav">
    <a href="index.php" class="<?= $page === 'index.php' ? 'on' : '' ?>">Home</a>
    <a href="collection.php" class="<?= in_array($page, ['collection.php','add.php','edit.php']) ? 'on' : '' ?>">Collection</a>
    <a href="deleted.php" class="<?= in_array($page, ['deleted.php','restore.php']) ? 'on' : '' ?>">Deleted items</a>
  </nav>
  <a class="nav-cta" href="add.php">＋ Add part</a>
</header>
<main>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  if (toggle && nav) toggle.addEventListener('click', function () {
    const open = nav.classList.toggle('nav-open');
    toggle.setAttribute('aria-expanded', String(open));
  });
});
</script>
