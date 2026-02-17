<?php
// index.php
$base_url = '.';
$page_css = 'home.css';
include 'includes/header.php';
?>

<!-- Hero Section -->
<header class="hero-section">
    <div class="hero-bg-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <div class="container hero-container">
        <div class="hero-content animate-fade-up">
            <span class="badge-pill"><i class="fa-solid fa-sparkles"></i> Your Daily Sanctuary</span>
            <h1>Reflect, Grow, <br> <span class="text-gradient">Thrive.</span></h1>
            <p class="hero-subtitle">
                A private, encrypted space to document your journey, track your moods,
                and discover mindfulness through daily journaling.
            </p>

            <div class="hero-actions">
                <a href="pages/register.php" class="btn btn-primary btn-lg">
                    Start Journaling <i class="fa-solid fa-arrow-right-long"></i>
                </a>
                <a href="#features" class="btn btn-secondary btn-lg">
                    <i class="fa-solid fa-play"></i> See how it works
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">10k+</span>
                    <span class="stat-label">Active Users</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">5M+</span>
                    <span class="stat-label">Entries Written</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">4.9</span>
                    <span class="stat-label">App Rating</span>
                </div>
            </div>
        </div>

        <div class="hero-visual animate-fade-up" style="animation-delay: 0.2s;">
            <div class="floating-card glass-card">
                <div class="card-header">
                    <div class="user-info">
                        <div class="avatar"><i class="fa-solid fa-user"></i></div>
                        <div>
                            <div class="name">Sarah's Journal</div>
                            <div class="date">Today, 9:41 AM</div>
                        </div>
                    </div>
                    <div class="mood-tag"><i class="fa-solid fa-face-smile"></i> Feeling Calm</div>
                </div>
                <div class="card-body">
                    <h3>Morning Reflection</h3>
                    <p>Today I woke up feeling surprisingly refreshed. The morning sun was filtering through the
                        curtains...</p>
                    <div class="typing-indicator">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Features Section -->
<section id="features" class="features-section">
    <div class="container">
        <div class="section-header">
            <h2>Why use Her Journal?</h2>
            <p>Everything you need to maintain a healthy journaling habit.</p>
        </div>

        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card glass-card">
                <div class="feature-icon icon-purple">
                    <i class="fa-solid fa-feather-pointed"></i>
                </div>
                <h3>Daily Prompts</h3>
                <p>Never stare at a blank page again. Get thoughtful prompts every day to spark your creativity.</p>
            </div>

            <!-- Feature 2 -->
            <div class="feature-card glass-card">
                <div class="feature-icon icon-pink">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <h3>Mood Analytics</h3>
                <p>Track your emotional well-being over time with beautiful, easy-to-understand charts.</p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card glass-card">
                <div class="feature-icon icon-blue">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h3>Secure & Private</h3>
                <p>Your thoughts are yours alone. We use military-grade encryption to keep your data safe.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="container">
        <div class="cta-box glass">
            <div class="cta-content">
                <h2>Ready to start your journey?</h2>
                <p>Join thousands of others who have found clarity and peace through daily journaling.</p>
                <a href="pages/register.php" class="btn btn-primary">Create Free Account</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>