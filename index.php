<?php
require __DIR__ . '/auth.php';
ensure_session_started();

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$user = $_SESSION['user'] ?? null;

if (!$user && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['flash'] = 'Bitte zuerst einloggen, um Seiten zu erstellen oder zu sehen.';
    header('Location: /index.php');
    exit;
}

$templatePresets = [
    'general_page' => [
        'label' => 'General Page',
        'description' => 'Your Journey Starts Here',
        'defaults' => [
            'hero_title' => 'Welcome to Our Platform',
            'hero_subtitle' => 'Your Journey Starts Here',
            'hero_description' => 'Discover amazing features and possibilities with our comprehensive platform designed for your success.',
            'feature1_title' => 'Easy to Use',
            'feature1_desc' => 'Intuitive interface designed for everyone, no technical knowledge required.',
            'feature1_emoji' => '🎯',
            'feature2_title' => 'Fast & Reliable',
            'feature2_desc' => 'Lightning-fast performance with 99.9% uptime guarantee.',
            'feature2_emoji' => '⚡',
            'feature3_title' => 'Secure',
            'feature3_desc' => 'Enterprise-grade security to keep your data safe and protected.',
            'feature3_emoji' => '🔒',
            'cta_title' => 'Ready to Get Started?',
            'cta_button_text' => 'Get Started Now',
        ],
    ],
    'service_page' => [
        'label' => 'Service Page',
        'description' => 'Excellence in Every Detail',
        'defaults' => [
            'hero_title' => 'Professional Services',
            'hero_subtitle' => 'Excellence in Every Detail',
            'hero_description' => 'We provide top-tier professional services tailored to meet your unique business needs and objectives.',
            'feature1_title' => 'Expert Team',
            'feature1_desc' => 'Certified professionals with years of industry experience.',
            'feature1_emoji' => '👥',
            'feature2_title' => 'Custom Solutions',
            'feature2_desc' => 'Tailored approaches designed specifically for your business.',
            'feature2_emoji' => '🎨',
            'feature3_title' => '24/7 Support',
            'feature3_desc' => 'Round-the-clock customer service whenever you need assistance.',
            'feature3_emoji' => '💬',
            'cta_title' => 'Need Our Services?',
            'cta_button_text' => 'Contact Us Today',
        ],
    ],
    'product_page' => [
        'label' => 'Product Page',
        'description' => 'Innovation Meets Quality',
        'defaults' => [
            'hero_title' => 'Our Premium Product',
            'hero_subtitle' => 'Innovation Meets Quality',
            'hero_description' => 'Experience the perfect blend of cutting-edge technology and user-friendly design in our flagship product.',
            'feature1_title' => 'Latest Technology',
            'feature1_desc' => 'Built with the most advanced tech stack available today.',
            'feature1_emoji' => '🚀',
            'feature2_title' => 'User Friendly',
            'feature2_desc' => 'Designed with simplicity and ease of use as top priorities.',
            'feature2_emoji' => '✨',
            'feature3_title' => 'Great Value',
            'feature3_desc' => 'Premium quality at competitive prices with no hidden costs.',
            'feature3_emoji' => '💎',
            'cta_title' => 'Ready to Purchase?',
            'cta_button_text' => 'Buy Now',
        ],
    ],
    'about_page' => [
        'label' => 'About Page',
        'description' => 'Our Story & Mission',
        'defaults' => [
            'hero_title' => 'About Us',
            'hero_subtitle' => 'Our Story & Mission',
            'hero_description' => 'Learn about our journey, values, and the passionate team working every day to deliver exceptional results.',
            'feature1_title' => 'Our Mission',
            'feature1_desc' => 'To empower businesses and individuals through innovative solutions.',
            'feature1_emoji' => '🎯',
            'feature2_title' => 'Our Vision',
            'feature2_desc' => 'Creating a future where technology serves everyone seamlessly.',
            'feature2_emoji' => '🌟',
            'feature3_title' => 'Our Values',
            'feature3_desc' => 'Integrity, innovation, and customer satisfaction drive everything we do.',
            'feature3_emoji' => '💡',
            'cta_title' => 'Want to Join Us?',
            'cta_button_text' => 'View Careers',
        ],
    ],
    'contact_page' => [
        'label' => 'Contact Page',
        'description' => "We'd Love to Hear From You",
        'defaults' => [
            'hero_title' => 'Get in Touch',
            'hero_subtitle' => "We'd Love to Hear From You",
            'hero_description' => 'Have questions or feedback? Our team is here to help and ready to assist you with anything you need.',
            'feature1_title' => 'Fast Response',
            'feature1_desc' => 'We typically respond within 24 hours on business days.',
            'feature1_emoji' => '⏱️',
            'feature2_title' => 'Multiple Channels',
            'feature2_desc' => 'Reach us via email, phone, or social media platforms.',
            'feature2_emoji' => '📱',
            'feature3_title' => 'Expert Support',
            'feature3_desc' => 'Our knowledgeable team is ready to solve your problems.',
            'feature3_emoji' => '🎓',
            'cta_title' => 'Ready to Connect?',
            'cta_button_text' => 'Send Message',
        ],
    ],
    'legal_page' => [
        'label' => 'Legal Page',
        'description' => 'Terms, Privacy & Compliance',
        'defaults' => [
            'hero_title' => 'Legal Information',
            'hero_subtitle' => 'Terms, Privacy & Compliance',
            'hero_description' => 'Important legal information about our services, privacy policies, and your rights as a user of our platform.',
            'feature1_title' => 'Privacy Policy',
            'feature1_desc' => 'We protect your data and respect your privacy at all times.',
            'feature1_emoji' => '🔐',
            'feature2_title' => 'Terms of Service',
            'feature2_desc' => 'Clear and fair terms that govern the use of our services.',
            'feature2_emoji' => '📋',
            'feature3_title' => 'GDPR Compliant',
            'feature3_desc' => 'Fully compliant with international data protection regulations.',
            'feature3_emoji' => '✅',
            'cta_title' => 'Questions About Our Terms?',
            'cta_button_text' => 'Contact Legal Team',
        ],
    ],
    'portfolio_page' => [
        'label' => 'Portfolio Page',
        'description' => 'Showcasing Our Best Work',
        'defaults' => [
            'hero_title' => 'Our Portfolio',
            'hero_subtitle' => 'Showcasing Our Best Work',
            'hero_description' => "Explore our collection of successful projects and see how we've helped clients achieve their goals.",
            'feature1_title' => 'Diverse Projects',
            'feature1_desc' => 'Experience across multiple industries and project types.',
            'feature1_emoji' => '🎨',
            'feature2_title' => 'Proven Results',
            'feature2_desc' => 'Measurable success and satisfied clients in every project.',
            'feature2_emoji' => '📈',
            'feature3_title' => 'Creative Excellence',
            'feature3_desc' => 'Award-winning designs and innovative solutions.',
            'feature3_emoji' => '🏆',
            'cta_title' => 'Like What You See?',
            'cta_button_text' => 'Start Your Project',
        ],
    ],
    'pricing_page' => [
        'label' => 'Pricing Page',
        'description' => 'Transparent & Affordable Plans',
        'defaults' => [
            'hero_title' => 'Simple Pricing',
            'hero_subtitle' => 'Transparent & Affordable Plans',
            'hero_description' => 'Choose the perfect plan for your needs with no hidden fees, clear pricing, and flexible payment options.',
            'feature1_title' => 'Flexible Plans',
            'feature1_desc' => 'Monthly or yearly billing options to suit your budget.',
            'feature1_emoji' => '💳',
            'feature2_title' => 'No Hidden Fees',
            'feature2_desc' => 'What you see is what you pay - complete transparency.',
            'feature2_emoji' => '💰',
            'feature3_title' => 'Easy Upgrades',
            'feature3_desc' => 'Scale up or down anytime as your needs change.',
            'feature3_emoji' => '📊',
            'cta_title' => 'Ready to Choose a Plan?',
            'cta_button_text' => 'View All Plans',
        ],
    ],
];

