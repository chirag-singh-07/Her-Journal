<?php
$base_url = '..';
$page_css = 'css/about.css';
include '../includes/header.php';
?>

<section class="about-section">
    <div class="container">
        <div class="glass-card about-card">
            <h1>About Her Journal</h1>
            <p class="intro-text">
                Her Journal is your personal safe space to write, reflect, and track
                your journey. Whether you want to write daily thoughts, track your mood,
                or freely express your feelings — this app is built to support your
                mental well-being.
            </p>

            <div class="about-features">
                <h2>✨ Features</h2>
                <ul>
                    <li>📓 <strong>Daily Journaling</strong> – Capture your everyday moments</li>
                    <li>😊 <strong>Mood Tracking</strong> – Understand your emotions better</li>
                    <li>🔒 <strong>Private & Secure</strong> – Your journal belongs only to you</li>
                    <li>💭 <strong>Thought Space</strong> – Write without judgment</li>
                </ul>
            </div>

            <h2>💡 Why Her Journal?</h2>
            <p>
                Life can be overwhelming sometimes. Writing down your thoughts not only
                helps in self-reflection but also improves clarity, emotional balance,
                and happiness. Her Journal is designed to be simple, safe, and easy to
                use.
            </p>

            <h2>🌸 Our Mission</h2>
            <p>
                Our mission is to empower individuals—especially women—to find strength
                through self-expression. By making journaling accessible and private, we
                hope to create a world where emotional well-being is prioritized and
                nurtured every single day.
            </p>

            <h2>📖 The Story Behind Her Journal</h2>
            <p>
                Her Journal was born out of a simple idea:
                <em>everyone deserves a safe space for their thoughts.</em>
                What started as a personal passion for journaling grew into a platform
                where thousands can now express themselves without fear of judgment. We
                believe in the healing power of words, and our journey is dedicated to
                helping you discover yours.
            </p>

            <div class="cta-box glass" style="margin-top:40px;padding:30px;border-radius:16px;text-align:center">
                <h3>✨ Ready to Begin?</h3>
                <p>
                    Take a deep breath, open your heart, and start writing your story
                    today.
                </p>
                <a href="register.php" class="btn btn-primary" style="margin-top:16px"><i
                        class="fa-solid fa-arrow-right icon-left"></i>Get Started</a>
            </div>
        </div>
    </div>
</section>

<style>
    .about-section {
        padding: 60px 0;
    }

    .about-card {
        padding: 40px;
    }

    .about-card h1 {
        color: var(--primary-dark);
        margin-bottom: 24px;
        text-align: center;
    }

    .about-card h2 {
        color: var(--primary);
        margin: 32px 0 16px;
        font-size: 1.5rem;
    }

    .intro-text {
        font-size: 1.15rem;
        line-height: 1.8;
        color: var(--text-main);
        text-align: center;
        max-width: 800px;
        margin: 0 auto 40px;
    }

    .about-features ul {
        list-style: none;
        padding: 0;
    }

    .about-features li {
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .about-features li:last-child {
        border-bottom: none;
    }

    @media(max-width: 768px) {
        .about-card {
            padding: 20px;
        }
    }
</style>

<?php include '../includes/footer.php'; ?>