<?php
/**
 * Template Name: Contact Us (যোগাযোগ)
 * 
 * The Template for displaying the Contact Us page
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Hero Showcase -->
    <section class="page-hero-section">
        <div class="container">
            <div class="hero-badge">
                <span>💬</span>
                <span><?php esc_html_e('We would love to hear from you', 'blog-post-ahanaf'); ?></span>
            </div>
            <h1 class="page-hero-title">
                <?php esc_html_e('Let’s Start a', 'blog-post-ahanaf'); ?> 
                <span class="gold-text"><?php esc_html_e('Conversation', 'blog-post-ahanaf'); ?></span>
            </h1>
            <p class="page-hero-desc">
                <?php esc_html_e('Have a question, collaboration proposal, or video vlog suggestion? Drop us a line anytime!', 'blog-post-ahanaf'); ?>
            </p>
        </div>
    </section>

    <div class="container">
        <div class="contact-layout-grid">
            
            <!-- Contact Information Column -->
            <div class="contact-info-list">
                
                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">📍</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Location & HQ', 'blog-post-ahanaf'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;">Dhaka, Bangladesh</p>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">✉️</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Email Inquiries', 'blog-post-ahanaf'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;">hello@vlogpulse.com</p>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">⚡</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Collaboration & Sponsorships', 'blog-post-ahanaf'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;">partnerships@vlogpulse.com</p>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">🕒</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Response Time', 'blog-post-ahanaf'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;"><?php esc_html_e('Usually responds within 24 hours', 'blog-post-ahanaf'); ?></p>
                    </div>
                </div>

            </div>

            <!-- Interactive Contact Form Column -->
            <div class="contact-form-box">
                <h3 style="font-size: 1.5rem; margin-bottom: 0.6rem; color: #fff;"><?php esc_html_e('Send a Message', 'blog-post-ahanaf'); ?></h3>
                <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.8rem;">
                    <?php esc_html_e('Fill out the form below and our team will get back to you promptly.', 'blog-post-ahanaf'); ?>
                </p>

                <form id="vlogpulse-contact-form" onsubmit="event.preventDefault(); window.AhanafToast && window.AhanafToast('Thank you! Your message has been sent successfully.', 'success'); this.reset();">
                    
                    <div class="form-group-wrap">
                        <label for="contact-name"><?php esc_html_e('Your Full Name', 'blog-post-ahanaf'); ?> *</label>
                        <input type="text" id="contact-name" name="name" placeholder="Ahanaf Mubasshir" required />
                    </div>

                    <div class="form-group-wrap">
                        <label for="contact-email"><?php esc_html_e('Email Address', 'blog-post-ahanaf'); ?> *</label>
                        <input type="email" id="contact-email" name="email" placeholder="you@example.com" required />
                    </div>

                    <div class="form-group-wrap">
                        <label for="contact-subject"><?php esc_html_e('Subject', 'blog-post-ahanaf'); ?> *</label>
                        <input type="text" id="contact-subject" name="subject" placeholder="Video Vlog Suggestion / Collaboration" required />
                    </div>

                    <div class="form-group-wrap">
                        <label for="contact-message"><?php esc_html_e('Your Message', 'blog-post-ahanaf'); ?> *</label>
                        <textarea id="contact-message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem; font-size: 1rem;">
                        <?php esc_html_e('Send Message Now', 'blog-post-ahanaf'); ?> &rarr;
                    </button>
                </form>
            </div>

        </div>
    </div>
</main>

<?php
get_footer();
