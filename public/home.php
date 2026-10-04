<?php
if (!isset($days_remaining, $latest_notes, $has_forsale_items)) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Jerry Bilous builds practical systems for stronger bodies, better businesses, and a deliberate life—from electrical services to software and longevity training." />
    <meta name="keywords" content="Jerry Bilous, Gray Mentality, RX154, CSi Services, Hamilton, software development, longevity, strength training" />
    <meta property="og:title" content="Jerry Bilous | Practical systems for work and life" />
    <meta property="og:description" content="Contractor, software builder, and longevity advocate based in Hamilton, Canada." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://jerrybilous.ca/og.png" />
    <meta property="og:image:width" content="1792" />
    <meta property="og:image:height" content="936" />
    <meta property="og:image:alt" content="Jerry Bilous — Practical systems for work and life." />
    <meta property="og:url" content="https://jerrybilous.ca" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Jerry Bilous | Practical systems for work and life" />
    <meta name="twitter:description" content="Contractor, software builder, and longevity advocate based in Hamilton, Canada." />
    <meta name="twitter:image" content="https://jerrybilous.ca/og.png" />
    <meta name="theme-color" content="#111114" />
    <title>Jerry Bilous | Practical systems for work and life</title>
    <link rel="icon" type="image/png" sizes="64x64" href="favicon.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    <link rel="stylesheet" href="styles.css?v=30" />
  </head>
  <body class="home-page">
    <a class="skip-link" href="#main-content">Skip to content</a>
    <header class="home-header" data-home-header>
      <div class="home-nav-wrap">
        <a href="#top" class="home-brand" aria-label="Jerry Bilous home">
          <span class="home-brand-mark" aria-hidden="true"><img src="assets/images/jb-mark-512.png" alt="" width="512" height="512" /></span>
          <span><strong>Jerry Bilous</strong><small>Hamilton, Canada</small></span>
        </a>
        <button class="home-menu-button" type="button" aria-expanded="false" aria-controls="home-nav-links">
          <span class="sr-only">Toggle navigation</span>
          <span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span>
        </button>
        <nav class="home-nav" aria-label="Primary navigation">
          <ul id="home-nav-links">
            <li><a href="#work">Work</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#about">About</a></li>
            <?php if ($latest_notes): ?><li><a href="#notes">Notes</a></li><?php endif; ?>
            <li><a class="home-nav-contact" href="#contact">Contact</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main id="main-content" class="home-shell">
      <section id="top" class="home-hero">
        <div class="home-hero-copy">
          <p class="home-kicker"><span></span> Contractor · Software builder · Longevity advocate</p>
          <h1>Practical systems for <em>stronger bodies,</em> better businesses, and a deliberate life.</h1>
          <p class="home-hero-lead">
            I’m Jerry Bilous—a Hamilton-based builder who brings the same discipline to electrical work, software, strength training, and everything worth doing well.
          </p>
          <div class="home-actions">
            <a class="home-button home-button-primary" href="#work">Explore my work <span aria-hidden="true">→</span></a>
            <a class="home-button home-button-secondary" href="mailto:mail@jerrybilous.ca">Email Jerry</a>
          </div>
          <ul class="home-proof-line" aria-label="Areas of experience">
            <li>Hands-on experience</li>
            <li>Working software</li>
            <li>Built for the long term</li>
          </ul>
        </div>
        <div class="home-portrait-wrap">
          <div class="home-portrait-glow" aria-hidden="true"></div>
          <figure class="home-portrait">
            <img src="assets/images/jbsgl.jpg" alt="Jerry Bilous" width="551" height="748" fetchpriority="high" />
            <figcaption>
              <span>My operating principle</span>
              <strong>Systems beat motivation.</strong>
            </figcaption>
          </figure>
          <div class="home-life-chip">
            <strong><?php echo number_format($days_remaining); ?></strong>
            <span>days to 100.<br />Make them count.</span>
          </div>
        </div>
      </section>

      <section id="work" class="home-section home-work">
        <div class="home-section-intro">
          <p class="home-kicker">What I build</p>
          <h2>Three disciplines. One practical mindset.</h2>
          <p>I’m interested in work that solves a real problem, holds up under pressure, and helps people keep moving forward.</p>
        </div>
        <div class="home-work-grid">
          <article class="home-work-card">
            <div class="home-card-topline">
              <span class="home-card-number">01</span>
              <img src="assets/images/unnamed.png" alt="" width="56" height="56" />
            </div>
            <p class="home-card-label">Electrical &amp; property services</p>
            <h3>CSi Services</h3>
            <p>Dependable electrical maintenance, troubleshooting, upgrades, consulting, and practical repair support for homes, businesses, and facilities.</p>
            <a href="https://circuitscience.ca" target="_blank" rel="noopener noreferrer">Visit CSi Services <span aria-hidden="true">↗</span></a>
          </article>
          <article class="home-work-card home-work-card-featured">
            <div class="home-card-topline">
              <span class="home-card-number">02</span>
              <img src="assets/images/ChatGPTimg-GMlogo.png" alt="" width="56" height="56" />
            </div>
            <p class="home-card-label">Strength &amp; longevity</p>
            <h3>Gray Mentality</h3>
            <p>A philosophy and growing collection of tools for people who choose strength, curiosity, purpose, and participation over passive aging.</p>
            <a href="https://graymentality.ca" target="_blank" rel="noopener noreferrer">Explore Gray Mentality <span aria-hidden="true">↗</span></a>
          </article>
          <article class="home-work-card">
            <div class="home-card-topline">
              <span class="home-card-number">03</span>
              <span class="home-code-mark" aria-hidden="true">&lt;/&gt;</span>
            </div>
            <p class="home-card-label">Software systems</p>
            <h3>Practical development</h3>
            <p>PHP, MySQL, Docker, automation, and legacy-system repair for small businesses and independent builders who need useful software.</p>
            <a href="freelance.php">View software services <span aria-hidden="true">→</span></a>
          </article>
          <article class="home-work-card">
            <div class="home-card-topline">
              <span class="home-card-number">04</span>
              <span class="home-golf-mark" aria-hidden="true"><i></i></span>
            </div>
            <p class="home-card-label">Practice &amp; performance</p>
            <h3>The pursuit of par</h3>
            <p>Golf notes, practice ideas, swing work, course management, and the patient pursuit of better decisions—one shot at a time.</p>
            <a href="https://golf.jerrybilous.ca">Explore my golf work <span aria-hidden="true">→</span></a>
          </article>
        </div>
      </section>

      <section id="projects" class="home-section home-feature">
        <div class="home-feature-visual">
          <div class="home-feature-orbit" aria-hidden="true"></div>
          <img src="assets/images/ChatGPTimg-xfit.png" alt="RX154 strength and longevity platform" width="1024" height="1024" loading="lazy" />
          <span class="home-feature-tag home-feature-tag-one">Plan</span>
          <span class="home-feature-tag home-feature-tag-two">Track</span>
          <span class="home-feature-tag home-feature-tag-three">Adapt</span>
        </div>
        <div class="home-feature-copy">
          <p class="home-kicker">Featured project</p>
          <h2>RX154 turns consistency into a system.</h2>
          <p class="home-feature-lead">A compliance-based strength and longevity platform designed to help people keep showing up, recording the work, recovering properly, and earning progress.</p>
          <ul class="home-feature-list">
            <li><strong>Structured training</strong><span>Planned sessions, exercises, recovery, and progression.</span></li>
            <li><strong>Accountability</strong><span>Completion tracking, reminders, and honest feedback.</span></li>
            <li><strong>Real infrastructure</strong><span>Registration, onboarding, automation, email queues, and administrative workflows.</span></li>
          </ul>
          <a class="home-text-link" href="https://rx154.graymentality.ca" target="_blank" rel="noopener noreferrer">Explore RX154 <span aria-hidden="true">↗</span></a>
        </div>
      </section>

      <section id="about" class="home-section home-about">
        <div class="home-about-statement">
          <p class="home-kicker">The philosophy</p>
          <blockquote>“Do not wait for motivation. Build the system, do the work, and keep adapting.”</blockquote>
        </div>
        <div class="home-about-copy">
          <h2>Still learning. Still building. Still under load.</h2>
          <p>I’m a semi-retired electrical contractor, husband, father, grandfather, musician, golfer, and independent software builder. The subjects change, but the approach does not: understand the problem, create a repeatable process, and improve it through honest work.</p>
          <p>Gray Mentality puts that belief into words: aging is inevitable, but passive decline is not. Stay useful. Stay curious. Keep placing intelligent demands on the body and mind.</p>
          <div class="home-about-links">
            <a href="gallery.php">Family gallery</a>
            <a href="music.php">Music</a>
            <a href="https://www.linkedin.com/in/jerry-bilous-me-9120b533" target="_blank" rel="noopener noreferrer">LinkedIn <span aria-hidden="true">↗</span></a>
          </div>
        </div>
      </section>

      <?php if ($latest_notes): ?>
        <section id="notes" class="home-section home-notes">
          <div class="home-section-intro home-section-intro-row">
            <div>
              <p class="home-kicker">From the workbench</p>
              <h2>Latest notes</h2>
            </div>
            <p>Short updates from the projects, training, and ideas I’m working through.</p>
          </div>
          <div class="home-notes-grid">
            <?php foreach ($latest_notes as $note): ?>
              <article>
                <span><?php echo htmlspecialchars(($note['date'] ?? '') . ' · ' . ($note['type'] ?? 'update')); ?></span>
                <h3><?php echo htmlspecialchars($note['title'] ?? 'Update'); ?></h3>
                <p><?php echo htmlspecialchars($note['body'] ?? ''); ?></p>
              </article>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endif; ?>

      <section id="contact" class="home-section home-contact">
        <div class="home-contact-copy">
          <p class="home-kicker">Start a conversation</p>
          <h2>Have a practical problem worth solving?</h2>
          <p>Tell me what you’re working on. Whether it involves a property, a piece of software, or a system that needs structure, plain language is a good place to start.</p>
          <a class="home-button home-button-primary" href="mailto:mail@jerrybilous.ca?subject=Let%27s%20talk">mail@jerrybilous.ca <span aria-hidden="true">→</span></a>
        </div>
        <div id="subscribe" class="home-subscribe">
          <p class="home-card-label">Occasional updates</p>
          <h3>Follow what I’m building.</h3>
          <p>New projects, site notes, photos, and news—sent only when there is something worth sharing.</p>
          <?php if ($subscribe_message): ?>
            <p class="home-form-message success"><?php echo htmlspecialchars($subscribe_message); ?></p>
          <?php endif; ?>
          <?php if ($subscribe_error): ?>
            <p class="home-form-message error"><?php echo htmlspecialchars($subscribe_error); ?></p>
          <?php endif; ?>
          <form method="post" class="home-subscribe-form">
            <input type="hidden" name="subscribe" value="1" />
            <input type="hidden" name="topics[]" value="page_content" />
            <input type="hidden" name="topics[]" value="photos" />
            <input type="hidden" name="topics[]" value="news" />
            <label for="subscriber-name">Name <span>(optional)</span></label>
            <input id="subscriber-name" type="text" name="subscriber_name" autocomplete="name" />
            <label for="subscriber-email">Email</label>
            <div class="home-email-row">
              <input id="subscriber-email" type="email" name="subscriber_email" autocomplete="email" required />
              <button type="submit">Subscribe</button>
            </div>
          </form>
        </div>
      </section>
    </main>

    <footer class="home-footer">
      <div>
        <a href="#top" class="home-footer-brand"><img src="assets/images/jb-mark-512.png" alt="" width="512" height="512" /><span>Jerry Bilous</span></a>
        <p>Hamilton, Canada · Building practical systems since 1959.</p>
      </div>
      <nav aria-label="Footer navigation">
        <a href="music.php">Music</a>
        <a href="gallery.php">Family gallery</a>
        <?php if ($has_forsale_items): ?><a href="forsale.php">For sale</a><?php endif; ?>
        <a href="https://github.com/circuitscience/jerrybilous" target="_blank" rel="noopener noreferrer">GitHub</a>
        <a href="https://www.facebook.com/jerry.bilous.3" target="_blank" rel="noopener noreferrer">Facebook</a>
      </nav>
    </footer>

    <script>
      const menuButton = document.querySelector('.home-menu-button');
      const homeNav = document.querySelector('.home-nav');

      if (menuButton && homeNav) {
        menuButton.addEventListener('click', () => {
          const isOpen = homeNav.classList.toggle('is-open');
          menuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        homeNav.querySelectorAll('a').forEach((link) => {
          link.addEventListener('click', () => {
            homeNav.classList.remove('is-open');
            menuButton.setAttribute('aria-expanded', 'false');
          });
        });
      }
    </script>
  </body>
</html>
