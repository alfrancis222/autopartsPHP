<?php
session_start();

// ---- Database (XAMPP defaults) ----
$pdo = new PDO(
  'mysql:host=localhost;dbname=autoparts_site;charset=utf8mb4',
  'root', '',
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

// ---- Edit this: your info for the dashboard ----
$owner = [
  'name'    => 'Your Name',
  'address' => 'Cagayan de Oro City, Philippines',
  'why'     => 'I chose auto parts because I enjoy learning about cars, engines, and the parts that keep vehicles running.',
  'second'  => 'My second topic option was another interest, but auto parts felt more connected to my everyday interests.',
  'proud'   => 'I am proud of this topic because it lets me explore how vehicles work and share useful information with other enthusiasts.',
];

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function flash($msg) { $_SESSION['flash'] = $msg; }
function peso($n) { return '₱' . number_format((float)$n, 2); }

function save_image(array $f, ?string &$err): ?string {
  if (($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
  if ($f['error'] !== UPLOAD_ERR_OK) { $err = 'Upload failed. Try again.'; return null; }
  if ($f['size'] > 2 * 1024 * 1024) { $err = 'Picture must be 2 MB or smaller.'; return null; }
  $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
  $ext = $types[mime_content_type($f['tmp_name'])] ?? null;
  if (!$ext) { $err = 'Picture must be a JPG, PNG, or WEBP file.'; return null; }
  $name = bin2hex(random_bytes(8)) . '.' . $ext;
  if (!move_uploaded_file($f['tmp_name'], __DIR__ . '/uploads/' . $name)) { $err = 'Could not save the picture.'; return null; }
  return $name;
}

function remove_image(?string $file): void {
  if ($file && is_file(__DIR__ . '/uploads/' . $file)) unlink(__DIR__ . '/uploads/' . $file);
}

// Returns list of error messages. Name check is case-sensitive (BINARY).
function validate_part(PDO $pdo, array $p, ?int $ignoreId = null): array {
  $errors = [];
  $len = fn($s) => mb_strlen($s);
  if ($p['name'] === '') $errors[] = 'Name is required.';
  elseif ($len($p['name']) > 100) $errors[] = 'Name must be 100 characters or fewer.';
  if ($len($p['description']) > 255) $errors[] = 'Description must be 255 characters or fewer.';
  if ($p['price'] === '' || !is_numeric($p['price']) || $p['price'] < 0) $errors[] = 'Enter a valid price (0 or higher).';
  $st = $pdo->prepare('SELECT COUNT(*) FROM subtopics WHERE id = ?');
  $st->execute([$p['subtopic_id']]);
  if (!$st->fetchColumn()) $errors[] = 'Pick a subtopic.';
  if (!$errors) {
    $q = $pdo->prepare('SELECT COUNT(*) FROM parts WHERE BINARY name = ? AND is_deleted = 0 AND id <> ?');
    $q->execute([$p['name'], $ignoreId ?? 0]);
    if ($q->fetchColumn()) $errors[] = 'A part with this exact name already exists.';
  }
  return $errors;
}

function post_part(): array {
  return [
    'name'        => trim($_POST['name'] ?? ''),
    'description' => trim($_POST['description'] ?? ''),
    'price'       => trim($_POST['price'] ?? ''),
    'subtopic_id' => (int)($_POST['subtopic_id'] ?? 0),
  ];
}
 
