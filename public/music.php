<?php
$config_file = __DIR__ . '/assets/music_config.json';
$uploads_dir = __DIR__ . '/assets/music/uploads';
$uploads_url = 'assets/music/uploads';
$allowed_extensions = ['mp3', 'm4a', 'wav', 'ogg', 'flac'];
$config = [
    'playlist_embed_url' => '',
    'playlist_title' => "What I'm Listening To Lately",
];
$tracks = [];
$playlist_url = '';
$playlist_embed_url = '';

function build_playlist_embed_url(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }

    $parts = parse_url($url);
    if (!$parts || empty($parts['host'])) {
        return $url;
    }

    $host = strtolower($parts['host']);
    $query = [];
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
    }

    if (str_contains($host, 'youtube.com') || str_contains($host, 'music.youtube.com') || str_contains($host, 'youtu.be')) {
        if (!empty($query['list'])) {
            return 'https://www.youtube.com/embed/videoseries?list=' . rawurlencode($query['list']);
        }

        if (!empty($parts['path']) && preg_match('~/embed/(.+)$~', $parts['path'])) {
            return $url;
        }
    }

    return $url;
}

if (is_file($config_file)) {
    $decoded = json_decode((string) file_get_contents($config_file), true);
    if (is_array($decoded)) {
        $config = array_merge($config, $decoded);
    }
}

if (is_dir($uploads_dir)) {
    foreach (scandir($uploads_dir) as $file) {
        $path = $uploads_dir . DIRECTORY_SEPARATOR . $file;
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (is_file($path) && in_array($extension, $allowed_extensions, true)) {
            $title = pathinfo($file, PATHINFO_FILENAME);
            $title = ucwords(trim(preg_replace('/\s+/', ' ', str_replace(['-', '_'], ' ', $title))));
            $tracks[] = [
                'title' => $title,
                'src' => $uploads_url . '/' . rawurlencode($file),
            ];
        }
    }
}

$playlist_url = trim((string) ($config['playlist_embed_url'] ?? ''));
$playlist_embed_url = build_playlist_embed_url($playlist_url);
usort($tracks, static fn($a, $b) => strnatcasecmp($a['title'], $b['title']));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Music by Jerry Bilous: guitar, keyboards, original songs, Reason Studios DAW, heavy metal, classical, and opera influences." />
    <title>Music | Just Jerry Bilous</title>
    <link rel="stylesheet" href="styles.css?v=27" />
  </head>
  <body>
    <nav class="nav-bar">
      <div class="nav-container">
        <a href="index.php#hero" class="nav-logo">Back</a>
        <ul class="nav-links">
          <li><a href="index.php#contact">Contact</a></li>
          <li><a href="gallery.php">Gallery</a></li>
        </ul>
      </div>
    </nav>

    <main class="page-shell music-shell">
      <header class="music-header">
        <p class="eyebrow">Music</p>
        <h1>Guitar, keyboards, original music</h1>
        <p>I play guitar and keyboards, write original music with Reason Studios DAW, and draw from heavy metal, classical music, and opera.</p>
      </header>

      <section class="music-layout">
        <div id="listening-lately" class="panel music-panel">
          <h2><?php echo htmlspecialchars($config['playlist_title'], ENT_QUOTES, 'UTF-8'); ?></h2>
          <?php if ($playlist_embed_url !== ''): ?>
            <div class="music-embed">
              <iframe src="<?php echo htmlspecialchars($playlist_embed_url, ENT_QUOTES, 'UTF-8'); ?>" title="<?php echo htmlspecialchars($config['playlist_title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
            </div>
            <?php if ($playlist_url !== ''): ?>
              <a class="music-direct-link" href="<?php echo htmlspecialchars($playlist_url, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">Open playlist</a>
            <?php endif; ?>
          <?php else: ?>
            <div class="music-empty">
              <p>Add a playlist embed URL in <code>public/assets/music_config.json</code>.</p>
            </div>
          <?php endif; ?>
        </div>

        <div class="panel music-panel">
          <h2>My Uploads</h2>
          <?php if ($tracks): ?>
            <div class="music-track-list">
              <?php foreach ($tracks as $track): ?>
                <article class="music-track">
                  <h3><?php echo htmlspecialchars($track['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                  <audio controls preload="none" src="<?php echo htmlspecialchars($track['src'], ENT_QUOTES, 'UTF-8'); ?>"></audio>
                </article>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="music-empty">
              <p>Add audio files to <code>public/assets/music/uploads/</code>.</p>
            </div>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </body>
</html>