$templates = [];

function prettify_label(string $key): string
{
    return ucwords(str_replace('_', ' ', $key));
}

foreach ($templatePresets as $key => $preset) {
    $fields = [];
    foreach ($preset['defaults'] as $fieldName => $defaultValue) {
        $fields[] = [
            'name' => $fieldName,
            'label' => prettify_label($fieldName),
            'type' => str_contains($fieldName, 'desc') || str_contains($fieldName, 'description') ? 'textarea' : 'text',
            'placeholder' => $defaultValue,
        ];
    }
    $templates[$key] = [
        'label' => $preset['label'],
        'description' => $preset['description'],
        'defaults' => $preset['defaults'],
        'fields' => $fields,
    ];
}

function sanitize_text(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function hex_to_rgb(string $hex): array
{
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (strlen($hex) !== 6) {
        return [0, 0, 0];
    }

    return [
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2)),
    ];
}

function sanitize_slug(string $slug): string
{
    $slug = strtolower(trim($slug));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    return trim($slug, '-') ?: 'site';
}

function gather_buttons(): array
{
    $buttons = [];
    $labels = $_POST['button_label'] ?? [];
    $urls = $_POST['button_url'] ?? [];
    $colors = $_POST['button_color'] ?? [];
    foreach ($labels as $index => $label) {
        $label = sanitize_text($label);
        $url = sanitize_text($urls[$index] ?? '');
        if ($label === '' && $url === '') {
            continue;
        }
        $buttons[] = [
            'label' => $label,
            'url' => $url,
            'color' => sanitize_text($colors[$index] ?? ''),
        ];
    }
    return $buttons;
}

