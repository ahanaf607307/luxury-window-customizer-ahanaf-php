<?php
/**
 * Template Name: Contact Us (Architectural Consultations)
 * 
 * The Template for displaying the Contact Us page for Luxury Window
 * 
 * @package Luxury_Window
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Hero Showcase -->
    <section class="page-hero-section">
        <div class="container">
            <div class="hero-badge">
                <span>📐</span>
                <span><?php esc_html_e('Architectural Consultations & Quotes', 'luxury-window'); ?></span>
            </div>
            <h1 class="page-hero-title">
                <?php esc_html_e('Connect With Our', 'luxury-window'); ?> 
                <span class="gold-text"><?php esc_html_e('Glazing Specialists', 'luxury-window'); ?></span>
            </h1>
            <p class="page-hero-desc">
                <?php esc_html_e('Planning a bespoke villa build, penthouse glazing, or require custom architectural window fabrication? Request a technical consultation or tailored estimate.', 'luxury-window'); ?>
            </p>
        </div>
    </section>

    <div class="container">
        <div class="contact-layout-grid">
            
            <!-- Contact Information Column -->
            <div class="contact-info-list">
                
                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">🏛️</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Studio & Showroom', 'luxury-window'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;">Dhaka, Bangladesh (Flagship Architectural Studio)</p>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">✉️</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Concierge & Estimates', 'luxury-window'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;">concierge@luxurywindow.com</p>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">📞</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Architectural Direct Line', 'luxury-window'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;">+880 1700-000000 (Mon – Sat: 9 AM – 8 PM)</p>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="card-icon-wrap" style="width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: 0;">🚚</div>
                    <div>
                        <h4 style="color: #ffffff; margin-bottom: 0.25rem; font-size: 1.1rem;"><?php esc_html_e('Custom Fabrication & Delivery', 'luxury-window'); ?></h4>
                        <p style="color: var(--color-text-muted); font-size: 0.92rem;"><?php esc_html_e('Reinforced wooden crating & insured transit', 'luxury-window'); ?></p>
                    </div>
                </div>

            </div>

            <!-- Interactive Contact Form Column -->
            <div class="contact-form-box">
                <h3 style="font-size: 1.5rem; margin-bottom: 0.6rem; color: #fff;"><?php esc_html_e('Request an Architectural Consultation', 'luxury-window'); ?></h3>
                <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.8rem;">
                    <?php esc_html_e('Share your project specifications and our engineering team will respond with a tailored architectural proposal within 24 hours.', 'luxury-window'); ?>
                </p>

                <form id="luxury-window-contact-form" onsubmit="event.preventDefault(); window.AhanafToast && window.AhanafToast('Thank you! Your architectural inquiry has been received. Our specialists will contact you shortly.', 'success'); this.reset();">
                    
                    <div class="form-group-wrap">
                        <label for="contact-name"><?php esc_html_e('Your Full Name / Architectural Firm', 'luxury-window'); ?> *</label>
                        <input type="text" id="contact-name" name="name" placeholder="Ahanaf Mubasshir / Architect Studio" required />
                    </div>

                    <div class="form-group-wrap">
                        <label for="contact-email"><?php esc_html_e('Corporate / Personal Email', 'luxury-window'); ?> *</label>
                        <input type="email" id="contact-email" name="email" placeholder="you@domain.com" required />
                    </div>

                    <div class="form-group-wrap">
                        <label for="contact-project-type"><?php esc_html_e('Project Scope / System Required', 'luxury-window'); ?> *</label>
                        <select id="contact-project-type" name="project_type" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); border-radius: var(--radius-sm); color: #fff; padding: 0.8rem; outline: none;">
                            <option value="residential-villa"><?php esc_html_e('Luxury Residential Villa Fenestration', 'luxury-window'); ?></option>
                            <option value="penthouse"><?php esc_html_e('Penthouse Floor-to-Ceiling Glazing', 'luxury-window'); ?></option>
                            <option value="commercial"><?php esc_html_e('Commercial Glass Facade & Skylights', 'luxury-window'); ?></option>
                            <option value="custom-studio"><?php esc_html_e('Bespoke Window Studio Configuration', 'luxury-window'); ?></option>
                        </select>
                    </div>

                    <div class="form-group-wrap">
                        <label for="contact-message"><?php esc_html_e('Project Details & Dimensions (Width, Height, Glazing Type)', 'luxury-window'); ?> *</label>
                        <textarea id="contact-message" name="message" rows="5" placeholder="<?php esc_attr_e('Describe your project requirements, preferred frame finish (Obsidian Black, Champagne Gold, etc.), and glass glazing needs...', 'luxury-window'); ?>" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.95rem; font-size: 1rem; font-weight: 700;">
                        <?php esc_html_e('Submit Architectural Inquiry', 'luxury-window'); ?> &rarr;
                    </button>
                </form>
            </div>

        </div>
    </div>
</main>

<?php
get_footer();

