<?php
// index.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Her Journal - Your Daily Sanctuary</title>
    
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Indie+Flower&display=swap" rel="stylesheet">
    
    <style>
/* --- BASE STYLES FROM SHARED.CSS --- */
:root {
  /* Premium Palette */
  --primary: #7c3aed;
  --primary-dark: #6d28d9;
  --primary-light: #a78bfa;
  --accent: #f472b6;
  --primary-glow: rgba(124, 58, 237, 0.4);
  --secondary-glow: rgba(244, 114, 182, 0.4);

  --bg-body: #fdfbfd;
  --bg-gradient: radial-gradient(circle at 10% 20%, rgb(249, 243, 255) 0%, rgb(255, 255, 255) 90%);
  --text-main: #2d2a3d;
  --text-muted: #64748b;
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

*, *::before, *::after { box-sizing: border-box; }

body {
  margin: 0;
  font-family: "Outfit", sans-serif;
  background: var(--bg-gradient);
  background-attachment: fixed;
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  min-height: 100vh;
  overflow-x: hidden; /* Prevent horizontal scroll */
}

a { text-decoration: none; color: inherit; transition: var(--transition); }
ul { list-style: none; padding: 0; margin: 0; }

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 40px;
}
@media (max-width: 768px) { .container { padding: 0 20px; } }

/* Glassmorphism Utilities */
.glass-card {
  background: rgba(255, 255, 255, 0.65);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.9);
  border-radius: 24px;
  box-shadow: 0 4px 6px -1px rgba(124, 58, 237, 0.05);
  transition: var(--transition);
}

/* Buttons */
.btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 8px;
  padding: 12px 28px; border-radius: 50px; font-weight: 600; cursor: pointer; border: none; font-size: 1rem; transition: var(--transition);
}
.btn-primary {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;
  box-shadow: 0 8px 20px -4px rgba(124, 58, 237, 0.4);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -4px rgba(124, 58, 237, 0.5); filter: brightness(1.1); }

/* --- HOME.CSS STYLES --- */

/* Navigation */
.landing-nav {
  position: absolute; top: 0; left: 0; width: 100%; padding: 24px 0; z-index: 50;
  background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
}
.nav-container { display: flex; justify-content: space-between; align-items: center; }

.nav-logo {
  display: flex; align-items: center; gap: 14px; text-decoration: none; color: #1a1a1a;
  font-weight: 700; font-size: 1.5rem; font-family: 'Playfair Display', serif; transition: opacity 0.2s;
}
.nav-logo:hover { opacity: 0.8; }

.logo-icon {
  width: 42px; height: 42px; background: linear-gradient(135deg, #7c3aed, #db2777); border-radius: 12px;
  display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem;
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
}

.nav-actions { display: flex; align-items: center; gap: 30px; }
.nav-link { color: #4b5563; text-decoration: none; font-weight: 600; font-size: 1rem; transition: color 0.2s; position: relative; }
.nav-link:hover { color: var(--primary); }
.nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: var(--primary); transition: width 0.3s; }
.nav-link:hover::after { width: 100%; }

.btn-sm { padding: 10px 24px; font-size: 0.95rem; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.15); }

