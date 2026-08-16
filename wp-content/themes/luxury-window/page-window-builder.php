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
                    <div class="visualizer-action-toolbar" style="margin-bottom: 0.8rem; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.82rem; color: var(--color-text-muted);">
                            🪟 <?php esc_html_e('Interactive Window Mechanism:', 'blog-post-ahanaf'); ?>
                        </span>
                        <button type="button" id="toggle-slide-window-btn" class="slide-toggle-pill-btn" title="<?php esc_attr_e('Test Window Sliding Motion', 'blog-post-ahanaf'); ?>">
                            <span class="slide-icon">↔️</span>
                            <span class="slide-btn-text"><?php esc_html_e('Slide Open', 'blog-post-ahanaf'); ?></span>
                        </button>
                    </div>

                    <!-- SVG Canvas Stage -->
                    <div class="svg-canvas-container">
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
                                    <stop offset="0%" stop-color="#d97706" stop-opacity="0.4" />
                                    <stop offset="50%" stop-color="#78350f" stop-opacity="0.5" />
                                    <stop offset="100%" stop-color="#b45309" stop-opacity="0.35" />
                                </linearGradient>

                                <!-- Obsidian Reflective Gradient -->
                                <linearGradient id="glassObsidianGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#27272a" stop-opacity="0.8" />
                                    <stop offset="40%" stop-color="#52525b" stop-opacity="0.5" />
                                    <stop offset="100%" stop-color="#09090b" stop-opacity="0.85" />
                                </linearGradient>

                                <!-- Acoustic Double Glazing Gradient -->
                                <linearGradient id="glassAcousticGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.3" />
                                    <stop offset="50%" stop-color="#818cf8" stop-opacity="0.2" />
                                    <stop offset="100%" stop-color="#0284c7" stop-opacity="0.35" />
                                </linearGradient>
                            </defs>

                            <!-- Outer Window Frame Track -->
                            <rect id="svg-frame-outer" x="10" y="10" width="340" height="430" rx="8" ry="8" fill="#18181b" stroke="rgba(212,175,55,0.3)" stroke-width="1.5" />

                            <!-- Glass Base Background Pane -->
                            <rect id="svg-glass-pane" x="22" y="22" width="316" height="406" rx="4" ry="4" fill="url(#glassClearGrad)" />
                            
                            <!-- Left Window Sash (Interactive Sliding Enabled) -->
                            <g id="svg-sliding-sash-left" style="transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); transform-origin: left center;">
                                <rect id="svg-frame-left-sash" x="22" y="22" width="158" height="406" rx="4" ry="4" fill="none" stroke="#27272a" stroke-width="3.5" />
                                <polygon id="svg-sheen-left" points="35,22 100,22 60,428 22,428" fill="rgba(255,255,255,0.06)" />
                                <!-- Left Handle (for Dual Handles) -->
                                <g id="svg-handle-left" style="display: none;">
                                    <rect id="svg-handle-left-rect" x="162" y="205" width="8" height="38" rx="2.5" ry="2.5" fill="#d4af37" filter="drop-shadow(0px 2px 4px rgba(0,0,0,0.6))" />
                                    <circle id="svg-handle-left-dot" cx="166" cy="212" r="2" fill="#070709" />
                                </g>
                            </g>

                            <!-- Right Window Sash -->
                            <g id="svg-sliding-sash-right">
                                <rect id="svg-frame-right-sash" x="180" y="22" width="158" height="406" rx="4" ry="4" fill="none" stroke="#27272a" stroke-width="3.5" />
                                <polygon id="svg-sheen-right" points="200,22 250,22 210,428 180,428" fill="rgba(255,255,255,0.03)" />
                                <!-- Right Handle (for Dual Handles) -->
                                <g id="svg-handle-right" style="display: none;">
                                    <rect id="svg-handle-right-rect" x="190" y="205" width="8" height="38" rx="2.5" ry="2.5" fill="#d4af37" filter="drop-shadow(0px 2px 4px rgba(0,0,0,0.6))" />
                                    <circle id="svg-handle-right-dot" cx="194" cy="212" r="2" fill="#070709" />
                                </g>
                            </g>

                            <!-- Inner Frame Border -->
                            <rect id="svg-frame-inner" x="22" y="22" width="316" height="406" rx="4" ry="4" fill="none" stroke="#27272a" stroke-width="4" />

                            <!-- Dynamic Grid Lines (Controlled via JS) -->
                            <line id="svg-grid-vertical" x1="180" y1="22" x2="180" y2="428" stroke="#18181b" stroke-width="6" style="display: none;" />
                            <line id="svg-grid-horizontal" x1="22" y1="225" x2="338" y2="225" stroke="#18181b" stroke-width="6" style="display: none;" />
                            <line id="svg-grid-extra-cols" x1="126" y1="22" x2="126" y2="428" stroke="#18181b" stroke-width="5" style="display: none;" />
                            <line id="svg-grid-extra-rows" x1="22" y1="290" x2="338" y2="290" stroke="#18181b" stroke-width="5" style="display: none;" />

                            <!-- Single Center Handle Component (Always Centered) -->
                            <g id="svg-handle-center">
                                <rect id="svg-hardware-handle" x="175" y="205" width="10" height="42" rx="3" ry="3" fill="#d4af37" filter="drop-shadow(0px 2px 5px rgba(0,0,0,0.7))" />
                                <circle id="svg-hardware-handle-dot" cx="180" cy="212" r="2.5" fill="#070709" />
                            </g>
                        </svg>
                    </div>

                    <!-- Live Specs Summary Footer -->
                    <div class="visualizer-footer">
                        <div class="live-spec-item">
                            <span class="spec-label"><?php esc_html_e('Frame:', 'blog-post-ahanaf'); ?></span>
                            <span class="spec-val" id="display-frame-type">Obsidian Matte Black Aluminium</span>
                        </div>
                        <div class="live-spec-item">
                            <span class="spec-label"><?php esc_html_e('Glass:', 'blog-post-ahanaf'); ?></span>
                            <span class="spec-val" id="display-glass-type">Crystal Clear Tempered Glass</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- =================================================================
                 RIGHT PANE: Step-by-Step Configurator Options & Controls
                 ================================================================= -->
            <div class="controls-col">
                <div class="controls-card">
                    
                    <!-- STEP 1: Frame Finish & Material -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">1</span>
                            <h4><?php esc_html_e('Select Frame Finish & Material', 'blog-post-ahanaf'); ?></h4>
                        </div>
                        
                        <div class="swatch-grid">
                            
                            <button type="button" class="swatch-btn frame-swatch-btn active" data-frame-id="black" data-frame-name="Obsidian Matte Black Aluminium" data-frame-color="#18181b" data-frame-accent="#27272a" data-frame-rate="8.00">
                                <span class="swatch-color" style="background: #18181b; border: 1px solid #3f3f46;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Obsidian Black', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Heavy-duty Aluminium ($8/ft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="gold" data-frame-name="Metallic Champagne Gold Aluminium" data-frame-color="#d4af37" data-frame-accent="#e5c05b" data-frame-rate="14.00">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #d4af37, #fef08a); border: 1px solid #d4af37;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Champagne Gold', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Luxury Anodized ($14/ft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="chrome" data-frame-name="Brushed Silver Chrome Aluminium" data-frame-color="#94a3b8" data-frame-accent="#cbd5e1" data-frame-rate="10.00">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #94a3b8, #f1f5f9); border: 1px solid #cbd5e1;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Brushed Chrome', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Modern Finish ($10/ft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="wood" data-frame-name="Walnut Architectural Woodgrain" data-frame-color="#5c3d2e" data-frame-accent="#78350f" data-frame-rate="12.00">
                                <span class="swatch-color" style="background: #5c3d2e; border: 1px solid #78350f;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Walnut Woodgrain', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Natural Texture ($12/ft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn frame-swatch-btn" data-frame-id="white" data-frame-name="Arctic Matte White Poly" data-frame-color="#f8fafc" data-frame-accent="#e2e8f0" data-frame-rate="7.00">
                                <span class="swatch-color" style="background: #f8fafc; border: 1px solid #cbd5e1;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Arctic White', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Clean Minimalist ($7/ft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                        </div>
                    </div>

                    <!-- STEP 2: Glass Glazing & Tint -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">2</span>
                            <h4><?php esc_html_e('Select Glass Glazing & Performance', 'blog-post-ahanaf'); ?></h4>
                        </div>

                        <div class="swatch-grid">
                            
                            <button type="button" class="swatch-btn glass-swatch-btn active" data-glass-id="clear" data-glass-name="Crystal Clear Tempered Glass" data-glass-fill="url(#glassClearGrad)" data-glass-rate="12.00">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, rgba(255,255,255,0.7), rgba(56,189,248,0.3));"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Clear Tempered', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('High Clarity ($12/sqft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="frosted" data-glass-name="Frosted Privacy Glass" data-glass-fill="url(#glassFrostedGrad)" data-glass-rate="16.00">
                                <span class="swatch-color glass-preview-circle" style="background: rgba(226,232,240,0.8); backdrop-filter: blur(8px);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Frosted Privacy', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Diffused Light ($16/sqft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="bronze" data-glass-name="Tinted Bronze Solar Glass" data-glass-fill="url(#glassBronzeGrad)" data-glass-rate="18.00">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #b45309, #78350f);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Tinted Bronze', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Solar Heat Block ($18/sqft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="obsidian" data-glass-name="Obsidian Dark Reflective Glass" data-glass-fill="url(#glassObsidianGrad)" data-glass-rate="22.00">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #27272a, #09090b);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Obsidian Reflective', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('1-Way Mirror ($22/sqft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <button type="button" class="swatch-btn glass-swatch-btn" data-glass-id="acoustic" data-glass-name="Acoustic Double-Glazed Glass" data-glass-fill="url(#glassAcousticGrad)" data-glass-rate="28.00">
                                <span class="swatch-color glass-preview-circle" style="background: linear-gradient(135deg, #38bdf8, #818cf8);"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Acoustic Double-Glazed', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Max Soundproofing ($28/sqft)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                        </div>
                    </div>

                    <!-- STEP 3: Custom Dimensions (Width x Height) -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">3</span>
                            <h4><?php esc_html_e('Custom Dimensions (Width × Height in Feet)', 'blog-post-ahanaf'); ?></h4>
                        </div>

                        <div class="dimensions-control-grid">
                            
                            <!-- Width Slider & Input -->
                            <div class="dim-control-card">
                                <div class="dim-header">
                                    <label for="window-width-slider"><?php esc_html_e('Window Width', 'blog-post-ahanaf'); ?></label>
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
                                    <label for="window-height-slider"><?php esc_html_e('Window Height', 'blog-post-ahanaf'); ?></label>
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

                    <!-- STEP 4: Grid / Architectural Divider -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">4</span>
                            <h4><?php esc_html_e('Grid Pattern & Panel Architecture', 'blog-post-ahanaf'); ?></h4>
                        </div>

                        <div class="grid-style-selector">
                            <button type="button" class="grid-style-btn active" data-grid-id="single" data-grid-name="Single Pane (Minimalist)" data-grid-cost="0.00">
                                <span class="grid-icon">🔲</span>
                                <span><?php esc_html_e('Single Pane', 'blog-post-ahanaf'); ?></span>
                                <small>+$0</small>
                            </button>

                            <button type="button" class="grid-style-btn" data-grid-id="two-panel" data-grid-name="2-Panel Sliding / Casement" data-grid-cost="25.00">
                                <span class="grid-icon">🚪</span>
                                <span><?php esc_html_e('2-Panel Sliding', 'blog-post-ahanaf'); ?></span>
                                <small>+$25</small>
                            </button>

                            <button type="button" class="grid-style-btn" data-grid-id="four-grid" data-grid-name="4-Grid Colonial Cross" data-grid-cost="40.00">
                                <span class="grid-icon">➕</span>
                                <span><?php esc_html_e('4-Grid Colonial', 'blog-post-ahanaf'); ?></span>
                                <small>+$40</small>
                            </button>

                            <button type="button" class="grid-style-btn" data-grid-id="six-grid" data-grid-name="6-Grid Architectural" data-grid-cost="60.00">
                                <span class="grid-icon">▦</span>
                                <span><?php esc_html_e('6-Grid Architectural', 'blog-post-ahanaf'); ?></span>
                                <small>+$60</small>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 5: Luxury Hardware & Lock -->
                    <div class="config-step-box">
                        <div class="step-badge">
                            <span class="step-num">5</span>
                            <h4><?php esc_html_e('Hardware & Handle Configuration (Optional for Sliding)', 'blog-post-ahanaf'); ?></h4>
                        </div>

                        <div class="swatch-grid">
                            
                            <!-- No Handle Option (Ideal for Sliding) -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="none" data-handle-name="No Handle / Push-to-Slide (Sliding Style)" data-handle-color="transparent" data-handle-cost="0.00">
                                <span class="swatch-color" style="background: rgba(255,255,255,0.05); border: 1px dashed var(--color-border); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">🚫</span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('No Handle (Sliding Push)', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Clean Frameless Look (+$0)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <!-- Single Center Gold Handle -->
                            <button type="button" class="swatch-btn handle-swatch-btn active" data-handle-id="single-gold" data-handle-name="Signature Single Center Gold Handle" data-handle-color="#d4af37" data-handle-cost="35.00">
                                <span class="swatch-color" style="background: #d4af37; border: 1px solid #fef08a;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Single Gold Handle (Center)', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Middle Sash Placement (+$35)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <!-- Dual Gold Handles (Both Left & Right) -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="dual-gold" data-handle-name="Dual Luxury Gold Handles (Both Panels)" data-handle-color="#d4af37" data-handle-cost="55.00">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #d4af37, #b45309); border: 1px solid #fef08a;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Dual Gold Handles', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Left & Right Panels (+$55)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <!-- Single Matte Black Handle -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="single-black" data-handle-name="Single Obsidian Matte Black Handle" data-handle-color="#18181b" data-handle-cost="25.00">
                                <span class="swatch-color" style="background: #18181b; border: 1px solid #3f3f46;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Single Matte Black (Center)', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Stealth Aluminium (+$25)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <!-- Dual Matte Black Handles -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="dual-black" data-handle-name="Dual Obsidian Matte Black Handles" data-handle-color="#18181b" data-handle-cost="40.00">
                                <span class="swatch-color" style="background: linear-gradient(135deg, #18181b, #3f3f46); border: 1px solid #52525b;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Dual Matte Black Handles', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Left & Right Panels (+$40)', 'blog-post-ahanaf'); ?></span>
                                </div>
                            </button>

                            <!-- Minimalist Flush Lock -->
                            <button type="button" class="swatch-btn handle-swatch-btn" data-handle-id="flush" data-handle-name="Minimalist Flush Recessed Pull" data-handle-color="#27272a" data-handle-cost="15.00">
                                <span class="swatch-color" style="background: #27272a; border: 1px solid #52525b;"></span>
                                <div class="swatch-info">
                                    <span class="swatch-title"><?php esc_html_e('Flush Recessed Pull', 'blog-post-ahanaf'); ?></span>
                                    <span class="swatch-subtitle"><?php esc_html_e('Hidden Lock for Sliding (+$15)', 'blog-post-ahanaf'); ?></span>
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
