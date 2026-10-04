<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Jerry Bilous offers practical freelance software development for PHP, MySQL, MariaDB, Docker, automation, database cleanup, and legacy web application repair.">
  <meta property="og:title" content="Jerry Bilous | Practical Software Systems">
  <meta property="og:description" content="Freelance PHP/MySQL development, debugging, migrations, automation, and legacy system repair.">
  <meta property="og:image" content="https://jerrybilous.ca/assets/images/freelance-developer-workspace.png">
  <title>Jerry Bilous | Freelance Software Development</title>
  <style>
    :root {
      color-scheme: dark;
      font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      --bg: #111114;
      --bg-panel: #202027;
      --line: rgba(255, 255, 255, 0.1);
      --text: #f8f7fb;
      --muted: #b9b7c4;
      --orange: #ff6b00;
      --orange-soft: rgba(255, 107, 0, 0.22);
      --purple: #bd00ff;
      --purple-soft: rgba(189, 0, 255, 0.2);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      background:
        linear-gradient(135deg, rgba(255, 107, 0, 0.08), transparent 34%),
        linear-gradient(315deg, rgba(189, 0, 255, 0.12), transparent 38%),
        var(--bg);
      color: var(--text);
      line-height: 1.65;
    }

    a {
      color: inherit;
    }

    .nav-bar {
      position: fixed;
      top: 0;
      width: 100%;
      background: rgba(17, 17, 20, 0.88);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--line);
      box-shadow: 0 14px 36px rgba(0, 0, 0, 0.28);
      z-index: 100;
    }

    .nav-container {
      width: min(1140px, calc(100% - 32px));
      height: 60px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
    }

    .nav-logo {
      font-weight: 700;
      color: var(--text);
      text-decoration: none;
      text-shadow: 0 0 18px var(--orange-soft);
    }

    .nav-links {
      display: flex;
      gap: 22px;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .nav-links a {
      color: var(--muted);
      text-decoration: none;
    }

    .nav-links a:hover {
      color: var(--orange);
    }

    .page-shell {
      width: min(1140px, calc(100% - 32px));
      margin: 0 auto;
      padding: 92px 0 70px;
    }

    .hero {
      position: relative;
      min-height: min(760px, calc(100vh - 118px));
      display: grid;
      align-items: end;
      overflow: hidden;
      border-radius: 18px;
      border: 1px solid rgba(255, 107, 0, 0.28);
      background-image:
        linear-gradient(90deg, rgba(17, 17, 20, 0.94) 0%, rgba(17, 17, 20, 0.75) 45%, rgba(17, 17, 20, 0.2) 100%),
        url("/assets/images/freelance-developer-workspace.png");
      background-size: cover;
      background-position: center;
      box-shadow: 0 34px 100px rgba(0, 0, 0, 0.38);
    }

    .hero-inner {
      width: min(760px, 100%);
      padding: clamp(24px, 5vw, 58px);
    }

    .eyebrow {
      margin: 0 0 18px;
      color: var(--orange);
      font-size: 0.9rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      text-shadow: 0 0 16px var(--orange-soft);
    }

    h1 {
      margin: 0;
      max-width: 760px;
      font-size: clamp(2.3rem, 6vw, 5rem);
      line-height: 0.98;
      letter-spacing: 0;
    }

    .hero-text {
      max-width: 680px;
      margin: 22px 0 0;
      color: var(--muted);
      font-size: clamp(1rem, 1.6vw, 1.18rem);
    }

    .hero-actions,
    .pill-row {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 24px;
    }

    .button,
    .pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 42px;
      padding: 10px 16px;
      border-radius: 999px;
      text-decoration: none;
      border: 1px solid rgba(255, 255, 255, 0.12);
      background: rgba(32, 32, 39, 0.82);
      color: var(--text);
      font-weight: 700;
    }

    .button-primary {
      background: var(--orange);
      color: #16100c;
      box-shadow: 0 0 24px var(--orange-soft);
    }

    .button-secondary {
      border-color: rgba(189, 0, 255, 0.55);
      box-shadow: 0 0 22px var(--purple-soft);
    }

    .pill {
      color: #f0eef8;
      font-size: 0.94rem;
      font-weight: 600;
      box-shadow: inset 0 0 0 1px rgba(255, 107, 0, 0.08);
    }

    .section {
      margin: 54px 0 0;
    }

    .panel {
      padding: clamp(22px, 4vw, 34px);
      border-radius: 16px;
      background:
        linear-gradient(135deg, rgba(255, 107, 0, 0.08), transparent 42%),
        var(--bg-panel);
      border: 1px solid var(--line);
      box-shadow: 0 18px 50px rgba(0, 0, 0, 0.28);
    }

    .section-heading {
      margin: 0 0 14px;
      color: var(--orange);
      font-size: clamp(1.65rem, 3vw, 2.3rem);
      line-height: 1.08;
      text-shadow: 0 0 16px var(--orange-soft);
    }

    .lead {
      max-width: 880px;
      margin: 0;
      color: var(--muted);
      font-size: 1.05rem;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
      margin-top: 22px;
    }

    .card {
      padding: 22px;
      border-radius: 14px;
      background: rgba(41, 41, 48, 0.86);
      border: 1px solid rgba(189, 0, 255, 0.2);
      box-shadow: inset 0 0 0 1px rgba(255, 107, 0, 0.06);
    }

    .card h3 {
      margin: 0 0 10px;
      color: var(--orange);
      font-size: 1.15rem;
    }

    .card p,
    .card li {
      color: var(--muted);
    }

    .card p {
      margin: 0;
    }

    .card ul {
      display: grid;
      gap: 8px;
      margin: 0;
      padding-left: 20px;
    }

    .split {
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(300px, 0.8fr);
      gap: 22px;
      align-items: start;
    }

    .proof-list {
      display: grid;
      gap: 12px;
      margin: 18px 0 0;
      padding: 0;
      list-style: none;
    }

    .proof-list li {
      padding: 14px;
      border-radius: 12px;
      background: rgba(17, 17, 20, 0.58);
      border: 1px solid rgba(255, 107, 0, 0.18);
      color: var(--muted);
    }

    .proof-list strong {
      color: var(--text);
    }

    .contact-panel {
      display: grid;
      gap: 14px;
      text-align: center;
    }

    .contact-panel p {
      max-width: 720px;
      margin: 0 auto;
      color: var(--muted);
    }

    .page-footer {
      margin-top: 34px;
      padding: 18px 0 6px;
      text-align: center;
      color: #94909e;
      font-size: 0.95rem;
    }

    @media (max-width: 900px) {
      .nav-container {
        height: auto;
        min-height: 74px;
        padding: 10px 0;
        align-items: flex-start;
        flex-direction: column;
      }

      .nav-links {
        width: 100%;
        gap: 14px;
        overflow-x: auto;
        padding-bottom: 2px;
      }

      .nav-links a {
        white-space: nowrap;
        font-size: 0.9rem;
      }

      .page-shell {
        padding-top: 128px;
      }

      .hero {
        min-height: auto;
        background-position: 64% center;
      }

      .grid,
      .split {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 640px) {
      .page-shell {
        width: min(100%, calc(100% - 24px));
      }

      .hero-inner {
        padding: 26px 20px;
      }

      .hero-actions .button {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <nav class="nav-bar">
    <div class="nav-container">
      <a href="/" class="nav-logo">Jerry Bilous - Hamilton, Canada</a>
      <ul class="nav-links">
        <li><a href="#services">Services</a></li>
        <li><a href="#proof">Proof</a></li>
        <li><a href="#fit">Best Fit</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="/">Main Site</a></li>
      </ul>
    </div>
  </nav>

  <main class="page-shell">
    <section class="hero">
      <div class="hero-inner">
        <p class="eyebrow">Freelance software systems</p>
        <h1>Practical PHP, MySQL, and automation help for real systems.</h1>
        <p class="hero-text">
          I help small businesses and independent builders repair, understand, and improve the software they already depend on:
          legacy PHP apps, MariaDB/MySQL databases, onboarding flows, admin tools, scheduled jobs, migrations, and the messy
          places where code and real operations meet.
        </p>
        <div class="hero-actions">
          <a class="button button-primary" href="mailto:mail@jerrybilous.ca?subject=Software%20project%20help">Email Jerry</a>
          <a class="button button-secondary" href="https://github.com/circuitscience/jerrybilous" target="_blank" rel="noopener noreferrer">GitHub</a>
          <a class="button button-secondary" href="https://www.linkedin.com/in/jerry-bilous-me-9120b533" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </div>
        <div class="pill-row" aria-label="Core skills">
          <span class="pill">PHP</span>
          <span class="pill">MySQL / MariaDB</span>
          <span class="pill">Docker</span>
          <span class="pill">Automation</span>
          <span class="pill">Debugging</span>
        </div>
      </div>
    </section>

    <section id="services" class="section panel">
      <h2 class="section-heading">What I Can Help With</h2>
      <p class="lead">
        My best work is not theoretical polish. It is getting inside a working system, finding out why it behaves the way it does,
        and turning that knowledge into fixes, tooling, and clearer operating procedures.
      </p>
      <div class="grid">
        <article class="card">
          <h3>Legacy PHP Repair</h3>
          <p>Debug broken pages, forms, sessions, routing, admin workflows, login issues, email flows, and older PHP code that still has business value.</p>
        </article>
        <article class="card">
          <h3>Database Cleanup</h3>
          <p>Trace missing rows, orphan records, failed migrations, stored procedure issues, collation problems, and local/live schema drift.</p>
        </article>
        <article class="card">
          <h3>Workflow Automation</h3>
          <p>Build scripts, routines, seed processes, scheduled jobs, and admin tools that replace repetitive manual steps with repeatable system behavior.</p>
        </article>
        <article class="card">
          <h3>Small Business Tools</h3>
          <p>Create practical dashboards, internal web tools, data entry flows, reporting pages, and controlled user/account workflows.</p>
        </article>
        <article class="card">
          <h3>App State Diagnosis</h3>
          <p>Follow user state across tables, code paths, sessions, cron jobs, and email queues until the actual failure is explainable.</p>
        </article>
        <article class="card">
          <h3>Careful Modernization</h3>
          <p>Improve structure, naming, logging, validation, and deployment habits without rewriting a system just because it is old.</p>
        </article>
      </div>
    </section>

    <section id="proof" class="section split">
      <div class="panel">
        <h2 class="section-heading">Built From Real Project Work</h2>
        <p class="lead">
          Over the last two years I have been building exFIT by Gray Mentality, a compliance-based strength and longevity platform.
          That project forced me to learn the parts of software that matter after the first demo: data integrity, onboarding state,
          password boundaries, scheduling, logs, repair scripts, and repeatable deployment.
        </p>
        <ul class="proof-list">
          <li><strong>Onboarding automation:</strong> registration, screening, selected exercises, program creation, workout generation, and scheduled sessions.</li>
          <li><strong>Database routines:</strong> stored procedures, seed helpers, cleanup queries, migration checks, and MariaDB/MySQL collation fixes.</li>
          <li><strong>Operational tooling:</strong> admin pages, email queues, cron runners, logs, backups, and controlled test users.</li>
          <li><strong>Debugging method:</strong> inspect the data, trace the code, reproduce the failure, fix the cause, then verify the resulting rows.</li>
        </ul>
      </div>
      <aside class="panel">
        <h2 class="section-heading">Working Style</h2>
        <p class="lead">
          I am self-taught, practical, and persistent. I do not pretend messy systems are simple. I document what I find,
          explain the tradeoffs, and prefer small verified changes over risky rewrites.
        </p>
        <div class="pill-row">
          <span class="pill">Investigate first</span>
          <span class="pill">Explain clearly</span>
          <span class="pill">Repair carefully</span>
          <span class="pill">Verify with data</span>
        </div>
      </aside>
    </section>

    <section id="fit" class="section panel">
      <h2 class="section-heading">Best Fit Projects</h2>
      <div class="grid">
        <article class="card">
          <h3>Two-Hour Diagnosis</h3>
          <ul>
            <li>Something broke and nobody knows why.</li>
            <li>You need a clear written summary.</li>
            <li>You want fix options before committing to a rebuild.</li>
          </ul>
        </article>
        <article class="card">
          <h3>Maintenance Block</h3>
          <ul>
            <li>Small fixes across an existing PHP/MySQL app.</li>
            <li>Admin tools, forms, emails, reports, and cleanup.</li>
            <li>Practical improvements without project theatre.</li>
          </ul>
        </article>
        <article class="card">
          <h3>Automation Build</h3>
          <ul>
            <li>Turn repeated manual steps into a reliable script or tool.</li>
            <li>Create seed, migration, or cleanup processes.</li>
            <li>Add logs so future failures explain themselves faster.</li>
          </ul>
        </article>
      </div>
    </section>

    <section id="contact" class="section panel contact-panel">
      <h2 class="section-heading">Need Practical Software Help?</h2>
      <p>
        Send me the problem in plain language. I can start with a focused investigation, report what I find,
        and recommend the smallest useful next step.
      </p>
      <div class="hero-actions" style="justify-content: center;">
        <a class="button button-primary" href="mailto:mail@jerrybilous.ca?subject=Software%20project%20help">mail@jerrybilous.ca</a>
        <a class="button button-secondary" href="/">Back to jerrybilous.ca</a>
      </div>
    </section>

    <footer class="page-footer">
      <p>jerrybilous.ca · Hamilton, Canada · Practical software systems</p>
    </footer>
  </main>
</body>
</html>