function gather_social(): array
{
    $social = [];
    $email = sanitize_text($_POST['social_email'] ?? '');
    $discord = sanitize_text($_POST['social_discord'] ?? '');
    if ($email !== '') {
        $social[] = ['label' => 'Email', 'url' => 'mailto:' . $email];
    }
    if ($discord !== '') {
        $social[] = ['label' => 'Discord', 'url' => $discord];
    }
    return $social;
}

function parse_lines(string $input): array
{
    $lines = preg_split('/\r?\n/', trim($input));
    return array_values(array_filter(array_map('trim', $lines), fn($line) => $line !== ''));
}

function build_template_content(string $template, array $data, array $templates, array $buttons): string
{
    $defaults = $templates[$template]['defaults'] ?? [];

    $value = fn(string $key): string => sanitize_text($data[$key] ?? $defaults[$key] ?? '');

    $ctaUrl = '#';
    if (!empty($buttons[0]['url'])) {
        $ctaUrl = sanitize_text($buttons[0]['url']);
    }

    $features = [
        [
            'emoji' => $value('feature1_emoji'),
            'title' => $value('feature1_title'),
            'desc' => $value('feature1_desc'),
        ],
        [
            'emoji' => $value('feature2_emoji'),
            'title' => $value('feature2_title'),
            'desc' => $value('feature2_desc'),
        ],
        [
            'emoji' => $value('feature3_emoji'),
            'title' => $value('feature3_title'),
            'desc' => $value('feature3_desc'),
        ],
    ];

    $featureCards = '';
    foreach ($features as $feature) {
        $featureCards .= "<div class='feature-card'><div class='feature-icon'>{$feature['emoji']}</div><div class='feature-title'>{$feature['title']}</div><div class='feature-description'>{$feature['desc']}</div></div>";
    }

    return "<div class='content-card'>"
        . "<div class='hero-badge'><span class='hero-badge-dot'></span>" . sanitize_text($templates[$template]['label'] ?? 'Template') . "</div>"
        . "<h1 class='page-title'>{$value('hero_title')}</h1>"
        . "<p class='page-subtitle'>{$value('hero_subtitle')}</p>"
        . "<p class='page-description'>{$value('hero_description')}</p>"
        . "<div class='features-section'>"
        . "<div class='features-grid'>{$featureCards}</div>"
        . "</div>"
        . "<div class='cta-section'>"
        . "<div class='cta-title'>{$value('cta_title')}</div>"
        . "<a class='btn' href='{$ctaUrl}' target='_blank' rel='noopener'>{$value('cta_button_text')}</a>"
        . "</div>"
        . "</div>";
}

