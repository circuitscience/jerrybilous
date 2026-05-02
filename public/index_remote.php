<?php
$db = null;
$testimonial = null;
$guestbook_entries = [];
$guestbook_error = null;
$recent_visitors = [];
$subscribe_message = isset($_GET['subscribed']) ? 'You are subscribed. I will use this list for page content, photo, and news updates.' : null;
$subscribe_error = null;

try {
    $db_host = 'localhost';
    $db_name = 'jerrybil_jb';
    $db_user = 'jerrybil_jb';
    $db_pass = '!JB263e11';

    $db = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    $db->exec("CREATE TABLE IF NOT EXISTS subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL UNIQUE,
        name VARCHAR(100),
        topics VARCHAR(255) NOT NULL DEFAULT 'page_content,photos,news',
        status ENUM('active','unsubscribed') NOT NULL DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guestbook'])) {
        $name = trim($_POST['name'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name !== '' && $message !== '') {
            $stmt = $db->prepare("INSERT INTO guestbook (name, message) VALUES (?, ?)");
            $stmt->execute([$name, $message]);

            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '#guestbook');
            exit;
        }

        $guestbook_error = 'Please enter your name and message.';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe'])) {
        $subscriber_name = trim($_POST['subscriber_name'] ?? '');
        $subscriber_email = filter_var(trim($_POST['subscriber_email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $allowed_topics = ['page_content', 'photos', 'news'];
        $selected_topics = array_values(array_intersect((array) ($_POST['topics'] ?? []), $allowed_topics));

        if (!$subscriber_email) {
            $subscribe_error = 'Please enter a valid email address.';
        } elseif (!$selected_topics) {
            $subscribe_error = 'Choose at least one update type.';
        } else {
            $topics = implode(',', $selected_topics);
            $stmt = $db->prepare("
                INSERT INTO subscribers (email, name, topics, status)
                VALUES (?, ?, ?, 'active')
                ON DUPLICATE KEY UPDATE
                    name = VALUES(name),
                    topics = VALUES(topics),
                    status = 'active'
            ");
            $stmt->execute([$subscriber_email, $subscriber_name, $topics]);

            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?subscribed=1#subscribe');
            exit;
        }
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $country = 'Unknown';
    $city = 'Unknown';

    $geo_context = stream_context_create([
        'http' => [
            'timeout' => 2,
            'user_agent' => 'jerrybilous.ca visitor logger',
        ],
    ]);
    $geo_response = @file_get_contents("https://ipapi.co/{$ip}/json/", false, $geo_context);

    if ($geo_response !== false) {
        $geo = json_decode($geo_response, true);
        if (is_array($geo)) {
            $country = $geo['country_name'] ?? 'Unknown';
            $city = $geo['city'] ?? 'Unknown';
        }
    }

    $stmt = $db->prepare("INSERT INTO visitors (ip, country, city) VALUES (?, ?, ?)");
    $stmt->execute([$ip, $country, $city]);

    $stmt = $db->query("SELECT text, author FROM testimonials ORDER BY RAND() LIMIT 1");
    $testimonial = $stmt->fetch();

    $guestbook_entries = $db
        ->query("SELECT name, message, timestamp FROM guestbook ORDER BY timestamp DESC LIMIT 10")
        ->fetchAll();

    $recent_visitors = $db
        ->query("SELECT city, country, MAX(timestamp) AS timestamp FROM visitors GROUP BY city, country ORDER BY timestamp DESC LIMIT 5")
        ->fetchAll();
} catch (PDOException $e) {
    error_log('Remote database error: ' . $e->getMessage());
}

$life_timezone = new DateTimeZone('America/Toronto');
$birth_date = new DateTimeImmutable('1959-07-03', $life_timezone);
$today = new DateTimeImmutable('today', $life_timezone);
$minimum_target_date = $birth_date->modify('+100 years');
$days_lived = $birth_date->diff($today)->days;
$target_days = $birth_date->diff($minimum_target_date)->days;
$days_remaining = max(0, $today->diff($minimum_target_date)->invert ? 0 : $today->diff($minimum_target_date)->days);
$target_date_iso = $minimum_target_date->format('Y-m-d') . 'T00:00:00-04:00';
$latest_notes_file = __DIR__ . '/assets/latest_notes.json';
$latest_notes = [];
if (is_file($latest_notes_file)) {
    $decoded_notes = json_decode((string) file_get_contents($latest_notes_file), true);
    if (is_array($decoded_notes)) {
        $latest_notes = array_slice($decoded_notes, 0, 3);
    }
}
$forsale_items_file = __DIR__ . '/assets/forsale_items.json';
$has_forsale_items = false;
if (is_file($forsale_items_file)) {
    $forsale_items = json_decode((string) file_get_contents($forsale_items_file), true);
    if (is_array($forsale_items)) {
        foreach ($forsale_items as $item) {
            if (is_array($item) && !empty($item['available']) && empty($item['sample'])) {
                $has_forsale_items = true;
                break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Jerry Bilous of Hamilton, Canada: Gray Mentality, exFIT, CSi Services, family gallery, golf, training, personal projects, and practical software systems." />
    <meta name="keywords" content="Jerry Bilous, Gray Mentality, exFIT, CSi Services, Hamilton, family gallery, golf, training, software, longevity" />
    <meta property="og:title" content="Just Jerry Bilous" />
    <meta property="og:description" content="The personal site of Jerry Bilous: family, training, golf, practical projects, and notes from Hamilton, Canada." />
    <meta property="og:image" content="https://jerrybilous.ca/public/assets/images/jbsgl.jpg" />
    <meta property="og:url" content="https://jerrybilous.ca" />
    <title>Just Jerry Bilous</title>
    <link rel="stylesheet" href="styles.css?v=24" />
  </head>
  <body>
    <nav class="nav-bar">
      <div class="nav-container">
        <a href="#hero" class="nav-logo">Jerry Bilous - Hamilton, Canada</a>
        <ul class="nav-links">
          <li><a href="#services">Services</a></li>
          <li><a href="#projects">Projects</a></li>
          <li><a href="#testimonials">Testimonials</a></li>
          <li><a href="#contact">Contact</a></li>
          <?php if ($has_forsale_items): ?><li><a href="forsale.php">For Sale</a></li><?php endif; ?>
          <li><a href="#subscribe">Subscribe</a></li>
          <li><a href="admin.php">Admin</a></li>
          <li><a href="#guestbook">Guestbook</a></li>
        </ul>
      </div>
    </nav>
    <main class="page-shell">
      <section id="hero" class="hero-section">
        <div class="hero-copy">
          <div class="hero-blurb">
            <video class="hero-flag-video" autoplay muted loop playsinline aria-hidden="true">
              <source src="assets/videos/canadian-flag.mp4" type="video/mp4">
            </video>
            <div class="hero-flag-fallback" aria-hidden="true"></div>
            <p class="eyebrow">Jerry Bilous</p>
            <h1>son, brother, father, husband, step father, grandfather, musician, golfer and friend... <small>since 1959</small></h1>
            <p class="hero-text">
              Building practical systems for work, training, family, golf, and living deliberately.
            </p>
          </div>
          <div class="life-counter">
            <div>
              <strong><?php echo number_format($days_lived); ?></strong>
              <span>days lived since July 3, 1959</span>
            </div>
            <div>
              <strong><?php echo number_format($target_days); ?></strong>
              <span>target birthday: 100 years old</span>
            </div>
            <div>
              <strong><?php echo number_format($days_remaining); ?></strong>
              <span>days to July 3, 2059</span>
            </div>
          </div>
          <div class="life-countdown" data-target="<?php echo htmlspecialchars($target_date_iso, ENT_QUOTES, 'UTF-8'); ?>">
            <span>Live countdown to 100</span>
            <strong>
              <span data-countdown-days><?php echo number_format($days_remaining); ?></span>d
              <span data-countdown-hours>00</span>h
              <span data-countdown-minutes>00</span>m
              <span data-countdown-seconds>00</span>s
            </strong>
          </div>
          <div class="hero-tags">
            <span class="brand-pill brand-graymentality">
              <img src="assets/images/ChatGPTimg-GMlogo.png" alt="GrayMentality logo" />
              GrayMentality
            </span>
            <span class="brand-pill brand-xfit">
              <img src="assets/images/ChatGPTimg-xfit.png" alt="xFit logo" />
              xFit Developer
            </span>
            <span>CSi Services</span>
            <span><a href="gallery.php">My Photo Gallery</a></span>
            <?php if ($has_forsale_items): ?><span><a href="forsale.php">For Sale</a></span><?php endif; ?>
            <span><a href="#subscribe">Subscribe for updates</a></span>
          </div>
          <div id="contact" class="hero-contact-panel">
            <h2>Ready to connect?</h2>
            <p>Let’s talk about how GrayMentality, xFit development, or CSi Services can help you reach the next level.</p>
            <div class="hero-contact-links">
              <a href="mailto:mail@jerrybilous.ca">Email Jerry</a>
              <a href="gallery.php">My Photo Gallery</a>
              <?php if ($has_forsale_items): ?><a href="forsale.php">For Sale</a><?php endif; ?>
              <a href="#subscribe">Subscribe for updates</a>
              <a href="https://linkedin.com/in/jerrybilous" target="_blank" rel="noopener noreferrer">LinkedIn</a>
              <a href="https://github.com/circuitscience/jerrybilous" target="_blank" rel="noopener noreferrer">GitHub</a>
            </div>
          </div>
        </div>
        <div class="hero-image">
          <img src="assets/images/jbsgl.jpg" alt="Jerry Bilous portrait" />
          <div class="recent-visitors-panel hero-visitors-panel">
            <h2>Recent Visitors</h2>
            <ul class="recent-visitors-list">
              <?php foreach ($recent_visitors as $visitor): ?>
                <li>
                  <span><?php echo htmlspecialchars($visitor['city'] ?: 'Unknown', ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($visitor['country'] ?: 'Unknown', ENT_QUOTES, 'UTF-8'); ?></span>
                  <small><?php echo htmlspecialchars($visitor['timestamp'], ENT_QUOTES, 'UTF-8'); ?></small>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </section>

      <section id="services" class="info-section">
        <div class="info-card">
          <h2>What I Do</h2>
          <p>
            I’m a semi-retired electrical contractor, fitness thinker, and builder of practical systems that help people live stronger, longer, and more deliberately. My work combines hands-on trade experience, personal training knowledge, software development, and a lifelong interest in discipline, health, and human performance.

I’m currently developing exFIT by Gray Mentality, a compliance-based strength and longevity platform designed especially for people who want structure, accountability, and sustainable progress. The idea is simple: strength is not built by hype or random effort. It is built by showing up, recording the work, recovering properly, and earning progression through consistency.

Alongside my fitness work, I build web and app-based tools using PHP, MySQL, Docker, Kotlin, and Android development. My projects focus on real-world usefulness: workout tracking, automated emails, user engagement systems, calculators, onboarding flows, and secure web applications.

At the core of what I do is a practical belief: systems beat motivation. Whether I’m wiring a building, designing a database, writing code, training in the gym, or working on golf swing mechanics, I’m interested in how structure, discipline, and repeated action create measurable results.
          </p>
        </div>

        <div class="grid-panel">
          <article>
            <div class="card-heading">
              <span class="card-logo-frame">
                <img class="card-logo card-logo-csi" src="assets/images/unnamed.png" alt="CSi Services logo" width="50" height="50" />
              </span>
              <h3>CSi Services</h3>
            </div>
            <p>CSi Services provides practical, dependable solutions across residential, institutional, and commercial environments. Our work includes electrical maintenance, repair, troubleshooting, upgrades, and consulting, supported by in-house services such as drywall repair, basic plumbing, and painting.

We bring hands-on electrical experience, technical problem-solving, and practical maintenance skills to every job. Whether supporting homeowners, businesses, property managers, facilities, or institutional clients, CSi Services focuses on doing the work properly, identifying issues before they become bigger problems, and helping clients make informed decisions about their buildings, systems, and operational needs.

From everyday repairs to ongoing maintenance planning, project consultation, and small in-house finishing work, CSi Services is built around quality workmanship, dependable service, and trusted client relationships.</p>
<a href="https://circuitscience.ca" target="_blank" rel="noopener noreferrer">Learn more about CSi Services</a>
<a href="mailto:jerry@circuitscience.ca" target="_blank" rel="noopener noreferrer">Contact CSi Services</a>
          </article>
          <article>
            <div class="card-heading">
              <span class="card-logo-frame">
                <img class="card-logo" src="assets/images/ChatGPTimg-GMlogo.png" alt="GrayMentality logo" width="50" height="50" />
              </span>
              <h3>GrayMentality</h3>
            </div>
            <p>Gray Mentality is a philosophy of living for older adults who refuse to surrender quietly to the aging process.

It is built on the belief that the mind and body should continue to be challenged, stimulated, trained, and forced to adapt for as long as life allows. Aging may be inevitable, but decline should not be accepted passively. Gray Mentality rejects the idea of simply growing older, slowing down, and waiting for the end.

Instead, it promotes a life of continued physical effort, mental engagement, learning, movement, discomfort, curiosity, and purpose.

Gray Mentality encourages older adults to keep placing demands on themselves through strength training, new skills, problem-solving, creative work, education, social engagement, and physical challenges. The goal is not to pretend we are young forever. The goal is to remain alive in the fullest sense: capable, engaged, useful, curious, resilient, and adaptive.

The offering behind Gray Mentality is built around helping older adults maintain and rebuild that adaptive capacity. Through fitness systems, learning tools, lifestyle structure, practical coaching, and ongoing challenges, Gray Mentality provides ways to keep the body working, the mind engaged, and the spirit unwilling to quit.

At its core, Gray Mentality is a rebellion against passive aging.

It says: do not lie in a bed waiting for death.

Die Living.</p>
<a href="https://graymentality.ca" target="_blank" rel="noopener noreferrer">Learn more about Gray Mentality</a>
<a href="mailto:gray@graymentality.ca" target="_blank" rel="noopener noreferrer">Contact A Gray Mentality</a>
          </article>
          <article>
            <div class="card-heading">
              <span class="card-logo-frame">
                <img class="card-logo" src="assets/images/ChatGPTimg-xfit.png" alt="xFit logo" width="50" height="50" />
              </span>
              <h3>xFit Development</h3>
            </div>
            <p>exFIT is a compliance-based strength and longevity system built around the Gray Mentality philosophy: Die Living.

It is designed for older adults and everyday people who want to resist passive aging by keeping the body and mind under regular, intelligent challenge. exFIT is not about chasing youth, bodybuilding culture, or short-term transformation hype. It is about building a repeatable structure that helps people keep moving, keep adapting, and keep earning progress through consistency.

exFIT uses planned resistance training, recovery, progression, reminders, education, and accountability to help users create a long-term habit of physical effort. The central idea is simple: the program does not reward intention. It rewards completion. You progress because you show up, do the work, recover, and return.

What exFIT is

exFIT is a structured fitness system for people who need a clear path, not random workouts.

It is a program that values consistency over intensity, compliance over ego, and long-term adaptation over quick results. It helps users follow a planned sequence of workouts, track completion, monitor effort, and progress only when the work has actually been done.

It is especially suited to people who want strength, function, independence, confidence, and resilience as they age.

exFIT is also a mindset tool. It is designed to remind users that aging well requires participation. The body adapts when it is asked to adapt. The mind stays sharper when it is required to learn, focus, and engage. exFIT creates those regular demands in a controlled, measurable way.

What exFIT is not

exFIT is not a bodybuilding program.

It is not a six-week beach-body challenge, a punishment routine, or a social media fitness trend. It is not built around extreme dieting, reckless intensity, or comparing yourself to younger athletes, influencers, or unrealistic ideals.

It is not a system for people looking for shortcuts.

exFIT does not pretend that motivation will always be there. It does not depend on hype. It is built for the days when motivation is gone and structure has to carry the user forward.

It is also not medical treatment. Users with health concerns, injuries, or medical limitations should work within appropriate medical guidance before beginning or modifying exercise.

Who exFIT is for

exFIT is for older adults who are not ready to surrender to decline.

It is for people who want to remain strong enough to live independently, move confidently, and keep participating in life. It is for those who understand that comfort, inactivity, and avoidance can quietly become a trap.

exFIT is for people who appreciate structure. It is for beginners who need guidance, returning exercisers who need consistency, and experienced lifters who want a sustainable system that respects recovery and progression.

It is also for people who respond well to accountability. exFIT is built for users willing to record what they did, accept what they missed, and keep going without drama or excuses.

Who exFIT is not for

exFIT is not for people who want entertainment more than discipline.

It is not for people who want to skip the work but still receive the reward. It is not for those chasing extreme physiques, maximum lifting numbers at all costs, or constant novelty.

It is not for people who want the program to flatter them. exFIT is honest by design. If the work was done, the system records it. If it was missed, the system records that too. That honesty is part of the training.

exFIT may also not be appropriate for someone who needs direct medical supervision, rehabilitation, or highly individualized clinical exercise programming unless they are also working with qualified healthcare or fitness professionals.

The core promise

exFIT gives users a system for continuing to adapt.

Not perfectly. Not dramatically. Not for applause.

Consistently.

It exists for people who would rather meet the aging process standing up, under load, still learning, still moving, still fighting for capacity.

exFIT by Gray Mentality: Die Living.</p>
<a href="https://xfit.graymentality.ca" target="_blank" rel="noopener noreferrer">Learn more about xFIT</a>
<a href="mailto:infoy@xfit.graymentality.ca" target="_blank" rel="noopener noreferrer">Contact the xFIT platform</a>
          </article>
          <article>
            <h3>Programming</h3>
            <p>My programming skills are self-taught, practical, and project-driven.

Over the past two years, I have learned by building real systems, not by following a traditional academic path. My progress has come from identifying problems, building solutions, breaking things, debugging them, rebuilding them better, and continuing to expand the system.

I have worked primarily with PHP, MySQL, HTML, CSS, JavaScript, Docker, Git, Linux, and Android/Kotlin concepts, using them to create real tools rather than isolated practice projects. Much of my learning has come through developing exFIT by Gray Mentality, a compliance-based fitness platform with user registration, onboarding, workout generation, database automation, email queues, scheduled jobs, security checks, mobile workout logging, and administrative workflows.

One of my strongest programming traits is persistence. I am not interested in simply copying code. I want to understand how the pieces fit together: how files are organized, how routing works, how sessions behave, how SQL events run, how containers communicate, and how to make systems safer, cleaner, and more maintainable.

I have taught myself to think in terms of systems: how user data flows through registration and onboarding, how workouts are generated and scheduled, how completion and missed workouts are tracked, how database tables relate to one another, how automation reduces manual work, and how logging helps explain what happened.

My style is incremental and relentless. I build something, test it, question it, and then return to it with better structure, clearer naming, better comments, stronger logging, and improved separation of concerns. Over time, I have moved from simply trying to make individual pages work toward larger architectural ideas such as front controllers, modular code, reusable helpers, stored procedures, Dockerized services, cron automation, and mobile app development.

I am still self-taught, but I am not casual. I am building real software while learning directly inside the project. That gives my skill set a practical edge: I understand programming as a tool for solving real problems, not as an abstract classroom exercise.

In two years, I have grown from beginner experimentation into a capable independent builder who can design, question, troubleshoot, and evolve a working application across the database, backend, frontend, infrastructure, and mobile layers.</p>
          </article>
          <article>
            <h3>Training</h3>
            <p>Training is where the philosophy becomes physical.

My approach is built around strength, mobility, consistency, and intelligent progression. I focus on helping people build a body that works better in real life: stronger legs, better balance, more confidence, improved posture, usable endurance, and the ability to keep participating in the things they care about.

The goal is not punishment, ego lifting, or chasing trends. The goal is repeatable work done well. That means clear exercises, appropriate resistance, proper recovery, honest tracking, and steady progress over time.

For older adults, returning exercisers, and people who need structure, training should feel challenging but understandable. You should know what you are doing, why you are doing it, and how it fits into the larger goal of staying capable, independent, and engaged.

Training is also accountability. It gives the body a reason to adapt and gives the mind a reason to stay involved. Whether the work happens in a gym, at home, or through a structured platform like exFIT, the principle is the same: show up, do the work, recover, and come back stronger.</p>
          </article>
        </div>
      </section>

      <section class="philosophy-section">
        <div class="panel">
          <h2>The Philosophy</h2>
          <p>
            A GrayMentality is about embracing the space between extremes. It is not about black or white thinking, but about action, balance, and continuous improvement. It pushes you to own your process, stay adaptable, and build strength from the inside out.
          </p>
          <p>
            Whether in business, fitness, or personal growth, the goal is the same: clarity of purpose, consistency in practice, and courage to act.
          </p>
        </div>
      </section>

      <section class="latest-notes-section">
        <div class="panel latest-notes-panel">
          <h2>Latest Notes</h2>
          <div class="latest-notes-list">
            <?php foreach ($latest_notes as $note): ?>
              <article>
                <span><?php echo htmlspecialchars(($note['date'] ?? '') . ' · ' . ($note['type'] ?? 'update'), ENT_QUOTES, 'UTF-8'); ?></span>
                <h3><?php echo htmlspecialchars($note['title'] ?? 'Update', ENT_QUOTES, 'UTF-8'); ?></h3>
                <p><?php echo htmlspecialchars($note['body'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section id="projects" class="projects-section">
        <div class="panel">
          <h2>Projects & Case Studies</h2>
          <div class="projects-grid">
            <article>
              <h3>The Endless Pursuit of Par Golf</h3>
              <p>A personal golf project focused on practice, patience, mechanics, course management, and the long discipline of chasing better scores one swing at a time.</p>
            </article>
            <article>
              <h3>xFit Program Development</h3>
              <p>Designed customized fitness systems combining strength and agility, helping clients achieve real results.</p>
            </article>
            <article>
              <h3>GrayMentality Framework</h3>
              <p>Developed a modern philosophy for personal and professional growth, emphasizing clarity and courage.</p>
            </article>
          </div>
        </div>
      </section>

      <section id="testimonials" class="testimonials-section">
        <div class="panel">
          <h2>Testimonials</h2>
          <div class="testimonials-list">
            <?php if ($testimonial): ?>
              <blockquote>
                <p>"<?php echo htmlspecialchars($testimonial['text'], ENT_QUOTES, 'UTF-8'); ?>"</p>
                <cite>- <?php echo htmlspecialchars($testimonial['author'], ENT_QUOTES, 'UTF-8'); ?></cite>
              </blockquote>
            <?php else: ?>
              <p>No testimonials are available right now.</p>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <div class="form-row">
        <section id="subscribe" class="subscribe-section">
          <div class="panel subscribe-panel">
            <div>
              <h2>Subscribe for Updates</h2>
              <p>Get notified when I add new page content, family photos, or news.</p>
            </div>
            <?php if ($subscribe_message): ?>
              <p class="form-message success"><?php echo htmlspecialchars($subscribe_message, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <?php if ($subscribe_error): ?>
              <p class="form-message error"><?php echo htmlspecialchars($subscribe_error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form method="post" class="subscribe-form">
              <input type="hidden" name="subscribe" value="1">
              <div class="subscribe-fields">
                <input type="text" name="subscriber_name" placeholder="Your Name">
                <input type="email" name="subscriber_email" placeholder="Your Email" required>
              </div>
              <div class="subscribe-topics" aria-label="Update types">
                <label><input type="checkbox" name="topics[]" value="page_content" checked> Page content</label>
                <label><input type="checkbox" name="topics[]" value="photos" checked> Photos</label>
                <label><input type="checkbox" name="topics[]" value="news" checked> News</label>
              </div>
              <button type="submit" class="cta-button">Subscribe</button>
            </form>
          </div>
        </section>

        <section id="guestbook" class="guestbook-section">
          <div class="panel">
            <h2>Guestbook</h2>
            <form method="post" class="guestbook-form">
              <input type="hidden" name="guestbook" value="1">
              <input type="text" name="name" placeholder="Your Name" required>
              <textarea name="message" placeholder="Your Message" required></textarea>
              <button type="submit" class="cta-button">Submit</button>
            </form>
            <?php if ($guestbook_error): ?>
              <p><?php echo htmlspecialchars($guestbook_error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <div class="guestbook-entries">
              <?php foreach ($guestbook_entries as $entry): ?>
                <div class="entry">
                  <strong><?php echo htmlspecialchars($entry['name'], ENT_QUOTES, 'UTF-8'); ?>:</strong>
                  <p><?php echo htmlspecialchars($entry['message'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <small><?php echo htmlspecialchars($entry['timestamp'], ENT_QUOTES, 'UTF-8'); ?></small>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>
      </div>

      <footer class="page-footer">
        <p>jerrybilous.ca · mail@jerrybilous.ca</p>
      </footer>
    </main>
    <script>
      const lifeCountdown = document.querySelector('.life-countdown');
      if (lifeCountdown) {
        const targetTime = new Date(lifeCountdown.dataset.target).getTime();
        const daysEl = lifeCountdown.querySelector('[data-countdown-days]');
        const hoursEl = lifeCountdown.querySelector('[data-countdown-hours]');
        const minutesEl = lifeCountdown.querySelector('[data-countdown-minutes]');
        const secondsEl = lifeCountdown.querySelector('[data-countdown-seconds]');

        function updateLifeCountdown() {
          const remaining = Math.max(0, targetTime - Date.now());
          const totalSeconds = Math.floor(remaining / 1000);
          const days = Math.floor(totalSeconds / 86400);
          const hours = Math.floor((totalSeconds % 86400) / 3600);
          const minutes = Math.floor((totalSeconds % 3600) / 60);
          const seconds = totalSeconds % 60;

          daysEl.textContent = days.toLocaleString();
          hoursEl.textContent = String(hours).padStart(2, '0');
          minutesEl.textContent = String(minutes).padStart(2, '0');
          secondsEl.textContent = String(seconds).padStart(2, '0');
        }

        updateLifeCountdown();
        setInterval(updateLifeCountdown, 1000);
      }

      document.querySelectorAll('.grid-panel article').forEach((card) => {
        const copy = card.querySelector('p');
        if (!copy || copy.scrollHeight <= copy.clientHeight + 8) {
          return;
        }

        card.classList.add('is-collapsible');
        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'service-card-toggle';
        toggle.textContent = 'Read more';
        toggle.setAttribute('aria-expanded', 'false');

        toggle.addEventListener('click', () => {
          const expanded = card.classList.toggle('is-expanded');
          toggle.textContent = expanded ? 'Show less' : 'Read more';
          toggle.setAttribute('aria-expanded', String(expanded));
        });

        copy.insertAdjacentElement('afterend', toggle);
      });
    </script>
  </body>
</html>
