<?php
$gallery_dir = __DIR__ . '/assets/images/gallery';
$gallery_url = 'assets/images/gallery';
$meta_file = $gallery_dir . '/gallery_meta.json';
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
$images = [];

if (is_dir($gallery_dir)) {
    foreach (scandir($gallery_dir) as $file) {
        $path = $gallery_dir . DIRECTORY_SEPARATOR . $file;
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (is_file($path) && in_array($extension, $allowed_extensions, true)) {
            $images[] = $file;
        }
    }
}

function gallery_default_caption(string $file): string
{
    $caption = pathinfo($file, PATHINFO_FILENAME);
    $caption = str_replace(['-', '_'], ' ', $caption);
    $caption = preg_replace('/\s+/', ' ', $caption);

    return ucwords(trim($caption));
}

$meta = [];
if (is_file($meta_file)) {
    $stored_meta = json_decode((string) file_get_contents($meta_file), true);
    if (is_array($stored_meta)) {
        $meta = $stored_meta;
    }
}

foreach ($images as $image) {
    if (!isset($meta[$image]) || !is_array($meta[$image])) {
        $meta[$image] = [];
    }

    $meta[$image]['caption'] = $meta[$image]['caption'] ?? gallery_default_caption($image);
    $meta[$image]['likes'] = (int) ($meta[$image]['likes'] ?? 0);
    $meta[$image]['dislikes'] = (int) ($meta[$image]['dislikes'] ?? 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_POST['image'] ?? '';
    $action = $_POST['gallery_action'] ?? '';

    if (in_array($image, $images, true)) {
        if ($action === 'like') {
            $meta[$image]['likes']++;
        } elseif ($action === 'dislike') {
            $meta[$image]['dislikes']++;
        }

        if (is_dir($gallery_dir)) {
            file_put_contents($meta_file, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
        }

        header('Location: gallery.php');
        exit;
    }
}

usort($images, function (string $a, string $b) use ($meta): int {
    $score_a = ($meta[$a]['likes'] ?? 0) - ($meta[$a]['dislikes'] ?? 0);
    $score_b = ($meta[$b]['likes'] ?? 0) - ($meta[$b]['dislikes'] ?? 0);

    if ($score_a === $score_b) {
        return strnatcasecmp($a, $b);
    }

    return $score_b <=> $score_a;
});

$photo_count = count($images);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Jerry Bilous family photo gallery." />
    <title>My Clan as of 2026 | Jerry Bilous</title>
    <link rel="stylesheet" href="styles.css?v=23" />
  </head>
  <body>
    <nav class="nav-bar">
      <div class="nav-container">
        <a href="index.php" class="nav-logo">Back</a>
        <ul class="nav-links">
          <li><a href="index.php#contact">Contact</a></li>
          <li><a href="index.php#hero">Home</a></li>
        </ul>
      </div>
    </nav>

    <main class="page-shell gallery-shell">
      <header class="gallery-header">
        <p class="eyebrow">Family Gallery</p>
        <h1>my clan as of 2026</h1>
        <p class="gallery-count"><?php echo $photo_count; ?> photos, sorted by popularity</p>
      </header>

      <?php if ($images): ?>
        <?php
          $first_image = $images[0];
          $first_src = $gallery_url . '/' . rawurlencode($first_image);
          $first_caption = $meta[$first_image]['caption'];
          $first_likes = $meta[$first_image]['likes'];
          $first_dislikes = $meta[$first_image]['dislikes'];
        ?>
        <section class="gallery-layout" aria-label="Family photo gallery">
          <div class="gallery-grid" id="gallery">
            <?php foreach ($images as $index => $image): ?>
              <?php
                $src = $gallery_url . '/' . rawurlencode($image);
                $caption = $meta[$image]['caption'];
                $likes = $meta[$image]['likes'];
                $dislikes = $meta[$image]['dislikes'];
                $score = $likes - $dislikes;
              ?>
              <button
                class="gallery-item<?php echo $index === 0 ? ' is-active' : ''; ?>"
                type="button"
                data-gallery-src="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>"
                data-gallery-caption="<?php echo htmlspecialchars($caption, ENT_QUOTES, 'UTF-8'); ?>"
                data-gallery-image="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>"
                data-gallery-likes="<?php echo $likes; ?>"
                data-gallery-dislikes="<?php echo $dislikes; ?>"
              >
                <img src="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($caption, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" />
                <span><?php echo $score; ?></span>
              </button>
            <?php endforeach; ?>
          </div>

          <aside class="gallery-preview" aria-live="polite">
            <div class="gallery-preview-bg" id="gallery-preview-bg" style="background-image: url('<?php echo htmlspecialchars($first_src, ENT_QUOTES, 'UTF-8'); ?>');"></div>
            <div class="gallery-preview-inner">
              <img id="gallery-preview-image" src="<?php echo htmlspecialchars($first_src, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($first_caption, ENT_QUOTES, 'UTF-8'); ?>" />
              <div class="gallery-preview-details">
                <h2 id="gallery-preview-caption"><?php echo htmlspecialchars($first_caption, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p>
                  <span id="gallery-like-count"><?php echo $first_likes; ?></span> likes ·
                  <span id="gallery-dislike-count"><?php echo $first_dislikes; ?></span> dislikes
                </p>
                <div class="gallery-preview-actions">
                  <form method="post">
                    <input id="gallery-like-image" type="hidden" name="image" value="<?php echo htmlspecialchars($first_image, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="gallery_action" value="like">
                    <button type="submit">Like</button>
                  </form>
                  <form method="post">
                    <input id="gallery-dislike-image" type="hidden" name="image" value="<?php echo htmlspecialchars($first_image, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="gallery_action" value="dislike">
                    <button type="submit">Dislike</button>
                  </form>
                </div>
                <div class="gallery-nav-buttons">
                  <button id="gallery-prev" type="button">Previous</button>
                  <button id="gallery-next" type="button">Next</button>
                </div>
              </div>
            </div>
          </aside>
        </section>
      <?php else: ?>
        <section class="panel gallery-empty" id="gallery">
          <h2>No gallery images yet</h2>
          <p>Add images to <code>public/assets/images/gallery/</code> and this page will load them automatically.</p>
        </section>
      <?php endif; ?>
    </main>

    <script>
      const galleryButtons = document.querySelectorAll('.gallery-item');
      const galleryPreviewImage = document.getElementById('gallery-preview-image');
      const galleryPreviewBg = document.getElementById('gallery-preview-bg');
      const galleryPreviewCaption = document.getElementById('gallery-preview-caption');
      const galleryLikeCount = document.getElementById('gallery-like-count');
      const galleryDislikeCount = document.getElementById('gallery-dislike-count');
      const galleryLikeImage = document.getElementById('gallery-like-image');
      const galleryDislikeImage = document.getElementById('gallery-dislike-image');
      const galleryPrev = document.getElementById('gallery-prev');
      const galleryNext = document.getElementById('gallery-next');
      let activeGalleryIndex = 0;

      function selectGalleryImage(index) {
        const button = galleryButtons[index];
        if (!button) {
          return;
        }

        activeGalleryIndex = index;
        galleryButtons.forEach((item) => item.classList.remove('is-active'));
        button.classList.add('is-active');
        galleryPreviewImage.src = button.dataset.gallerySrc;
        galleryPreviewImage.alt = button.dataset.galleryCaption;
        galleryPreviewBg.style.backgroundImage = `url('${button.dataset.gallerySrc}')`;
        galleryPreviewCaption.textContent = button.dataset.galleryCaption;
        galleryLikeCount.textContent = button.dataset.galleryLikes;
        galleryDislikeCount.textContent = button.dataset.galleryDislikes;
        galleryLikeImage.value = button.dataset.galleryImage;
        galleryDislikeImage.value = button.dataset.galleryImage;
      }

      galleryButtons.forEach((button, index) => {
        button.addEventListener('click', () => selectGalleryImage(index));
      });

      if (galleryPrev && galleryNext) {
        galleryPrev.addEventListener('click', () => {
          const nextIndex = activeGalleryIndex === 0 ? galleryButtons.length - 1 : activeGalleryIndex - 1;
          selectGalleryImage(nextIndex);
        });

        galleryNext.addEventListener('click', () => {
          const nextIndex = activeGalleryIndex === galleryButtons.length - 1 ? 0 : activeGalleryIndex + 1;
          selectGalleryImage(nextIndex);
        });

        document.addEventListener('keydown', (event) => {
          if (event.key === 'ArrowLeft') {
            galleryPrev.click();
          }
          if (event.key === 'ArrowRight') {
            galleryNext.click();
          }
        });
      }
    </script>
  </body>
</html>
