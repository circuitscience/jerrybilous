<?php
session_start();

$admin_user = 'admin';
$admin_pass = '!JB263e11';
$notes_file = __DIR__ . '/assets/latest_notes.json';
$gallery_dir = __DIR__ . '/assets/images/gallery';
$gallery_meta_file = $gallery_dir . '/gallery_meta.json';
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
$error = null;
$message = null;

function admin_default_caption(string $file): string
{
    $caption = pathinfo($file, PATHINFO_FILENAME);
    $caption = str_replace(['-', '_'], ' ', $caption);
    $caption = preg_replace('/\s+/', ' ', $caption);

    return ucwords(trim($caption));
}

function read_json_file(string $file, array $fallback = []): array
{
    if (!is_file($file)) {
        return $fallback;
    }

    $decoded = json_decode((string) file_get_contents($file), true);
    return is_array($decoded) ? $decoded : $fallback;
}

function write_json_file(string $file, array $data): void
{
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (($_POST['username'] ?? '') === $admin_user && ($_POST['password'] ?? '') === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    }

    $error = 'Invalid login.';
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

$logged_in = !empty($_SESSION['admin_logged_in']);
$notes = read_json_file($notes_file);
$gallery_meta = read_json_file($gallery_meta_file);
$gallery_images = [];

if (is_dir($gallery_dir)) {
    foreach (scandir($gallery_dir) as $file) {
        $path = $gallery_dir . DIRECTORY_SEPARATOR . $file;
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (is_file($path) && in_array($extension, $allowed_extensions, true)) {
            $gallery_images[] = $file;
            $gallery_meta[$file]['caption'] = $gallery_meta[$file]['caption'] ?? admin_default_caption($file);
            $gallery_meta[$file]['likes'] = (int) ($gallery_meta[$file]['likes'] ?? 0);
            $gallery_meta[$file]['dislikes'] = (int) ($gallery_meta[$file]['dislikes'] ?? 0);
        }
    }
}

natcasesort($gallery_images);
$gallery_images = array_values($gallery_images);

if ($logged_in && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['admin_action'] ?? '';

    if ($action === 'add_note') {
        $title = trim((string) ($_POST['title'] ?? ''));
        $body = trim((string) ($_POST['body'] ?? ''));
        $type = trim((string) ($_POST['type'] ?? 'site'));
        $date = trim((string) ($_POST['date'] ?? date('Y-m-d')));

        if ($title === '' || $body === '') {
            $error = 'Note title and body are required.';
        } else {
            array_unshift($notes, [
                'date' => $date !== '' ? $date : date('Y-m-d'),
                'type' => $type !== '' ? substr($type, 0, 40) : 'site',
                'title' => substr($title, 0, 120),
                'body' => substr($body, 0, 500),
            ]);
            $notes = array_slice($notes, 0, 25);
            write_json_file($notes_file, $notes);
            $message = 'Latest note saved.';
        }
    }

    if ($action === 'delete_note') {
        $index = (int) ($_POST['index'] ?? -1);
        if (isset($notes[$index])) {
            array_splice($notes, $index, 1);
            write_json_file($notes_file, $notes);
            $message = 'Note deleted.';
        }
    }

    if ($action === 'save_captions') {
        foreach (($_POST['captions'] ?? []) as $file => $caption) {
            if (in_array($file, $gallery_images, true)) {
                $caption = trim((string) $caption);
                $gallery_meta[$file]['caption'] = $caption !== '' ? substr($caption, 0, 140) : admin_default_caption($file);
            }
        }

        if (is_dir($gallery_dir)) {
            write_json_file($gallery_meta_file, $gallery_meta);
            $message = 'Gallery captions saved.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Console | Jerry Bilous</title>
    <link rel="stylesheet" href="styles.css?v=24" />
  </head>
  <body>
    <nav class="nav-bar">
      <div class="nav-container">
        <a href="index.php#hero" class="nav-logo">Back</a>
        <ul class="nav-links">
          <?php if ($logged_in): ?>
            <li><a href="admin.php?logout=1">Logout</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>

    <main class="page-shell admin-shell">
      <section class="panel admin-panel">
        <h2>Admin Console</h2>
        <?php if ($error): ?><p class="form-message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
        <?php if ($message): ?><p class="form-message success"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>

        <?php if (!$logged_in): ?>
          <form method="post" class="admin-form">
            <input type="hidden" name="login" value="1">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="cta-button">Login</button>
          </form>
        <?php else: ?>
          <div class="admin-grid">
            <section class="admin-tool">
              <h3>Add Latest Note</h3>
              <form method="post" class="admin-form">
                <input type="hidden" name="admin_action" value="add_note">
                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                <input type="text" name="type" placeholder="Type: site, photos, news">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="body" placeholder="Update note" required></textarea>
                <button type="submit" class="cta-button">Save Note</button>
              </form>
            </section>

            <section class="admin-tool">
              <h3>Existing Notes</h3>
              <div class="admin-note-list">
                <?php foreach ($notes as $index => $note): ?>
                  <article>
                    <strong><?php echo htmlspecialchars($note['title'] ?? 'Untitled', ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span><?php echo htmlspecialchars(($note['date'] ?? '') . ' · ' . ($note['type'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
                    <p><?php echo htmlspecialchars($note['body'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <form method="post">
                      <input type="hidden" name="admin_action" value="delete_note">
                      <input type="hidden" name="index" value="<?php echo $index; ?>">
                      <button type="submit">Delete</button>
                    </form>
                  </article>
                <?php endforeach; ?>
              </div>
            </section>
          </div>

          <section class="admin-tool">
            <h3>Gallery Captions</h3>
            <form method="post" class="admin-caption-form">
              <input type="hidden" name="admin_action" value="save_captions">
              <?php foreach ($gallery_images as $image): ?>
                <label>
                  <span><?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?></span>
                  <input type="text" name="captions[<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>]" value="<?php echo htmlspecialchars($gallery_meta[$image]['caption'] ?? admin_default_caption($image), ENT_QUOTES, 'UTF-8'); ?>">
                </label>
              <?php endforeach; ?>
              <button type="submit" class="cta-button">Save Captions</button>
            </form>
          </section>
        <?php endif; ?>
      </section>
    </main>
  </body>
</html>
