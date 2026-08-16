<?php
/**
 * Template Name: Custom Window Studio (গ্লাস ও ফ্রেম উইন্ডো বিল্ডার)
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();
?>

<main id="primary" class="site-main window-studio-page">
    <div class="container" id="vlogpulse-window-studio" style="max-width: 1320px; margin: 3rem auto 6rem;">
        
        <!-- Studio Header (Perfect Center Alignment) -->
        <div class="studio-top-header" style="text-align: center; max-width: 900px; margin: 0 auto 3.5rem;">
            <div class="hero-badge" style="margin: 0 auto 1rem; display: inline-flex;">
                <span>✨</span>
                <span><?php esc_html_e('Architectural Window Studio', 'blog-post-ahanaf'); ?></span>
            </div>
            <h1 class="hero-title" style="text-align: center; margin: 0 auto 0.8rem; font-size: 2.6rem; font-weight: 800; line-height: 1.25;">
                <?php esc_html_e('Design Your Bespoke', 'blog-post-ahanaf'); ?> 
                <span class="gold-text"><?php esc_html_e('Glass & Frame Window', 'blog-post-ahanaf'); ?></span>
            </h1>
            <p class="hero-subtitle" style="text-align: center; max-width: 650px; margin: 0 auto; font-size: 1.05rem; line-height: 1.7;">
                <?php esc_html_e('Select your custom frame finishes, high-performance glazing, dimensions, and luxury hardware. Watch live updates and order directly.', 'blog-post-ahanaf'); ?>
            </p>
        </div>

        <!-- Studio Split-Screen Layout -->
        <div class="window-studio-grid">
            
            <!-- =================================================================
                 LEFT PANE: Sticky Live Interactive SVG Visualizer
                 ================================================================= -->
            <div class="visualizer-col">
                <div class="visualizer-card">
                    
                    <div class="visualizer-card-header">
                        <span class="live-indicator"><span class="pulse-dot"></span> <?php esc_html_e('Live 2D Architectural Preview', 'blog-post-ahanaf'); ?></span>
                        <div class="dimension-pill-group">
                            <span class="dim-tag" id="display-dimension-w">4.0 ft</span>
                            <span class="dim-separator">×</span>
                            <span class="dim-tag" id="display-dimension-h">5.0 ft</span>
                            <span class="dim-area-tag">(<span id="display-dimension-area">20.0 sq.ft</span>)</span>
                        </div>
                    </div>

                    <!-- Interactive Sliding Action Toolbar -->
                    <!-- Interactive Action Toolbar -->
                    <div class="visualizer-action-toolbar" style="margin-bottom: 0.8rem; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.82rem; color: var(--color-text-muted);" id="mechanism-indicator-label">
                            🚪 <?php esc_html_e('Mechanism: Double Casement Doors', 'luxury-window'); ?>
                        </span>
                        <button type="button" id="toggle-mechanism-action-btn" class="slide-toggle-pill-btn" title="<?php esc_attr_e('Test Window Motion', 'luxury-window'); ?>">
                            <span class="action-btn-icon">🚪</span>
                            <span class="action-btn-text"><?php esc_html_e('Open Doors', 'luxury-window'); ?></span>
                        </button>
                    </div>

                    <!-- SVG Canvas Stage -->
                    <div class="svg-canvas-container" style="perspective: 1000px;">
                        <svg id="window-svg-stage" viewBox="0 0 360 450" preserveAspectRatio="xMidYMid meet" class="interactive-window-svg">
                            <defs>
                                <!-- Clear Glass Gradient -->
                                <linearGradient id="glassClearGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ffffff" stop-opacity="0.25" />
                                    <stop offset="35%" stop-color="#38bdf8" stop-opacity="0.15" />
                                    <stop offset="70%" stop-color="#ffffff" stop-opacity="0.05" />
                                    <stop offset="100%" stop-color="#0284c7" stop-opacity="0.2" />
                                </linearGradient>

                                <!-- Frosted Glass Gradient -->
                                <linearGradient id="glassFrostedGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ffffff" stop-opacity="0.6" />
                                    <stop offset="50%" stop-color="#e2e8f0" stop-opacity="0.45" />
                                    <stop offset="100%" stop-color="#cbd5e1" stop-opacity="0.65" />
                                </linearGradient>

                                <!-- Tinted Bronze Solar Gradient -->
                                <linearGradient id="glassBronzeGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#d97706" stop-opacity="0.45" />
                                    <stop offset="50%" stop-color="#78350f" stop-opacity="0.55" />
                                    <stop offset="100%" stop-color="#b45309" stop-opacity="0.4" />
                                </linearGradient>

                                <!-- Obsidian Reflective Gradient -->
                                <linearGradient id="glassObsidianGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#27272a" stop-opacity="0.85" />
                                    <stop offset="40%" stop-color="#52525b" stop-opacity="0.55" />
                                    <stop offset="100%" stop-color="#09090b" stop-opacity="0.9" />
                                </linearGradient>

                                <!-- Acoustic Double Glazing Gradient -->
                                <linearGradient id="glassAcousticGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.3" />
                                    <stop offset="50%" stop-color="#818cf8" stop-opacity="0.22" />
                                    <stop offset="100%" stop-color="#0284c7" stop-opacity="0.38" />
                                </linearGradient>

                                <!-- Low-E Thermal Glaze -->
                                <linearGradient id="glassLowEGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#10b981" stop-opacity="0.25" />
                                    <stop offset="50%" stop-color="#059669" stop-opacity="0.18" />
                                    <stop offset="100%" stop-color="#047857" stop-opacity="0.3" />
                                </linearGradient>

                                <!-- Ocean Blue Glaze -->
                                <linearGradient id="glassOceanBlueGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#0284c7" stop-opacity="0.4" />
                                    <stop offset="50%" stop-color="#0369a1" stop-opacity="0.35" />
                                    <stop offset="100%" stop-color="#075985" stop-opacity="0.45" />
                                </linearGradient>
                            </defs>

                            <!-- Background Wall / Sky View Behind Glass -->
                            <rect id="svg-backdrop-view" x="14" y="14" width="332" height="422" rx="4" fill="#070a13" />

                            <!-- Left Window Sash Unit (Interactive Door Swing / Slide) -->
                            <g id="svg-sash-left" style="transition: all 0.7s cubic-bezier(0.25, 1, 0.5, 1); transform-origin: 20px center;">
                                <!-- Left Glass Pane -->
                                <rect id="svg-glass-left" x="20" y="20" width="160" height="410" rx="3" ry="3" fill="url(#glassClearGrad)" />
                                <!-- Left Frame Sash Border -->
                                <rect id="svg-frame-left-sash" x="20" y="20" width="160" height="410" rx="3" ry="3" fill="none" stroke="#18181b" stroke-width="4.5" />
                                <polygon points="32,20 95,20 55,430 20,430" fill="rgba(255,255,255,0.06)" />
                                
                                <!-- Left Sash Grids (Moves WITH sash!) -->
                                <line id="svg-grid-left-h" x1="20" y1="225" x2="180" y2="225" stroke="#18181b" stroke-width="4" style="display: none;" />
                                <line id="svg-grid-left-h2" x1="20" y1="156" x2="180" y2="156" stroke="#18181b" stroke-width="3.5" style="display: none;" />
                                <line id="svg-grid-left-h3" x1="20" y1="294" x2="180" y2="294" stroke="#18181b" stroke-width="3.5" style="display: none;" />
                                <line id="svg-grid-left-v" x1="100" y1="20" x2="100" y2="430" stroke="#18181b" stroke-width="3.5" style="display: none;" />

                                <!-- Left Handle (for Dual Handles) -->
                                <g id="svg-handle-left" style="display: block;">
                                    <rect id="svg-handle-left-rect" x="163" y="205" width="8" height="40" rx="2.5" ry="2.5" fill="#d4af37" filter="drop-shadow(0px 2px 4px rgba(0,0,0,0.7))" />
                                    <circle id="svg-handle-left-dot" cx="167" cy="213" r="2.2" fill="#070709" />
                                </g>
                            </g>

                            <!-- Right Window Sash Unit (Interactive Door Swing / Fixed) -->
                            <g id="svg-sash-right" style="transition: all 0.7s cubic-bezier(0.25, 1, 0.5, 1); transform-origin: 340px center;">
                                <!-- Right Glass Pane -->
                                <rect id="svg-glass-right" x="180" y="20" width="160" height="410" rx="3" ry="3" fill="url(#glassClearGrad)" />
                                <!-- Right Frame Sash Border -->
                                <rect id="svg-frame-right-sash" x="180" y="20" width="160" height="410" rx="3" ry="3" fill="none" stroke="#18181b" stroke-width="4.5" />
                                <polygon points="195,20 245,20 205,430 180,430" fill="rgba(255,255,255,0.03)" />
                                
                                <!-- Right Sash Grids (Moves WITH sash!) -->
                                <line id="svg-grid-right-h" x1="180" y1="225" x2="340" y2="225" stroke="#18181b" stroke-width="4" style="display: none;" />
                                <line id="svg-grid-right-h2" x1="180" y1="156" x2="340" y2="156" stroke="#18181b" stroke-width="3.5" style="display: none;" />
                                <line id="svg-grid-right-h3" x1="180" y1="294" x2="340" y2="294" stroke="#18181b" stroke-width="3.5" style="display: none;" />
                                <line id="svg-grid-right-v" x1="260" y1="20" x2="260" y2="430" stroke="#18181b" stroke-width="3.5" style="display: none;" />

                                <!-- Right Handle (for Dual Handles) -->
                                <g id="svg-handle-right" style="display: block;">
                                    <rect id="svg-handle-right-rect" x="189" y="205" width="8" height="40" rx="2.5" ry="2.5" fill="#d4af37" filter="drop-shadow(0px 2px 4px rgba(0,0,0,0.7))" />
                                    <circle id="svg-handle-right-dot" cx="193" cy="213" r="2.2" fill="#070709" />
                                </g>
                            </g>

                            <!-- 4. MASTER OUTER FRAME CASING (Drawn ON TOP of sashes to hold them cleanly inside) -->
                            <rect id="svg-frame-outer" x="10" y="10" width="340" height="430" rx="8" ry="8" fill="none" stroke="#18181b" stroke-width="18" style="pointer-events: none;" />
                            <rect id="svg-frame-bezel" x="19" y="19" width="322" height="412" rx="4" ry="4" fill="none" stroke="rgba(212,175,55,0.4)" stroke-width="1.5" style="pointer-events: none;" />
                        </svg>
                    </div>

                    <!-- Live Specs Summary Footer -->
                    <div class="visualizer-footer">
                        <div class="live-spec-item">
                            <span class="spec-label"><?php esc_html_e('Architecture:', 'luxury-window'); ?></span>
                            <span class="spec-val" id="display-model-type"><?php esc_html_e('Double Casement (Door Open/Close)', 'luxury-window'); ?></span>
                        </div>
                        <div class="live-spec-item">
                            <span class="spec-label"><?php esc_html_e('Frame Size:', 'luxury-window'); ?></span>
                            <span class="spec-val" id="display-frame-profile">2.5″ Standard Architectural</span>
                        </div>
                        <div class="live-spec-item">
                            <span class="spec-label"><?php esc_html_e('Frame Finish:', 'luxury-window'); ?></span>
                            <span class="spec-val" id="display-frame-type">Obsidian Matte Black Aluminium</span>
                        </div>
                        <div class="live-spec-item">
                            <span class="spec-label"><?php esc_html_e('Glass Glazing:', 'luxury-window'); ?></span>
                            <span class="spec-val" id="display-glass-type">Crystal Clear Tempered Glass</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- =================================================================
                 RIGHT PANE: Step-by-Step Configurator Options & Controls
                 ================================================================= -->
            <div class="controls-col">
            <?php
                    $rates = function_exists('luxury_window_get_pricing_rates') ? luxury_window_get_pricing_rates() : array(
                        'base_fee' => 50.00,
                        'frame_black' => 8.00, 'frame_gold' => 14.00, 'frame_chrome' => 10.00, 'frame_bronze' => 12.00,
                        'frame_wood' => 13.00, 'frame_navy' => 11.00, 'frame_emerald' => 11.00, 'frame_white' => 7.00,
                        'profile_slim' => 0.00, 'profile_standard' => 3.00, 'profile_heavy' => 6.00, 'profile_bold' => 10.00,
                        'glass_clear' => 12.00, 'glass_frosted' => 16.00, 'glass_bronze' => 18.00, 'glass_obsidian' => 22.00,
                        'glass_acoustic' => 28.00, 'glass_lowe' => 25.00, 'glass_ocean' => 20.00,
                        'model_casement' => 35.00, 'model_four_grid' => 45.00, 'model_six_grid' => 60.00,
                        'model_sliding' => 25.00, 'model_sliding_colonial' => 45.00, 'model_eight_grid' => 75.00,
                        'model_single' => 0.00, 'model_four_grid_fixed' => 35.00,
                        'handle_gold' => 45.00, 'handle_black' => 35.00, 'handle_chrome' => 40.00, 'handle_bronze' => 40.00,
                    );
                    ?>

                    <!-- STEP 1: Frame Finish & Material (8 Extra Colors - Dynamic Admin Rates) -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">1</span>
                            <h4><?php esc_html_e('Select Frame Material & Finish', 'luxury-window'); ?></h4>
                        </div>
                        
                        <div class="swatch-grid">
                            
                            <button type="button" class="swatch-btn frame-swatch-btn active" data-frame-id="black" data-frame-name="Obsidian Matte Black Aluminium" data-frame-color="#18181b" data-frame-accent="#27272a" data-frame-rate="<?php echo esc_attr($rates['frame_black']); ?>">
                                <span class="swatch-color" style="background: #18181b; border: 1px solid #3f3f46;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Obsidian Black', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Heavy Aluminium ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_black'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="gold" data-frame-name="Metallic Champagne Gold Aluminium" data-frame-color="#d4af37" data-frame-accent="#e5c05b" data-frame-rate="<?php echo esc_attr($rates['frame_gold']); ?>">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #d4af37, #fef08a); border: 1px solid #d4af37;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Champagne Gold', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Luxury Anodized ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_gold'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="chrome" data-frame-name="Brushed Silver Chrome Aluminium" data-frame-color="#94a3b8" data-frame-accent="#cbd5e1" data-frame-rate="<?php echo esc_attr($rates['frame_chrome']); ?>">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #94a3b8, #f1f5f9); border: 1px solid #cbd5e1;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Brushed Chrome', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Modern Finish ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_chrome'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="bronze" data-frame-name="Architectural Dark Bronze" data-frame-color="#78350f" data-frame-accent="#92400e" data-frame-rate="<?php echo esc_attr($rates['frame_bronze']); ?>">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #78350f, #451a03); border: 1px solid #92400e;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Architectural Bronze', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Classic Metal ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_bronze'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="wood" data-frame-name="Walnut Architectural Woodgrain" data-frame-color="#452c1e" data-frame-accent="#5c3d2e" data-frame-rate="<?php echo esc_attr($rates['frame_wood']); ?>">
                                <span class="swatch-color" style="background: #452c1e; border: 1px solid #78350f;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Walnut Woodgrain', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Natural Texture ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_wood'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="navy" data-frame-name="Midnight Royal Navy Blue" data-frame-color="#1e293b" data-frame-accent="#334155" data-frame-rate="<?php echo esc_attr($rates['frame_navy']); ?>">
                                <span class="swatch-color" style="background: #1e293b; border: 1px solid #38bdf8;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Royal Navy', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Deep Matte Finish ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_navy'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="emerald" data-frame-name="Forest Emerald Green" data-frame-color="#064e3b" data-frame-accent="#047857" data-frame-rate="<?php echo esc_attr($rates['frame_emerald']); ?>">
                                <span class="swatch-color" style="background: #064e3b; border: 1px solid #10b981;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Forest Emerald', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Heritage Green ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_emerald'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="white" data-frame-name="Arctic Matte White Poly" data-frame-color="#f8fafc" data-frame-accent="#e2e8f0" data-frame-rate="<?php echo esc_attr($rates['frame_white']); ?>">
                                <span class="swatch-color" style="background: #f8fafc; border: 1px solid #cbd5e1;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Arctic White', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Clean Minimalist ($%s/ft)', 'luxury-window'), esc_html(number_format($rates['frame_white'], 2))); ?></span>
                                </div>
                            </button>

                        </div>

                        <!-- Sub-Section: Frame Profile Thickness & Width Size (Dynamic Admin Rates) -->
                        <div class="frame-profile-section" style="margin-top: 1.4rem; padding-top: 1.2rem; border-top: 1px solid rgba(255,255,255,0.08);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                                <label style="font-size: 0.9rem; font-weight: 700; color: #ffffff;">
                                    📐 <?php esc_html_e('Frame Profile Thickness / Size (ফ্রেম সাইজ)', 'luxury-window'); ?>
                                </label>
                                <span id="frame-thickness-badge" style="font-size: 0.82rem; font-weight: 700; color: var(--color-gold); background: rgba(212,175,55,0.12); padding: 0.2rem 0.6rem; border-radius: 4px; border: 1px solid var(--color-gold-hover);">
                                    2.5″ Standard Architectural
                                </span>
                            </div>

                            <!-- Quick Preset Profile Buttons -->
                            <div class="frame-profile-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(135px, 1fr)); gap: 0.6rem; margin-bottom: 1rem;">
                                
                                <button type="button" class="frame-profile-btn" data-profile-id="slim" data-profile-name="1.5″ Slimline Minimalist" data-thickness="1.5" data-stroke-width="10" data-profile-cost="<?php echo esc_attr($rates['profile_slim']); ?>">
                                    <span style="font-size: 1.1rem;">🔲</span>
                                    <strong>1.5″ Slimline</strong>
                                    <small><?php printf(esc_html__('Max Glass (+$%s)', 'luxury-window'), esc_html(number_format($rates['profile_slim'], 2))); ?></small>
                                </button>

                                <button type="button" class="frame-profile-btn active" data-profile-id="standard" data-profile-name="2.5″ Standard Architectural" data-thickness="2.5" data-stroke-width="18" data-profile-cost="<?php echo esc_attr($rates['profile_standard']); ?>">
                                    <span style="font-size: 1.1rem;">🖼️</span>
                                    <strong>2.5″ Standard</strong>
                                    <small><?php printf(esc_html__('Balanced (+$%s/ft)', 'luxury-window'), esc_html(number_format($rates['profile_standard'], 2))); ?></small>
                                </button>

                                <button type="button" class="frame-profile-btn" data-profile-id="heavy" data-profile-name="3.5″ Heavy-Duty Thermal" data-thickness="3.5" data-stroke-width="26" data-profile-cost="<?php echo esc_attr($rates['profile_heavy']); ?>">
                                    <span style="font-size: 1.1rem;">🧱</span>
                                    <strong>3.5″ Heavy</strong>
                                    <small><?php printf(esc_html__('Thermal (+$%s/ft)', 'luxury-window'), esc_html(number_format($rates['profile_heavy'], 2))); ?></small>
                                </button>

                                <button type="button" class="frame-profile-btn" data-profile-id="bold" data-profile-name="4.5″ Bold Grand Estate" data-thickness="4.5" data-stroke-width="34" data-profile-cost="<?php echo esc_attr($rates['profile_bold']); ?>">
                                    <span style="font-size: 1.1rem;">🏛️</span>
                                    <strong>4.5″ Grand Bold</strong>
                                    <small><?php printf(esc_html__('Estate (+$%s/ft)', 'luxury-window'), esc_html(number_format($rates['profile_bold'], 2))); ?></small>
                                </button>

                            </div>

                            <!-- Custom Thickness Slider -->
                            <div class="dim-control-card" style="padding: 0.9rem 1.1rem;">
                                <div class="dim-header" style="margin-bottom: 0.4rem;">
                                    <label for="frame-thickness-slider" style="font-size: 0.85rem;"><?php esc_html_e('Custom Frame Thickness Slider', 'luxury-window'); ?></label>
                                    <div class="dim-input-wrap">
                                        <input type="number" id="frame-thickness-input" min="1.0" max="5.0" step="0.5" value="2.5" />
                                        <span>in</span>
                                    </div>
                                </div>
                                <input type="range" id="frame-thickness-slider" min="1.0" max="5.0" step="0.5" value="2.5" class="custom-range-slider" />
                                <div class="range-labels">
                                    <span>1.0″ (Ultra Slim)</span>
                                    <span>2.5″ (Standard)</span>
                                    <span>5.0″ (Max Bold)</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 2: Glass Glazing & Performance (7 Dynamic Admin Rates) -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">2</span>
                            <h4><?php esc_html_e('Select Glass Glazing & Performance', 'luxury-window'); ?></h4>
                        </div>

                        <div class="swatch-grid">
                            
                            <button type="button" class="swatch-btn glass-swatch-btn active" data-glass-id="clear" data-glass-name="Crystal Clear Tempered Glass" data-glass-fill="url(#glassClearGrad)" data-glass-rate="<?php echo esc_attr($rates['glass_clear']); ?>">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, rgba(255,255,255,0.7), rgba(56,189,248,0.3));"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Clear Tempered', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('High Clarity ($%s/sqft)', 'luxury-window'), esc_html(number_format($rates['glass_clear'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="frosted" data-glass-name="Frosted Privacy Glass" data-glass-fill="url(#glassFrostedGrad)" data-glass-rate="<?php echo esc_attr($rates['glass_frosted']); ?>">
                                <span class="swatch-color glass-preview-circle" style="background: rgba(226,232,240,0.8); backdrop-filter: blur(8px);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Frosted Privacy', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Diffused Light ($%s/sqft)', 'luxury-window'), esc_html(number_format($rates['glass_frosted'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="bronze" data-glass-name="Tinted Bronze Solar Glass" data-glass-fill="url(#glassBronzeGrad)" data-glass-rate="<?php echo esc_attr($rates['glass_bronze']); ?>">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #b45309, #78350f);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Tinted Bronze', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Solar Heat Block ($%s/sqft)', 'luxury-window'), esc_html(number_format($rates['glass_bronze'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="obsidian" data-glass-name="Obsidian Dark Reflective Glass" data-glass-fill="url(#glassObsidianGrad)" data-glass-rate="<?php echo esc_attr($rates['glass_obsidian']); ?>">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #27272a, #09090b);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Obsidian Reflective', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('1-Way Mirror ($%s/sqft)', 'luxury-window'), esc_html(number_format($rates['glass_obsidian'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="acoustic" data-glass-name="Acoustic Double-Glazed Glass" data-glass-fill="url(#glassAcousticGrad)" data-glass-rate="<?php echo esc_attr($rates['glass_acoustic']); ?>">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #38bdf8, #818cf8);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Acoustic Double-Glazed', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Max Soundproofing ($%s/sqft)', 'luxury-window'), esc_html(number_format($rates['glass_acoustic'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="lowe" data-glass-name="Low-E High Thermal Saver Glaze" data-glass-fill="url(#glassLowEGrad)" data-glass-rate="<?php echo esc_attr($rates['glass_lowe']); ?>">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #10b981, #047857);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Low-E Thermal Saver', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Eco Energy Shield ($%s/sqft)', 'luxury-window'), esc_html(number_format($rates['glass_lowe'], 2))); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="ocean" data-glass-name="Ocean Blue Solar Glaze" data-glass-fill="url(#glassOceanBlueGrad)" data-glass-rate="<?php echo esc_attr($rates['glass_ocean']); ?>">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #0284c7, #075985);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Ocean Blue Solar', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Coastal Glare Cut ($%s/sqft)', 'luxury-window'), esc_html(number_format($rates['glass_ocean'], 2))); ?></span>
                                </div>
                            </button>

                        </div>
                    </div>

                    <!-- STEP 3: Custom Dimensions (Width x Height) -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">3</span>
                            <h4><?php esc_html_e('Custom Dimensions (Width × Height in Feet)', 'luxury-window'); ?></h4>
                        </div>

                        <div class="dimensions-control-grid">
                            
                            <!-- Width Slider & Input -->
                            <div class="dim-control-card">
                                <div class="dim-header">
                                    <label for="window-width-slider"><?php esc_html_e('Window Width', 'luxury-window'); ?></label>
                                    <div class="dim-input-wrap">
                                        <input type="number" id="window-width-input" min="2.0" max="10.0" step="0.5" value="4.0" />
                                        <span>ft</span>
                                    </div>
                                </div>
                                <input type="range" id="window-width-slider" min="2.0" max="10.0" step="0.5" value="4.0" class="custom-range-slider" />
                                <div class="range-labels">
                                    <span>2.0 ft</span>
                                    <span>6.0 ft</span>
                                    <span>10.0 ft</span>
                                </div>
                            </div>

                            <!-- Height Slider & Input -->
                            <div class="dim-control-card">
                                <div class="dim-header">
                                    <label for="window-height-slider"><?php esc_html_e('Window Height', 'luxury-window'); ?></label>
                                    <div class="dim-input-wrap">
                                        <input type="number" id="window-height-input" min="2.0" max="8.0" step="0.5" value="5.0" />
                                        <span>ft</span>
                                    </div>
                                </div>
                                <input type="range" id="window-height-slider" min="2.0" max="8.0" step="0.5" value="5.0" class="custom-range-slider" />
                                <div class="range-labels">
                                    <span>2.0 ft</span>
                                    <span>5.0 ft</span>
                                    <span>8.0 ft</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 4: Window Mechanism & Architectural Systems (Separated Sliding vs Door Categories) -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">4</span>
                            <h4><?php esc_html_e('Choose Window Mechanism & Model', 'luxury-window'); ?></h4>
                        </div>

                        <!-- Mechanism Category Tab Nav -->
                        <div class="mechanism-category-tabs" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.6rem; margin-bottom: 1.2rem;">
                            <button type="button" class="mechanism-nav-tab active" data-target-category="door">
                                <span style="font-size: 1.2rem;">🚪</span>
                                <div style="text-align: left;">
                                    <strong style="display: block; font-size: 0.85rem; color: #fff;"><?php esc_html_e('Casement & Doors', 'luxury-window'); ?></strong>
                                    <small style="font-size: 0.72rem; color: var(--color-gold);"><?php esc_html_e('Open/Close (Dual Handles)', 'luxury-window'); ?></small>
                                </div>
                            </button>

                            <button type="button" class="mechanism-nav-tab" data-target-category="slide">
                                <span style="font-size: 1.2rem;">↔️</span>
                                <div style="text-align: left;">
                                    <strong style="display: block; font-size: 0.85rem; color: #fff;"><?php esc_html_e('Sliding Systems', 'luxury-window'); ?></strong>
                                    <small style="font-size: 0.72rem; color: #38bdf8;"><?php esc_html_e('Glide Track (No Handles)', 'luxury-window'); ?></small>
                                </div>
                            </button>

                            <button type="button" class="mechanism-nav-tab" data-target-category="fixed">
                                <span style="font-size: 1.2rem;">🔲</span>
                                <div style="text-align: left;">
                                    <strong style="display: block; font-size: 0.85rem; color: #fff;"><?php esc_html_e('Fixed Systems', 'luxury-window'); ?></strong>
                                    <small style="font-size: 0.72rem; color: #a1a1aa;"><?php esc_html_e('Panoramic Seamless View', 'luxury-window'); ?></small>
                                </div>
                            </button>
                        </div>

                        <!-- Category A: Door Open/Close Models (Dynamic Admin Rates) -->
                        <div id="category-models-door" class="mechanism-models-grid grid-style-selector active-category">
                            
                            <button type="button" class="grid-style-btn active" data-category="door" data-model-id="casement" data-model-name="Double Casement French Doors" data-model-mechanism="door" data-grid-cost="<?php echo esc_attr($rates['model_casement']); ?>">
                                <span class="grid-icon">🚪</span>
                                <span><?php esc_html_e('Double Casement Doors', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Dual Handles Included (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_casement'], 2))); ?></small>
                            </button>

                            <button type="button" class="grid-style-btn" data-category="door" data-model-id="four-grid" data-model-name="4-Grid Colonial French Doors" data-model-mechanism="door" data-grid-cost="<?php echo esc_attr($rates['model_four_grid']); ?>">
                                <span class="grid-icon">➕</span>
                                <span><?php esc_html_e('4-Grid Colonial Doors', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Dual Handles Included (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_four_grid'], 2))); ?></small>
                            </button>

                            <button type="button" class="grid-style-btn" data-category="door" data-model-id="six-grid" data-model-name="6-Grid Architectural French Doors" data-model-mechanism="door" data-grid-cost="<?php echo esc_attr($rates['model_six_grid']); ?>">
                                <span class="grid-icon">▦</span>
                                <span><?php esc_html_e('6-Grid Architectural Doors', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Dual Handles Included (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_six_grid'], 2))); ?></small>
                            </button>

                        </div>

                        <!-- Category B: Sliding Models (Dynamic Admin Rates) -->
                        <div id="category-models-slide" class="mechanism-models-grid grid-style-selector" style="display: none;">
                            
                            <button type="button" class="grid-style-btn" data-category="slide" data-model-id="sliding" data-model-name="2-Panel Minimalist Sliding Window" data-model-mechanism="slide" data-grid-cost="<?php echo esc_attr($rates['model_sliding']); ?>">
                                <span class="grid-icon">↔️</span>
                                <span><?php esc_html_e('2-Panel Sliding', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Touch-Slide / No Handles (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_sliding'], 2))); ?></small>
                            </button>

                            <button type="button" class="grid-style-btn" data-category="slide" data-model-id="sliding-colonial" data-model-name="4-Grid Colonial Sliding Window" data-model-mechanism="slide" data-grid-cost="<?php echo esc_attr($rates['model_sliding_colonial']); ?>">
                                <span class="grid-icon">➕</span>
                                <span><?php esc_html_e('Colonial 4-Grid Sliding', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Touch-Slide / No Handles (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_sliding_colonial'], 2))); ?></small>
                            </button>

                            <button type="button" class="grid-style-btn" data-category="slide" data-model-id="eight-grid" data-model-name="8-Grid Prairie Luxury Sliding Window" data-model-mechanism="slide" data-grid-cost="<?php echo esc_attr($rates['model_eight_grid']); ?>">
                                <span class="grid-icon">🏛️</span>
                                <span><?php esc_html_e('8-Grid Prairie Sliding', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Touch-Slide / No Handles (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_eight_grid'], 2))); ?></small>
                            </button>

                        </div>

                        <!-- Category C: Fixed Panoramic Models (Dynamic Admin Rates) -->
                        <div id="category-models-fixed" class="mechanism-models-grid grid-style-selector" style="display: none;">
                            
                            <button type="button" class="grid-style-btn" data-category="fixed" data-model-id="single" data-model-name="Single Panoramic Fixed Window" data-model-mechanism="fixed" data-grid-cost="<?php echo esc_attr($rates['model_single']); ?>">
                                <span class="grid-icon">🔲</span>
                                <span><?php esc_html_e('Single Panoramic Fixed', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Non-Opening Seamless (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_single'], 2))); ?></small>
                            </button>

                            <button type="button" class="grid-style-btn" data-category="fixed" data-model-id="four-grid-fixed" data-model-name="4-Grid Architectural Transom Fixed" data-model-mechanism="fixed" data-grid-cost="<?php echo esc_attr($rates['model_four_grid_fixed']); ?>">
                                <span class="grid-icon">▦</span>
                                <span><?php esc_html_e('4-Grid Architectural Fixed', 'luxury-window'); ?></span>
                                <small><?php printf(esc_html__('Non-Opening Transom (+$%s)', 'luxury-window'), esc_html(number_format($rates['model_four_grid_fixed'], 2))); ?></small>
                            </button>

                        </div>
                    </div>

                    <!-- STEP 5: Luxury Hardware Finishes (Dual Handles for Doors - Dynamic Admin Rates) -->
                    <div class="config-step-box" id="step-hardware-box">
                        <div class="step-badge">
                            <span class="step-num">5</span>
                            <h4><?php esc_html_e('Hardware & Handle Finish', 'luxury-window'); ?></h4>
                        </div>

                        <div class="swatch-grid" id="hardware-swatch-grid">
                            
                            <!-- Dual Gold Handles -->
                            <button type="button" class="swatch-btn handle-swatch-btn active" data-handle-id="dual-gold" data-handle-name="Dual Luxury Gold Handles" data-handle-color="#d4af37" data-handle-cost="<?php echo esc_attr($rates['handle_gold']); ?>">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #d4af37, #fef08a); border: 1px solid #fef08a;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Dual Champagne Gold', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Both Panels (+$%s)', 'luxury-window'), esc_html(number_format($rates['handle_gold'], 2))); ?></span>
                                </div>
                            </button>

                            <!-- Dual Matte Black Handles -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="dual-black" data-handle-name="Dual Obsidian Matte Black Handles" data-handle-color="#18181b" data-handle-cost="<?php echo esc_attr($rates['handle_black']); ?>">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #18181b, #3f3f46); border: 1px solid #52525b;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Dual Obsidian Black', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Both Panels (+$%s)', 'luxury-window'), esc_html(number_format($rates['handle_black'], 2))); ?></span>
                                </div>
                            </button>

                            <!-- Dual Brushed Chrome Handles -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="dual-chrome" data-handle-name="Dual Brushed Chrome Handles" data-handle-color="#94a3b8" data-handle-cost="<?php echo esc_attr($rates['handle_chrome']); ?>">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #94a3b8, #cbd5e1); border: 1px solid #cbd5e1;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Dual Brushed Chrome', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Both Panels (+$%s)', 'luxury-window'), esc_html(number_format($rates['handle_chrome'], 2))); ?></span>
                                </div>
                            </button>

                            <!-- Dual Architectural Bronze Handles -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="dual-bronze" data-handle-name="Dual Architectural Bronze Handles" data-handle-color="#78350f" data-handle-cost="<?php echo esc_attr($rates['handle_bronze']); ?>">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #78350f, #92400e); border: 1px solid #92400e;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Dual Architectural Bronze', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php printf(esc_html__('Both Panels (+$%s)', 'luxury-window'), esc_html(number_format($rates['handle_bronze'], 2))); ?></span>
                                </div>
                            </button>

                            <!-- No Handle (Sliding Push) -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="none" data-handle-name="No Handles (Touch / Frameless Push)" data-handle-color="transparent" data-handle-cost="0.00" style="display: none;" id="handle-btn-none">
                                <span class="swatch-color" style="background: rgba(255,255,255,0.05); border: 1px dashed var(--color-border); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">🚫</span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('No Handles (Frameless)', 'luxury-window'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Touch-Slide Mechanism (+$0)', 'luxury-window'); ?></span>
                                </div>
                            </button>

                        </div>
                    </div>

                    <!-- STEP 6: Live Cost Breakdown & Order Button -->
                    <div class="pricing-summary-card">
                        <h4 class="summary-title"><?php esc_html_e('Real-Time Engineered Cost Breakdown', 'blog-post-ahanaf'); ?></h4>
                        
                        <div class="breakdown-list">
                            <div class="breakdown-row">
                                <span><?php esc_html_e('Base Manufacturing & Assembly:', 'blog-post-ahanaf'); ?></span>
                                <span>$50.00</span>
                            </div>
                            <div class="breakdown-row">
                                <span><?php esc_html_e('Glass Glazing Cost:', 'blog-post-ahanaf'); ?></span>
                                <span id="breakdown-glass-cost">$240.00</span>
                            </div>
                            <div class="breakdown-row">
                                <span><?php esc_html_e('Frame & Extrusion Cost:', 'blog-post-ahanaf'); ?></span>
                                <span id="breakdown-frame-cost">$144.00</span>
                            </div>
                            <div class="breakdown-row">
                                <span><?php esc_html_e('Grid Architecture:', 'blog-post-ahanaf'); ?></span>
                                <span id="breakdown-grid-cost">$0.00</span>
                            </div>
                            <div class="breakdown-row">
                                <span><?php esc_html_e('Hardware & Lock:', 'blog-post-ahanaf'); ?></span>
                                <span id="breakdown-hardware-cost">$35.00</span>
                            </div>
                        </div>

                        <div class="total-price-bar">
                            <div class="total-label-wrap">
                                <span class="total-subtext"><?php esc_html_e('Engineered Unit Price:', 'blog-post-ahanaf'); ?></span>
                                <div class="total-amount gold-text" id="display-total-price">$469.00</div>
                            </div>

                            <div class="action-wrap">
                                <div class="qty-field">
                                    <label for="window-order-qty"><?php esc_html_e('Qty:', 'blog-post-ahanaf'); ?></label>
                                    <input type="number" id="window-order-qty" value="1" min="1" max="50" />
                                </div>
                                <button type="button" id="window-order-btn" class="btn btn-primary order-window-btn">
                                    <span class="btn-text"><?php esc_html_e('Order Custom Window', 'blog-post-ahanaf'); ?> &rarr;</span>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</main>

<?php
get_footer();