function build_site_html(array $data, string $template, array $buttons, array $social, string $logoPath, string $favicon, array $templates): string
{
    $primary = sanitize_text($data['primary_color'] ?? '#00bcd4');
    $secondary = sanitize_text($data['secondary_color'] ?? '#8b5cf6');
    $name = sanitize_text($data['name'] ?? 'NordByte Webgen');
    $title = sanitize_text($data['title'] ?? 'Title');
    $subtitle = sanitize_text($data['subtitle'] ?? 'Subtitle');

    [$r1, $g1, $b1] = hex_to_rgb($primary);
    [$r2, $g2, $b2] = hex_to_rgb($secondary);

    $buttonMarkup = '';
    foreach ($buttons as $button) {
        $color = $button['color'] ?: $primary;
        $buttonMarkup .= "<a class='btn' style='background: {$color}' href='{$button['url']}' target='_blank' rel='noopener'>{$button['label']}</a>";
    }

    $socialMarkup = '';
    foreach ($social as $item) {
        $socialMarkup .= "<a class='social-link' href='{$item['url']}' target='_blank' rel='noopener'>{$item['label']}</a>";
    }

    $logoImg = $logoPath ? "<img class='logo' src='{$logoPath}' alt='Logo'>" : '';
    $logoDisplay = $logoImg ?: '✨';
    $faviconLink = $favicon ? "<link rel='icon' href='{$favicon}'>" : '';

    $templateContent = build_template_content($template, $data, $templates, $buttons);

    return <<<HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    {$faviconLink}
    <style>
        :root{color-scheme:dark;--bg-primary:#0a0e1a;--bg-secondary:#0f172a;--panel-bg:rgba(15,23,42,0.6);--border:rgba(148,163,184,0.1);--accent-primary:{$primary};--accent-secondary:{$secondary};--text-primary:#f1f5f9;--text-muted:#94a3b8;--glow-primary:rgba({$r1},{$g1},{$b1},0.4);font-family:'Inter',-apple-system,system-ui,sans-serif}
        *{box-sizing:border-box;margin:0;padding:0}
        @keyframes gradientShift{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-20px)}}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:0.5}}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
        body{margin:0;background:linear-gradient(135deg,#0a0e1a 0%,#0f2847 50%,#0f172a 100%);background-size:400% 400%;animation:gradientShift 15s ease infinite;color:var(--text-primary);min-height:100vh;padding:0;position:relative;overflow-x:hidden}
        body::before{content:'';position:fixed;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle at 20% 80%,rgba({$r1},{$g1},{$b1},0.15) 0%,transparent 50%),radial-gradient(circle at 80% 20%,rgba({$r2},{$g2},{$b2},0.15) 0%,transparent 50%),radial-gradient(circle at 40% 40%,rgba({$r1},{$g1},{$b1},0.1) 0%,transparent 50%);animation:float 20s ease-in-out infinite;pointer-events:none;z-index:0}
        #bg-canvas{position:fixed;top:0;left:0;width:100%;height:100%;z-index:0;pointer-events:none}
        .container{max-width:1200px;margin:0 auto;padding:0 2rem;position:relative;z-index:1}
        header{padding:2rem 0;animation:fadeInUp 0.8s ease-out}
        .nav{display:flex;align-items:center;justify-content:space-between}
        .actions{display:flex;gap:0.75rem;flex-wrap:wrap;justify-content:flex-end}
        .logo-header{display:flex;align-items:center;gap:1rem}
        .logo-icon{display:flex;align-items:center;justify-content:center;width:48px;height:48px;background:linear-gradient(135deg,var(--accent-primary),var(--accent-secondary));border-radius:14px;box-shadow:0 8px 32px var(--glow-primary);font-size:1.5rem}
        .logo-text{font-size:1.5rem;font-weight:800;background:linear-gradient(135deg,var(--accent-primary) 0%,var(--accent-secondary) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .back-link{display:inline-flex;align-items:center;gap:0.5rem;color:var(--text-muted);text-decoration:none;font-weight:500;transition:all 0.3s ease;font-size:0.95rem}
        .back-link:hover{color:var(--accent-secondary);transform:translateX(-4px)}
        main{padding:3rem 0 6rem}
        .content-card{background:var(--panel-bg);border:1px solid var(--border);border-radius:24px;padding:3rem;backdrop-filter:blur(24px);animation:fadeInUp 0.8s ease-out 0.2s both;text-align:center}
        .page-title{font-size:clamp(2.5rem,5vw,4rem);font-weight:800;margin:0 0 1rem;letter-spacing:-0.02em;background:linear-gradient(135deg,var(--accent-primary) 0%,var(--accent-secondary) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .page-subtitle{font-size:1.5rem;color:var(--text-primary);margin-bottom:1.5rem}
        .page-description{font-size:1.125rem;color:var(--text-muted);line-height:1.7;max-width:700px;margin:0 auto}
        .hero-badge{display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;background:rgba({$r1},{$g1},{$b1},0.1);border:1px solid rgba({$r1},{$g1},{$b1},0.3);border-radius:999px;font-size:0.875rem;font-weight:600;color:var(--accent-secondary);margin-bottom:2rem}
        .hero-badge-dot{width:8px;height:8px;background:var(--accent-secondary);border-radius:50%;animation:pulse 2s ease-in-out infinite}
        .features-section{margin-top:4rem;padding-top:4rem;border-top:1px solid var(--border)}
        .features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:2rem;margin-top:2rem}
        .feature-card{background:var(--panel-bg);border:1px solid var(--border);border-radius:20px;padding:2rem;backdrop-filter:blur(24px);transition:all 0.3s ease}
        .feature-card:hover{transform:translateY(-5px);border-color:rgba({$r1},{$g1},{$b1},0.3);box-shadow:0 20px 60px rgba({$r1},{$g1},{$b1},0.15)}
        .feature-icon{width:48px;height:48px;background:rgba({$r1},{$g1},{$b1},0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;border:1px solid rgba({$r1},{$g1},{$b1},0.2);font-size:1.5rem}
        .feature-title{font-size:1.25rem;font-weight:700;margin-bottom:0.5rem;color:var(--text-primary)}
        .feature-description{font-size:0.95rem;color:var(--text-muted);line-height:1.6}
        .cta-section{margin-top:4rem;padding:3rem;background:rgba({$r1},{$g1},{$b1},0.05);border:1px solid rgba({$r1},{$g1},{$b1},0.2);border-radius:24px}
        .cta-title{font-size:2rem;font-weight:700;color:var(--text-primary);margin-bottom:2rem}
        .btn{display:inline-flex;align-items:center;gap:0.75rem;padding:1rem 2rem;background:linear-gradient(135deg,var(--accent-primary),var(--accent-secondary));color:white;border:none;border-radius:16px;font-weight:600;font-size:1rem;cursor:pointer;transition:all 0.3s;text-decoration:none}
        .btn:hover{transform:translateY(-2px);box-shadow:0 12px 48px rgba({$r1},{$g1},{$b1},0.5)}
        footer{padding:3rem 0;text-align:center;border-top:1px solid var(--border);margin-top:4rem}
        .social-links{display:flex;gap:1rem;justify-content:center;margin-bottom:1rem}
        .social-link{color:var(--text-muted);text-decoration:none;font-weight:500;font-size:0.9rem;transition:color 0.3s ease}
        .social-link:hover{color:var(--accent-secondary)}
        .footer-text{color:var(--text-muted);font-size:0.95rem}
        @media (max-width:768px){.content-card{padding:2rem 1.5rem}.features-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
    <canvas id="bg-canvas"></canvas>
    <div class="container">
        <header>
            <div class="nav">
                <div class="logo-header">
                    <div class="logo-icon">{$logoDisplay}</div>
                    <div>
                        <div class="logo-text">{$name}</div>
                        <div class="page-subtitle" style="margin:0;font-size:1rem;">{$subtitle}</div>
                    </div>
                </div>
                <div class="actions">{$buttonMarkup}</div>
            </div>
        </header>
        <main>
            {$templateContent}
        </main>
        <footer>
            <div class="social-links">{$socialMarkup}</div>
            <div class="footer-text">{$title}</div>
        </footer>
    </div>
</body>
</html>
HTML;
}

function handle_logo_upload(string $slug): string
{
    if (!isset($_FILES['logo_file']) || !is_uploaded_file($_FILES['logo_file']['tmp_name'])) {
        return '';
    }
    $targetDir = __DIR__ . '/' . $slug . '/assets';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $original = basename($_FILES['logo_file']['name']);
    $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $original);
    $targetPath = $targetDir . '/' . $safeName;
    if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $targetPath)) {
        return './assets/' . $safeName;
    }
    return '';
}

function build_logo_for_preview(): string
{
    if (!isset($_FILES['logo_file']) || !is_uploaded_file($_FILES['logo_file']['tmp_name'])) {
        return '';
    }
    $mime = mime_content_type($_FILES['logo_file']['tmp_name']);
    $data = base64_encode(file_get_contents($_FILES['logo_file']['tmp_name']));
    return "data:{$mime};base64,{$data}";
}

$message = '';
$previewHtml = '';

if ($user && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array_map(fn($value) => is_string($value) ? trim($value) : $value, $_POST);
    $template = $_POST['template'] ?? array_key_first($templates);
    if (!isset($templates[$template])) {
        $template = array_key_first($templates);
    }
    $templateDefaults = $templates[$template]['defaults'] ?? [];
    $data = array_merge($templateDefaults, $data);
    $buttons = gather_buttons();
    $social = gather_social();
    $slug = sanitize_slug($data['slug'] ?? 'site');

    $logoPath = '';
    $favicon = sanitize_text($data['favicon'] ?? '');
    $logoUrl = sanitize_text($data['logo_url'] ?? '');

    $action = $_POST['action'] ?? 'preview';

    if ($action === 'generate') {
        $targetDir = __DIR__ . '/' . $slug;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $logoPath = handle_logo_upload($slug);
        if (!$logoPath && $logoUrl) {
            $logoPath = $logoUrl;
        }
        $html = build_site_html($data, $template, $buttons, $social, $logoPath, $favicon, $templates);
        file_put_contents($targetDir . '/index.php', $html);
        add_owned_page_to_user($user['username'], $slug);
        $user = $_SESSION['user'];
        $message = "Generated site at ./{$slug}/index.php";
        $previewHtml = $html;
    } else {
        $logoPath = build_logo_for_preview();
        if (!$logoPath && $logoUrl) {
            $logoPath = $logoUrl;
        }
        $previewHtml = build_site_html($data, $template, $buttons, $social, $logoPath, $favicon, $templates);
        $message = 'Preview updated. Use "Generate Site" to write files.';
    }
} else {
    $template = array_key_first($templates);
    $data = array_merge([
        'primary_color' => '#00bcd4',
        'secondary_color' => '#8b5cf6',
        'template' => $template,
        'name' => 'NordByte Webgen',
        'title' => 'Create your site',
        'subtitle' => $templates[$template]['description'] ?? 'Dynamic website generator',
    ], $templates[$template]['defaults'] ?? []);
    $buttons = [];
    $social = [];
    $slug = '';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NordByte Webgen</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; margin: 0; background: #050815; color: #e2e8f0; }
        header.hero { padding: 28px 22px; background: linear-gradient(135deg, rgba(0,188,212,0.35), rgba(139,92,246,0.35)); border-bottom: 1px solid #1f2937; }
        h1 { margin: 0; }
        .wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; padding: 20px; align-items: start; }
        form { background: #0f172a; border: 1px solid #1f2937; border-radius: 12px; padding: 18px; }
        label { display: block; margin-top: 12px; font-weight: 600; }
        input[type=text], input[type=url], input[type=color], input[type=password], textarea, select { width: 100%; padding: 10px; margin-top: 6px; border-radius: 8px; border: 1px solid #1f2937; background: #111827; color: #e2e8f0; }
        textarea { min-height: 80px; }
        .field-group { display: flex; gap: 10px; }
        .field-group > div { flex: 1; }
        .small-note { font-size: 12px; color: #94a3b8; }
        button { margin-top: 14px; padding: 12px 16px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; }
        .primary { background: linear-gradient(135deg, #22d3ee, #8b5cf6); color: #050815; box-shadow: 0 12px 30px rgba(34,211,238,0.25); }
        .secondary { background: #1e293b; color: #fff; margin-left: 8px; border: 1px solid #334155; }
        .tertiary { background: transparent; color: #22d3ee; border: 1px solid #22d3ee; }
        .template-fields { margin-top: 12px; border: 1px dashed #334155; padding: 12px; border-radius: 10px; }
        .section-title { margin-top: 20px; border-bottom: 1px solid #1f2937; padding-bottom: 8px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; }
        .mini-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 8px; }
        .preview { background: #0f172a; border: 1px solid #1f2937; border-radius: 12px; padding: 12px; }
        iframe { width: 100%; height: 800px; background: #fff; border-radius: 10px; border: 1px solid #1f2937; }
        .message { margin: 12px 0; padding: 10px; background: rgba(34,211,238,0.15); color: #e2e8f0; border: 1px solid #22d3ee; border-radius: 8px; }
        .message a { color: #22d3ee; font-weight: 700; text-decoration: none; }
        .dynamic-group { background: #111827; padding: 10px; border-radius: 8px; margin-top: 8px; border: 1px solid #1f2937; }
        .flex { display: flex; gap: 8px; flex-wrap: wrap; }
        .auth { background: #0f172a; border: 1px solid #1f2937; border-radius: 12px; padding: 18px; }
        .links a { color: #22d3ee; margin-right: 12px; text-decoration: none; font-weight: 700; }
        .nav { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; }
        .pill { display: inline-flex; align-items: center; gap: 6px; padding: 10px 14px; border-radius: 12px; background: rgba(255,255,255,0.08); text-decoration: none; color: #e2e8f0; border: 1px solid #1f2937; }
        .pill strong { color: #22d3ee; }
    </style>
</head>
<body>
<header class="hero">
    <h1>NordByte Webgen</h1>
    <p class="small-note">Cyan/Violet themed website generator. Use the builder to preview and generate ./&lt;slug&gt;/index.php without any external backend.</p>
    <?php if ($user): ?>
        <div class="nav">
            <span class="pill">👤 <strong><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></strong> · <?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?></span>
            <a class="pill" href="/dashboard.php">📂 Dashboard</a>
            <a class="pill" href="/editor.php">🛠️ Editor</a>
            <?php if ($user['role'] === 'Admin'): ?><a class="pill" href="/admin.php">🛡️ Admin</a><?php endif; ?>
            <a class="pill" href="/logout.php">🚪 Logout</a>
        </div>
    <?php else: ?>
        <p class="small-note">Bitte einloggen oder registrieren, um den Generator zu verwenden.</p>
    <?php endif; ?>
    <?php if ($flash): ?><div class="message"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
</header>

<?php if (!$user): ?>
<div class="wrapper" style="grid-template-columns: 1fr; max-width: 520px; margin: 0 auto;">
    <div class="auth">
        <h2>Login</h2>
        <p class="small-note">Melde dich an, um den Generator nutzen zu können.</p>
        <form action="/login.php" method="post">
            <label for="login-username">Username<input type="text" id="login-username" name="username" required></label>
            <label for="login-password">Password<input type="password" id="login-password" name="password" required></label>
            <button type="submit" class="primary">Login</button>
        </form>
        <h2>Register</h2>
        <form action="/register.php" method="post">
            <label for="reg-username">Username<input type="text" id="reg-username" name="username" required></label>
            <label for="reg-password">Password (min 8 characters)<input type="password" id="reg-password" name="password" minlength="8" required></label>
            <button type="submit" class="secondary">Create Account</button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="wrapper">
    <?php if (!$user): ?>
    <div class="auth">
        <h2>Login</h2>
        <form action="/login.php" method="post">
            <label for="login-username">Username<input type="text" id="login-username" name="username" required></label>
            <label for="login-password">Password<input type="password" id="login-password" name="password" required></label>
            <button type="submit" class="primary">Login</button>
        </form>
        <h2>Register</h2>
        <form action="/register.php" method="post">
            <label for="reg-username">Username<input type="text" id="reg-username" name="username" required></label>
            <label for="reg-password">Password (min 8 characters)<input type="password" id="reg-password" name="password" minlength="8" required></label>
            <button type="submit" class="secondary">Create Account</button>
        </form>
    </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="section-title">Basics</div>
        <label>Name<input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required></label>
        <label>Title<input type="text" name="title" value="<?= htmlspecialchars($data['title'] ?? '') ?>" required></label>
        <label>Subtitle<input type="text" name="subtitle" value="<?= htmlspecialchars($data['subtitle'] ?? '') ?>"></label>
        <label>URL slug<input type="text" name="slug" value="<?= htmlspecialchars($data['slug'] ?? $slug ?? '') ?>" placeholder="my-site" required></label>

        <div class="section-title">Branding</div>
        <div class="mini-grid">
            <label>Primary color<input type="color" name="primary_color" value="<?= htmlspecialchars($data['primary_color'] ?? '#00bcd4') ?>"></label>
            <label>Secondary color<input type="color" name="secondary_color" value="<?= htmlspecialchars($data['secondary_color'] ?? '#8b5cf6') ?>"></label>
        </div>
        <label>Logo upload<input type="file" name="logo_file" accept="image/*"></label>
        <label>Logo URL (used if no upload provided)<input type="url" name="logo_url" value="<?= htmlspecialchars($data['logo_url'] ?? '') ?>" placeholder="https://webgen.quantixgroup.dev/logo.png"></label>
        <label>Favicon URL<input type="url" name="favicon" value="<?= htmlspecialchars($data['favicon'] ?? '') ?>" placeholder="https://webgen.quantixgroup.dev/favicon.ico"></label>

        <div class="section-title">Template</div>
        <label>Choose template
            <select name="template" id="template-select">
                <?php foreach ($templates as $key => $tpl): ?>
                    <option value="<?= $key ?>" <?= $template === $key ? 'selected' : '' ?>><?= $tpl['label'] ?> — <?= $tpl['description'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <?php foreach ($templates as $key => $tpl): ?>
            <div class="template-fields" data-template="<?= $key ?>" style="display: <?= $template === $key ? 'block' : 'none' ?>;">
                <div class="small-note">Template fields for <?= $tpl['label'] ?></div>
                <?php foreach ($tpl['fields'] as $field): ?>
                    <?php $value = htmlspecialchars($data[$field['name']] ?? ''); ?>
                    <?php if ($field['type'] === 'textarea'): ?>
                        <label><?= $field['label'] ?><textarea name="<?= $field['name'] ?>" placeholder="<?= $field['placeholder'] ?? '' ?>"><?= $value ?></textarea></label>
                    <?php else: ?>
                        <label><?= $field['label'] ?><input type="text" name="<?= $field['name'] ?>" value="<?= $value ?>" placeholder="<?= $field['placeholder'] ?? '' ?>"></label>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <div class="section-title">Custom buttons</div>
        <div id="button-list"></div>
        <button type="button" class="secondary" id="add-button">+ Add button</button>

        <div class="section-title">Social links</div>
        <label>Email<input type="text" name="social_email" value="<?= htmlspecialchars($_POST['social_email'] ?? '') ?>" placeholder="contact@webgen.quantixgroup.dev"></label>
        <label>Discord user URL<input type="url" name="social_discord" value="<?= htmlspecialchars($_POST['social_discord'] ?? '') ?>" placeholder="https://discord.com/users/123456789">
            <div class="small-note">Use your Discord user URL (e.g., https://discord.com/users/&lt;id&gt;). Profile &gt; Copy User ID in Discord settings.</div>
        </label>

        <div class="section-title">Actions</div>
        <button class="primary" type="submit" name="action" value="preview">✨ Preview</button>
        <button class="secondary" type="submit" name="action" value="generate">🚀 Generate Site</button>
    </form>

    <div class="preview">
        <?php if ($message): ?><div class="message"><?= htmlspecialchars($message) ?><?php if (!empty($slug)): ?> · <a href="/<?= htmlspecialchars($slug) ?>/" target="_blank" rel="noopener">Seite öffnen</a><?php endif; ?></div><?php endif; ?>
        <?php if ($previewHtml): ?>
            <iframe srcdoc="<?= htmlspecialchars($previewHtml) ?>" title="Preview"></iframe>
        <?php else: ?>
            <p class="small-note">Fill in the fields and click Preview to see the generated page.</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php if ($user): ?>
<script>
const templateSelect = document.getElementById('template-select');
const templateFields = document.querySelectorAll('.template-fields');
const buttonList = document.getElementById('button-list');
const addButton = document.getElementById('add-button');

function updateTemplateVisibility() {
    const value = templateSelect.value;
    templateFields.forEach(block => {
        block.style.display = block.dataset.template === value ? 'block' : 'none';
    });
}

templateSelect.addEventListener('change', updateTemplateVisibility);

function createButtonRow(label = '', url = '', color = '') {
    const wrapper = document.createElement('div');
    wrapper.className = 'dynamic-group';
    wrapper.innerHTML = `
        <div class="flex">
            <input type="text" name="button_label[]" placeholder="Button label" value="${label}" required>
            <input type="url" name="button_url[]" placeholder="https://link" value="${url}" required>
            <input type="color" name="button_color[]" value="${color || '#00bcd4'}" title="Button color">
            <button type="button" class="secondary remove">Remove</button>
        </div>
    `;
    wrapper.querySelector('.remove').addEventListener('click', () => wrapper.remove());
    buttonList.appendChild(wrapper);
}

addButton.addEventListener('click', () => createButtonRow());

const existingLabels = <?= json_encode($_POST['button_label'] ?? []) ?>;
const existingUrls = <?= json_encode($_POST['button_url'] ?? []) ?>;
const existingColors = <?= json_encode($_POST['button_color'] ?? []) ?>;
if (existingLabels.length) {
    existingLabels.forEach((label, idx) => {
        createButtonRow(label, existingUrls[idx] || '', existingColors[idx] || '');
    });
} else {
    createButtonRow('Get in touch', '#', '#00bcd4');
}
updateTemplateVisibility();
</script>
<?php endif; ?>
</body>
</html>
