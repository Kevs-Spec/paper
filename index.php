<?php
session_start();

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors[] = 'Please enter your name.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($message === '') {
        $errors[] = 'Please add a message.';
    }

    if (empty($errors)) {
        $_SESSION['visitor_name'] = $name;
        $_SESSION['visitor_email'] = $email;
        $successMessage = 'Thanks, ' . htmlspecialchars($name) . '! Your message has been received.';
    }
}

$visitorName = $_SESSION['visitor_name'] ?? 'friend';
$today = new DateTime('now', new DateTimeZone('UTC'));
$featureCards = [
    ['title' => 'Responsive Design', 'text' => 'Optimized for desktop, tablet, and mobile screens.'],
    ['title' => 'PHP Form Handling', 'text' => 'Secure, validated input with session-based feedback.'],
    ['title' => 'Modern Styling', 'text' => 'Clean gradients, hover effects, and accessible structure.'],
];

$quotes = [
    '“The best way to predict the future is to build it.” — Alan Kay',
    '“Code is like humor. When you have to explain it, it’s bad.” — Cory House',
    '“Success is the sum of small efforts, repeated day in and day out.” — Robert Collier',
];
$quote = $quotes[array_rand($quotes)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern PHP Landing Page</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #111827;
            --panel-alt: #1f2937;
            --primary: #8b5cf6;
            --primary-light: #a78bfa;
            --accent: #22c55e;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --danger: #f87171;
            --shadow: rgba(15, 23, 42, 0.35);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #020617 0%, #111827 50%, #0f172a 100%);
            color: var(--text);
            min-height: 100vh;
        }

        .container {
            width: min(1100px, 92%);
            margin: 0 auto;
        }

        header {
            padding: 24px 0 12px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .brand span {
            color: var(--primary-light);
        }

        .nav-links {
            display: flex;
            gap: 18px;
            list-style: none;
            padding: 0;
            margin: 0;
            color: var(--muted);
        }

        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--text);
        }

        .hero {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 30px;
            align-items: center;
            padding: 56px 0 34px;
        }

        .eyebrow {
            display: inline-block;
            padding: 7px 12px;
            border: 1px solid rgba(167, 139, 250, 0.35);
            background: rgba(139, 92, 246, 0.14);
            color: var(--primary-light);
            border-radius: 999px;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        h1 {
            font-size: clamp(2.5rem, 4vw, 4.2rem);
            line-height: 1.05;
            margin: 0;
            max-width: 620px;
        }

        .accent {
            color: var(--primary-light);
        }

        .lead {
            margin-top: 20px;
            max-width: 560px;
            color: var(--muted);
            font-size: 1.08rem;
            line-height: 1.75;
        }

        .cta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 28px;
        }

        .button {
            display: inline-block;
            padding: 14px 22px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .button.primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 18px 30px rgba(139, 92, 246, 0.32);
        }

        .button.secondary {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .hero-card {
            background: linear-gradient(180deg, rgba(17, 24, 39, 0.92) 0%, rgba(31, 41, 55, 0.92) 100%);
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 26px 70px var(--shadow);
        }

        .status-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #bbf7d0;
            font-size: 0.88rem;
            font-weight: 700;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 14px rgba(34, 197, 94, 0.8);
        }

        .metric-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }

        .metric {
            background: rgba(148, 163, 184, 0.05);
            border: 1px solid rgba(148, 163, 184, 0.1);
            padding: 18px 16px;
            border-radius: 14px;
        }

        .metric strong {
            display: block;
            font-size: 1.6rem;
            margin-bottom: 8px;
        }

        .metric span {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
            padding: 32px 0 18px;
        }

        .card {
            background: rgba(15, 23, 42, 0.82);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 18px 38px rgba(2, 6, 23, 0.25);
        }

        .card h3 {
            margin: 0 0 12px;
            font-size: 1.15rem;
        }

        .card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .contact-section {
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            gap: 28px;
            padding: 24px 0 72px;
        }

        .info-panel {
            padding: 30px 26px;
            background: linear-gradient(180deg, rgba(139, 92, 246, 0.12) 0%, rgba(17, 24, 39, 0.32) 100%);
        }

        .info-panel ul {
            list-style: none;
            padding: 0;
            margin: 24px 0 0;
            color: var(--muted);
            line-height: 2;
        }

        form {
            display: grid;
            gap: 18px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        label {
            font-weight: 600;
            color: var(--text);
        }

        input, textarea {
            width: 100%;
            background: rgba(15, 23, 42, 0.9);
            color: var(--text);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 12px;
            padding: 13px 14px;
            font: inherit;
        }

        input:focus, textarea:focus {
            outline: 2px solid rgba(167, 139, 250, 0.6);
            border-color: transparent;
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        .error-list {
            padding: 12px 16px;
            background: rgba(248, 113, 113, 0.08);
            border: 1px solid rgba(248, 113, 113, 0.2);
            border-radius: 12px;
            color: #fecaca;
            margin: 0;
            list-style: none;
        }

        .success {
            padding: 12px 16px;
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #bbf7d0;
            border-radius: 12px;
        }

        footer {
            padding: 18px 0 42px;
            color: var(--muted);
            text-align: center;
        }

        @media (max-width: 820px) {
            .hero,
            .contact-section,
            .content-grid {
                grid-template-columns: 1fr;
            }

            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-links {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="brand">Nova<span>Core</span></div>
                <ul class="nav-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero" id="about">
            <div>
                <div class="eyebrow">Build smarter</div>
                <h1>Bring your <span class="accent">ideas</span> to life with clarity.</h1>
                <p class="lead">
                    We design digital experiences that turn complex problems into simple,
                    valuable solutions. This PHP page is a small showcase of responsive design,
                    validation, and polished user experience.
                </p>
                <div class="cta-row">
                    <a class="button primary" href="#contact">Get started</a>
                    <a class="button secondary" href="#features">View features</a>
                </div>
            </div>

            <div class="hero-card">
                <div class="status-box">
                    <span class="status-pill"><span class="dot"></span>System online</span>
                    <strong><?php echo htmlspecialchars($today->format('M d, Y')); ?></strong>
                </div>

                <div>
                    <strong style="font-size: 0.75rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em;">Welcome back</strong>
                    <h2 style="margin: 10px 0 16px; font-size: 2rem;">Hello, <?php echo htmlspecialchars($visitorName); ?>!</h2>
                </div>

                <div class="metric-grid">
                    <div class="metric">
                        <strong>96%</strong>
                        <span>Client satisfaction</span>
                    </div>
                    <div class="metric">
                        <strong>24/7</strong>
                        <span>Monitoring</span>
                    </div>
                    <div class="metric">
                        <strong>48h</strong>
                        <span>Average launch</span>
                    </div>
                    <div class="metric">
                        <strong>320+</strong>
                        <span>Projects shipped</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-grid" id="features">
            <?php foreach ($featureCards as $feature): ?>
                <article class="card">
                    <h3><?php echo htmlspecialchars($feature['title']); ?></h3>
                    <p><?php echo htmlspecialchars($feature['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </section>

        <section class="contact-section" id="contact">
            <div class="card info-panel">
                <div class="eyebrow">Why choose us</div>
                <h2 style="margin: 0; font-size: 2rem;">We turn strategy into action.</h2>
                <ul>
                    <li>• Clear communication and transparent delivery</li>
                    <li>• Design systems that scale with your product</li>
                    <li>• Reliable solutions built with modern standards</li>
                    <li>• Friendly support from kickoff to launch</li>
                </ul>
                <p style="margin-top: 26px; color: var(--muted); line-height: 1.8;">
                    <?php echo htmlspecialchars($quote); ?>
                </p>
            </div>

            <div class="card">
                <h2 style="margin: 0 0 18px;">Send a message</h2>

                <?php if (!empty($errors)): ?>
                    <ul class="error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($successMessage !== ''): ?>
                    <div class="success"><?php echo htmlspecialchars($successMessage); ?></div>
                <?php endif; ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" placeholder="Jane Doe" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="jane@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>

                    <div class="field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Tell us about your project..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="button primary" style="width: fit-content;">Submit</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        © <?php echo date('Y'); ?> NovaCore. Crafted with PHP and modern web design.
    </footer>
</body>
</html>
