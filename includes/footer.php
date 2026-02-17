<?php
// includes/footer.php
?>
  <footer class="site-footer">
    <div class="footer-bg-blob"></div>
    <div class="container relative-z">
      
      <!-- Top Section -->
      <div class="footer-top">
        <div class="footer-brand">
          <a href="#" class="footer-logo">
            <div class="logo-box"><i class="fa-solid fa-feather-pointed"></i></div>
            <span>Her Journal</span>
          </a>
          <p class="footer-desc">
            A safe, encrypted space for your thoughts, dreams, and personal growth. 
            Join our community of mindfulness and start your journey today.
          </p>
          <div class="social-links">
            <a href="#" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="social-btn" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            <a href="#" class="social-btn" aria-label="Pinterest"><i class="fa-brands fa-pinterest"></i></a>
            <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
          </div>
        </div>

        <div class="footer-nav">
          <div class="nav-column">
            <h4>Platform</h4>
            <ul>
              <li><a href="#">How it Works</a></li>
              <li><a href="#">Features</a></li>
              <li><a href="#">Pricing</a></li>
              <li><a href="#">Testimonials</a></li>
            </ul>
          </div>
          <div class="nav-column">
            <h4>Company</h4>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
          <div class="nav-column">
            <h4>Support</h4>
            <ul>
              <li><a href="#">Help Center</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Terms of Service</a></li>
              <li><a href="#">Community Guidelines</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Newsletter Section -->
      <div class="footer-newsletter glass-panel">
        <div class="newsletter-content">
          <h4>Subscribe to our newsletter</h4>
          <p>Get weekly prompts, wellness tips, and exclusive features updates.</p>
        </div>
        <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Subscribed!');">
          <div class="input-group-premium">
            <i class="fa-regular fa-envelope input-icon"></i>
            <input type="email" placeholder="Enter your email address" required />
            <button type="submit" class="btn-subscribe">Subscribe</button>
          </div>
        </form>
      </div>
      
      <!-- Bottom Section -->
      <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Her Journal. All rights reserved.</p>
        <div class="footer-signature">
          Made with <i class="fa-solid fa-heart"></i> for better mental health.
        </div>
      </div>
    </div>
  </footer>

  <style>
    .site-footer {
      position: relative;
      background: #0f172a;
      color: #e2e8f0;
      padding: 100px 0 40px;
      overflow: hidden;
      font-family: 'Outfit', sans-serif;
    }

    .footer-bg-blob {
      position: absolute;
      top: -50%;
      right: -20%;
      width: 800px;
      height: 800px;
      background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, transparent 70%);
      filter: blur(80px);
      z-index: 0;
      animation: pulseBlob 10s infinite alternate;
    }

    @keyframes pulseBlob {
      from { transform: scale(1); opacity: 0.5; }
      to { transform: scale(1.1); opacity: 0.8; }
    }

    .relative-z { position: relative; z-index: 1; }

    .footer-top {
      display: grid;
      grid-template-columns: 1.2fr 2fr;
      gap: 80px;
      margin-bottom: 80px;
    }

    /* Brand Column */
    .footer-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      margin-bottom: 24px;
    }

    .logo-box {
      width: 44px;
      height: 44px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
    }

    .footer-logo span {
      font-size: 1.5rem;
      font-weight: 700;
      color: white;
      font-family: 'Playfair Display', serif;
    }

    .footer-desc {
      color: #94a3b8;
      line-height: 1.7;
      margin-bottom: 32px;
      max-width: 360px;
      font-size: 1.05rem;
    }

    .social-links {
      display: flex;
      gap: 16px;
    }

    .social-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #cbd5e1;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .social-btn:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-4px) rotate(8deg);
      border-color: var(--primary);
      box-shadow: 0 10px 20px -5px rgba(124, 58, 237, 0.4);
    }

    /* Navigation Columns */
    .footer-nav {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 40px;
    }

    .nav-column h4 {
      color: white;
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 24px;
      font-family: 'Playfair Display', serif;
    }

    .nav-column ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .nav-column ul li {
      margin-bottom: 14px;
    }

    .nav-column a {
      color: #94a3b8;
      text-decoration: none;
      transition: all 0.2s;
      font-size: 0.95rem;
      position: relative;
      display: inline-block;
    }

    .nav-column a:hover {
      color: var(--primary-light);
      transform: translateX(4px);
    }

    /* Newsletter Card */
    .glass-panel {
      background: rgba(255, 255, 255, 0.03);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 24px;
      padding: 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
      margin-bottom: 60px;
      position: relative;
      overflow: hidden;
    }

    .glass-panel::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(to bottom, var(--primary), var(--accent));
    }

    .newsletter-content h4 {
      font-size: 1.5rem;
      color: white;
      margin-bottom: 8px;
    }

    .newsletter-content p {
      color: #94a3b8;
    }

    .newsletter-form {
      flex: 1;
      max-width: 450px;
    }

    .input-group-premium {
      position: relative;
      background: rgba(0, 0, 0, 0.2);
      border-radius: 50px;
      padding: 6px;
      display: flex;
      align-items: center;
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: border-color 0.3s;
    }

    .input-group-premium:focus-within {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
    }

    .input-icon {
      position: absolute;
      left: 20px;
      color: #64748b;
    }

    .input-group-premium input {
      width: 100%;
      background: transparent;
      border: none;
      color: white;
      padding: 12px 12px 12px 40px;
      outline: none;
      font-size: 0.95rem;
    }

    .btn-subscribe {
      background: var(--primary);
      color: white;
      border: none;
      padding: 10px 24px;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-subscribe:hover {
      background: var(--primary-dark);
      box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* Footer Bottom */
    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      padding-top: 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #64748b;
      font-size: 0.9rem;
    }

    .footer-signature i {
      color: #f43f5e;
      animation: beat 1.5s infinite;
    }

    @keyframes beat {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.2); }
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .footer-top {
        grid-template-columns: 1fr;
        gap: 60px;
      }
      .footer-nav {
        gap: 30px;
      }
      .glass-panel {
        flex-direction: column;
        text-align: center;
        padding: 30px;
      }
      .newsletter-form {
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .footer-nav {
        grid-template-columns: 1fr;
        text-align: center;
      }
      .footer-brand {
        text-align: center;
        align-items: center;
        display: flex;
        flex-direction: column;
      }
      .footer-logo {
        justify-content: center;
      }
      .footer-bottom {
        flex-direction: column;
        gap: 20px;
        text-align: center;
      }
    }
  </style>
</body>
</html>