/* Hero Section */
.hero-section {
  position: relative; padding: 180px 0 120px; overflow: hidden;
  background: radial-gradient(circle at top right, #fdf4ff, #fff, #f5f3ff);
  min-height: 90vh; display: flex; align-items: center;
}
.hero-bg-blobs { position: absolute; inset: 0; z-index: 0; pointer-events: none; }
.blob { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.5; animation: floatY 12s ease-in-out infinite; }
.blob-1 { top: -10%; right: -10%; width: 700px; height: 700px; background: #e9d5ff; }
.blob-2 { bottom: 10%; left: -5%; width: 500px; height: 500px; background: #fbcfe8; animation-delay: -2s; }
.blob-3 { top: 40%; left: 50%; width: 400px; height: 400px; background: #cffafe; animation-delay: -5s; transform: translate(-50%, -50%); opacity: 0.3; }

.hero-container { display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 80px; position: relative; z-index: 1; align-items: center; }

.badge-pill {
  display: inline-flex; align-items: center; gap: 10px; padding: 10px 20px;
  background: white; border: 1px solid rgba(124, 58, 237, 0.15); border-radius: 50px;
  font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 32px;
  box-shadow: 0 4px 20px rgba(124, 58, 237, 0.08); transition: all 0.3s;
}
.badge-pill:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(124, 58, 237, 0.12); }
.pulse-dot { width: 8px; height: 8px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 0 rgba(74, 222, 128, 0.4); animation: pulse 2s infinite; }

.hero-content h1 {
  font-family: "Playfair Display", serif; font-size: 5rem; line-height: 1.08; font-weight: 800;
  color: #111827; letter-spacing: -0.03em; margin-bottom: 28px;
}
.text-gradient_v2 {
  background: linear-gradient(135deg, #7c3aed 0%, #db2777 100%);
  -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;
}
.hero-subtitle { font-size: 1.3rem; color: #6b7280; line-height: 1.75; margin-bottom: 48px; max-width: 560px; font-weight: 400; }

.hero-actions { display: flex; align-items: center; gap: 32px; flex-wrap: wrap; margin-bottom: 16px; }
.btn-lg {
  padding: 16px 36px; font-size: 1.05rem; border-radius: 50px; font-weight: 600;
  display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-lg.glow { box-shadow: 0 8px 24px var(--primary-glow); }
.btn-lg.glow:hover { box-shadow: 0 12px 32px var(--primary-glow), 0 6px 16px rgba(0,0,0,0.1); transform: translateY(-3px); }

.avatar-stack { display: flex; }
.avatar-stack img { width: 44px; height: 44px; border-radius: 50%; border: 3px solid white; margin-left: -14px; object-fit: cover; }
.avatar-stack img:first-child { margin-left: 0; }
.avatar-count { width: 44px; height: 44px; border-radius: 50%; border: 3px solid white; background: #f3f4f6; color: #6b7280; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-left: -14px; }
.trusted-avatars span { display: block; font-size: 0.85rem; color: #9ca3af; margin-top: 6px; margin-left: 8px; font-weight: 500; }

/* 3D Visual */
.hero-visual-3d { position: relative; height: 500px; perspective: 1500px; display: flex; align-items: center; justify-content: center; }
.card-stack { position: relative; width: 400px; height: 500px; transform-style: preserve-3d; transform: rotateY(-12deg) rotateX(6deg); transition: transform 0.5s ease; }
.hero-visual-3d:hover .card-stack { transform: rotateY(0deg) rotateX(0deg); }
.card-layer { position: absolute; inset: 0; border-radius: 28px; background: white; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
.layer-1 { transform: translateZ(-40px) translateX(25px) rotate(-4deg); background: #fdf2f8; width: 95%; height: 95%; top: 2.5%; left: 2.5%; }
.layer-2 { transform: translateZ(-20px) translateX(12px) rotate(-2deg); background: #f5f3ff; width: 98%; height: 98%; top: 1%; left: 1%; }
.layer-main {
  transform: translateZ(0); background: rgba(255,255,255,0.95); backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,0.8); padding: 36px; display: flex; flex-direction: column;
}

.journal-entry-preview h3 { font-family: 'Playfair Display', serif; font-size: 2rem; margin: 20px 0 12px; color: #1a1a1a; }
.handwritten { font-family: 'Indie Flower', cursive, sans-serif; font-size: 1.15rem; color: #4b5563; line-height: 1.6; margin-bottom: 24px; }
.entry-media-preview img { width: 100%; height: 200px; object-fit: cover; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.preview-header { display: flex; justify-content: space-between; margin-bottom: 5px; }
.date-badge, .mood-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
.date-badge { background: #f3f4f6; color: #6b7280; }
.mood-badge { background: #dcfce7; color: #15803d; }

.floating-element {
  position: absolute; width: 56px; height: 56px; background: white; border-radius: 50%;
  box-shadow: 0 12px 24px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center;
  font-size: 1.6rem; color: var(--primary); animation: floatY 6s ease-in-out infinite; z-index: 10;
}
.float-1 { top: -25px; right: -25px; color: #ec4899; }
.float-2 { bottom: 45px; left: -35px; color: #8b5cf6; animation-delay: -2s; }
.float-3 { top: 55%; right: -45px; color: #f59e0b; animation-delay: -4s; font-size: 1.3rem; }

/* Stats Ticker */
.stats-ticker-wrapper { background: white; border-bottom: 1px solid rgba(0,0,0,0.05); padding: 40px 0; }
.stats-container { display: flex; justify-content: space-around; align-items: center; }
.stat-box { text-align: center; }
.stat-box h3 { font-size: 2.2rem; font-weight: 800; color: #111827; margin-bottom: 6px; }
.stat-box p { color: #6b7280; font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1.5px; }
.divider { height: 50px; width: 1px; background: #e5e7eb; }

/* Features V2 */
.features-section { padding: 120px 0; background: #fafafa; }
.section-header-center { text-align: center; max-width: 640px; margin: 0 auto 70px; }
.section-tag { display: inline-block; font-size: 0.85rem; font-weight: 700; color: var(--primary); letter-spacing: 2px; margin-bottom: 16px; }
.section-header-center h2 { font-family: 'Playfair Display', serif; font-size: 3.2rem; color: #111827; line-height: 1.1; }

.features-grid-v2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px; }
.feature-card-v2 { padding: 48px 36px; border-radius: 24px; background: white; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 1px solid rgba(0,0,0,0.03); }
.feature-card-v2:hover { transform: translateY(-12px); box-shadow: 0 24px 48px rgba(0,0,0,0.06); }
.icon-circle { width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: white; margin-bottom: 24px; box-shadow: 0 10px 20px -5px rgba(0,0,0,0.15); }
.gradient-purple { background: linear-gradient(135deg, #a78bfa, #7c3aed); }
.gradient-pink { background: linear-gradient(135deg, #f472b6, #db2777); }
.gradient-blue { background: linear-gradient(135deg, #60a5fa, #2563eb); }
.gradient-orange { background: linear-gradient(135deg, #fbbf24, #d97706); }
.feature-card-v2 h3 { font-size: 1.35rem; font-weight: 700; margin-bottom: 12px; color: #1f2937; }
.feature-card-v2 p { color: #6b7280; line-height: 1.7; font-size: 1rem; }

/* Demo & CTA */
.demo-section { padding: 140px 0; overflow: hidden; background: white; }
.demo-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.demo-text h2 { font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 24px; color: #111827; }
.demo-text p { font-size: 1.15rem; color: #4b5563; line-height: 1.7; }
.check-list { list-style: none; padding: 0; margin-top: 36px; }
.check-list li { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; font-size: 1.1rem; color: #374151; font-weight: 500; }
.check-list i { color: #10b981; font-size: 1.25rem; }
.demo-visual img { width: 100%; border-radius: 24px; box-shadow: 0 30px 60px rgba(0,0,0,0.12); transform: perspective(1000px) rotateY(-5deg) rotateX(2deg); transition: transform 0.6s ease; }
.demo-visual:hover img { transform: perspective(1000px) rotateY(0deg) rotateX(0deg); }

.cta-section-v2 { padding: 40px 0 120px; }
.cta-card-premium {
  background: linear-gradient(120deg, #4f46e5, #7c3aed, #db2777);
  border-radius: 48px; padding: 100px 40px; text-align: center; color: white;
  position: relative; overflow: hidden; box-shadow: 0 30px 60px -15px rgba(124, 58, 237, 0.4);
}
.cta-content-center { position: relative; z-index: 2; max-width: 640px; margin: 0 auto; }
.cta-content-center h2 { font-family: 'Playfair Display', serif; font-size: 4rem; margin-bottom: 24px; line-height: 1.1; }
.cta-content-center p { font-size: 1.3rem; opacity: 0.95; margin-bottom: 48px; }
.cta-buttons { display: flex; gap: 24px; justify-content: center; }
.btn-light { background: white; color: #4f46e5; font-weight: 700; border: none; padding: 18px 40px; border-radius: 50px; font-size: 1.1rem; transition: var(--transition); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
.btn-light:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
.btn-outline-light { border: 2px solid rgba(255,255,255,0.4); color: white; background: transparent; font-weight: 600; padding: 16px 36px; border-radius: 50px; font-size: 1.1rem; transition: var(--transition); }
.btn-outline-light:hover { background: white; color: #4f46e5; border-color: white; }

.cta-bg-shapes {
  position: absolute; top: 0; left: 0; width: 100%; height: 100%;
  background-image: radial-gradient(circle at 10% 10%, rgba(255,255,255,0.15) 0%, transparent 25%),
                    radial-gradient(circle at 90% 90%, rgba(255,255,255,0.15) 0%, transparent 25%);
}

/* Footer (Simple Internal for Landing) */
.site-footer { margin-top: 0; padding: 60px 0 30px; background: white; border-top: 1px solid rgba(0,0,0,0.05); }

/* Animations */
@keyframes floatY { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
@keyframes pulse { 0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); } 70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(74, 222, 128, 0); } 100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); } }
.animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
.delay-1 { animation-delay: 0.2s; } .delay-2 { animation-delay: 0.4s; } .delay-3 { animation-delay: 0.6s; }
.animate-fade-in { animation: fadeIn 1s ease-out forwards; opacity: 0; }
@keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { to { opacity: 1; } }

/* Mobile */
@media (max-width: 1024px) {
  .hero-container, .demo-layout, .stats-container, .cta-buttons { grid-template-columns: 1fr; flex-direction: column; text-align: center; }
  .hero-content, .cta-content-center { margin: 0 auto; }
  .hero-actions { justify-content: center; }
  .hero-subtitle { margin: 0 auto 40px; }
  .hero-visual-3d { margin-top: 80px; height: 450px; }
  .stat-box { margin-bottom: 30px; } .divider { width: 100px; height: 1px; margin: 10px auto; }
  .hero-content h1 { font-size: 3.5rem; }
  .cta-content-center h2 { font-size: 2.8rem; }
}
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="landing-nav">
        <div class="container nav-container">
            <a href="index.php" class="nav-logo">
                <div class="logo-icon"><i class="fa-solid fa-feather-pointed"></i></div>
                <span>Her Journal</span>
            </a>
            <div class="nav-actions">
                <a href="pages/login.php" class="nav-link">Log In</a>
                <a href="pages/register.php" class="btn btn-primary btn-sm">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-bg-blobs">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>

        <div class="container hero-container">
            <div class="hero-content">
                <span class="badge-pill">
                    <span class="pulse-dot"></span> New: Mood Analytics
                </span>
                <h1 class="animate-fade-up">
                    A Sanctuary for <br>
                    <span class="text-gradient_v2">Your Story.</span>
                </h1>
                <p class="hero-subtitle animate-fade-up delay-1">
                    More than just a diary. A beautiful, private space to document your life,
                    track your emotions, and discover yourself through the power of writing.
                </p>

                <div class="hero-actions animate-fade-up delay-2">
                    <a href="pages/register.php" class="btn btn-primary btn-lg glow">
                        Start Your Journal <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                    <div class="trusted-avatars">
                        <div class="avatar-stack">
                            <img src="https://i.pravatar.cc/100?img=1" alt="User">
                            <img src="https://i.pravatar.cc/100?img=5" alt="User">
                            <img src="https://i.pravatar.cc/100?img=8" alt="User">
                            <div class="avatar-count">+2k</div>
                        </div>
                        <span>Joined this month</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual-3d animate-fade-in delay-3">
                <div class="card-stack">
                    <div class="card-layer layer-1"></div>
                    <div class="card-layer layer-2"></div>
                    <div class="card-layer layer-main glass-card">
                        <div class="journal-entry-preview">
                            <div class="preview-header">
                                <span class="date-badge">18 FEB</span>
                                <span class="mood-badge"><i class="fa-solid fa-face-smile-beam"></i> Grateful</span>
                            </div>
                            <h3>The little things...</h3>
                            <p class="handwritten">Today I realized how important it is to slow down. The coffee tasted better, the sun felt warmer...</p>
                            <div class="entry-media-preview">
                                <img src="https://images.unsplash.com/photo-1499750310159-5254f4cc1555?auto=format&fit=crop&q=80&w=600" alt="Journal Photo">
                            </div>
                        </div>
                    </div>
                    <div class="floating-element float-1"><i class="fa-solid fa-heart"></i></div>
                    <div class="floating-element float-2"><i class="fa-solid fa-music"></i></div>
                    <div class="floating-element float-3"><i class="fa-solid fa-star"></i></div>
                </div>
            </div>
        </div>
    </header>

    <!-- Stats Ticker -->
    <div class="stats-ticker-wrapper">
        <div class="container stats-container">
            <div class="stat-box">
                <h3>100%</h3>
                <p>Private & Secure</p>
            </div>
            <div class="divider"></div>
            <div class="stat-box">
                <h3>50k+</h3>
                <p>Entries Written</p>
            </div>
            <div class="divider"></div>
            <div class="stat-box">
                <h3>4.9/5</h3>
                <p>User Rating</p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header-center">
                <span class="section-tag">WHY HER JOURNAL?</span>
                <h2>Everything you need to <br>clarify your mind.</h2>
            </div>

            <div class="features-grid-v2">
                <!-- Feature 1 -->
                <div class="feature-card-v2">
                    <div class="icon-circle gradient-purple"><i class="fa-solid fa-feather-pointed"></i></div>
                    <h3>Daily Inspiration</h3>
                    <p>Thoughtful prompts delivered daily to help you overcome writer's block and explore new perspectives.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card-v2">
                    <div class="icon-circle gradient-pink"><i class="fa-solid fa-chart-line"></i></div>
                    <h3>Mood Insights</h3>
                    <p>Visualize your emotional journey. Track trends, identify triggers, and understand yourself better.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card-v2">
                    <div class="icon-circle gradient-blue"><i class="fa-solid fa-images"></i></div>
                    <h3>Rich Memories</h3>
                    <p>Don't just write. Capture the moment with integrated photo and video support within your entries.</p>
                </div>
                
                 <!-- Feature 4 -->
                <div class="feature-card-v2">
                    <div class="icon-circle gradient-orange"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3>Private & Safe</h3>
                    <p>Your thoughts are sacred. We use industry-standard encryption to ensure only you can read them.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Demo Section -->
    <section class="demo-section">
        <div class="container demo-layout">
            <div class="demo-text">
                <h2>Your mood, visualized.</h2>
                <p>See your month in pixels. Our beautiful calendar view gives you a bird's-eye view of your emotional wellbeing.</p>
                <ul class="check-list">
                    <li><i class="fa-solid fa-circle-check"></i> Color-coded mood tracking</li>
                    <li><i class="fa-solid fa-circle-check"></i> Monthly & Weekly overviews</li>
                    <li><i class="fa-solid fa-circle-check"></i> Exportable reports</li>
                </ul>
            </div>
            <div class="demo-visual">
                <img src="https://cdn.dribbble.com/users/1615584/screenshots/15710065/media/8939df05b530282b04f767851a704944.jpg" alt="Analytics Dashboard UI">
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section-v2">
        <div class="container">
            <div class="cta-card-premium">
                <div class="cta-content-center">
                    <h2>Start your journey today.</h2>
                    <p>Join a community of mindful writers. It's free to start.</p>
                    <div class="cta-buttons">
                        <a href="pages/register.php" class="btn btn-light btn-lg">Create Free Account</a>
                        <a href="pages/login.php" class="btn btn-outline-light btn-lg">Log In</a>
                    </div>
                </div>
                <div class="cta-bg-shapes"></div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>