
<?php
require 'config.php';
$title = 'Home';
$subs = $pdo->query('SELECT s.id, s.name, COUNT(p.id) AS total
  FROM subtopics s LEFT JOIN parts p ON p.subtopic_id = s.id AND p.is_deleted = 0
  GROUP BY s.id ORDER BY s.id')->fetchAll();
$deleted = $pdo->query('SELECT COUNT(*) FROM parts WHERE is_deleted = 1')->fetchColumn();
$totalParts = $pdo->query('SELECT COUNT(*) FROM parts WHERE is_deleted = 0')->fetchColumn();

$categoryVisuals = [
  'engine' => ['image' => 'photo-1486262715619-67b85e0b08d3', 'icon' => '⚙', 'tagline' => 'Power your performance.'],
  'brake' => ['image' => 'photo-1517524206127-48bbd363f3d7', 'icon' => '◉', 'tagline' => 'Stop with confidence.'],
  'suspension' => ['image' => 'photo-1487754180451-c456f719a1fc', 'icon' => '↕', 'tagline' => 'Smooth ride. Better control.'],
  'electrical' => ['image' => 'photo-1492144534655-ae79c964c9d7', 'icon' => 'ϟ', 'tagline' => 'Keep your systems running.'],
  'body' => ['image' => 'photo-1503376780353-7e6692767b70', 'icon' => '🚘', 'tagline' => 'Refresh your car’s look.'],
];
function category_visual($name, $visuals) {
  $n = strtolower($name);
  foreach ($visuals as $key => $v) {
    if (strpos($n, $key) !== false || ($key === 'body' && (strpos($n, 'exterior') !== false || strpos($n, 'body') !== false))) return $v;
  }
  return ['image' => 'photo-1492144534655-ae79c964c9d7', 'icon' => '⚙', 'tagline' => 'Quality parts for every journey.'];
}
require 'header.php';
?>
<section class="hero-banner">
  <div class="hero-shade"></div>
  <div class="hero-content">
    <span class="eyebrow"><span class="eyebrow-line"></span> BUILT FOR THE DRIVE</span>
    <h1>PARTS THAT KEEP<br><span>YOU MOVING.</span></h1>
    <p>Find quality auto parts by system, built for every journey.</p>
    <div class="hero-actions">
      <a class="btn btn-red" href="collection.php">Explore parts <span aria-hidden="true">↗</span></a>
      <span class="hero-note"><span class="live-dot"></span> Your next upgrade starts here</span>
    </div>
  </div>
  <div class="hero-bottom">
    <span>PERFORMANCE <b> / </b> RELIABILITY <b> / </b> EVERYDAY DRIVING</span>
    <span class="hero-index">01 <i></i> 03</span>
  </div>
</section>

<section class="catalog-section" id="categories">
  <div class="section-heading">
    <div>
      <span class="section-kicker">FIND YOUR FIT</span>
      <h2>Shop by <span>system.</span></h2>
      <p>Explore the essentials that keep your vehicle running at its best.</p>
    </div>
    <a class="text-link" href="collection.php">View all parts <span>↗</span></a>
  </div>

  <div class="catalog-layout">
    <aside class="category-sidebar">
      <div class="sidebar-title"><span>Browse categories</span><span class="sidebar-count"><?= count($subs) ?></span></div>
      <ul class="category-list">
        <?php foreach ($subs as $s): ?>
          <?php $visual = category_visual($s['name'], $categoryVisuals); ?>
          <li>
            <a href="collection.php?st=<?= (int)$s['id'] ?>">
              <span class="category-icon"><?= e($visual['icon']) ?></span>
              <span class="category-name"><?= e($s['name']) ?></span>
              <span class="category-total"><?= (int)$s['total'] ?></span>
              <span class="category-arrow">↗</span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <a class="deleted-link" href="deleted.php"><span>Recently deleted</span><span><?= (int)$deleted ?> items →</span></a>
      <div class="sidebar-stat"><strong><?= (int)$totalParts ?></strong><span>parts in the collection</span></div>
    </aside>

    <div class="category-grid">
      <?php foreach ($subs as $i => $s): ?>
        <?php $visual = category_visual($s['name'], $categoryVisuals); ?>
        <a class="category-card category-card-<?= ($i % 4) + 1 ?>" href="collection.php?st=<?= (int)$s['id'] ?>"
           style="--card-image: url('https://images.unsplash.com/<?= e($visual['image']) ?>?auto=format&fit=crop&w=900&q=85')">
          <span class="card-topline"><span class="card-icon"><?= e($visual['icon']) ?></span><span class="card-number"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span></span>
          <span class="card-info">
            <span class="card-count"><?= (int)$s['total'] ?> <?= (int)$s['total'] === 1 ? 'ITEM' : 'ITEMS' ?></span>
            <strong><?= e($s['name']) ?></strong>
            <span class="card-tagline"><?= e($visual['tagline']) ?></span>
          </span>
          <span class="card-arrow" aria-hidden="true">↗</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<section class="about-panel" id="about">

<img
    src="images/koko.jpg"
    alt="My beach photo"
    class="about-photo"
>

  <div class="about-copy">
    <span class="section-kicker">THE STORY BEHIND THE SITE</span>

    <h2>Made for people<br>who love the <span>drive.</span></h2>

    <p>
      This is a simple auto parts catalog built for car enthusiasts
      and everyday drivers. Browse parts by vehicle system and find
      the details you need in one place.
    </p>

    <div class="owner-line">
      <span class="owner-avatar">AF</span>
      <span>
        <strong>Al Francis Balangiao</strong>
        <small>Cagayan de Oro City, Philippines</small>
      </span>
    </div>
  </div>

  <div class="about-quote">
    <span class="quote-mark">“</span>

    <p>I chose auto parts because I enjoy learning about cars, engines, and the parts that keep vehicles running.</p>

    <p>My second topic option was Tech Web, but auto parts felt more connected to my everyday interests.</p>

    <p>I am proud of this topic because it lets me explore how vehicles work and share useful information with other enthusiasts.</p>
  </div>
</section>


<section class="bottom-banner">
  <span class="bottom-mark">AP<span>.</span></span>
  <p>QUALITY PARTS <i>/</i> BETTER PERFORMANCE <i>/</i> EVERY ROAD</p>
  <a href="collection.php" aria-label="Browse collection">↗</a>
</section>
<?php require 'footer.php'; ?>
