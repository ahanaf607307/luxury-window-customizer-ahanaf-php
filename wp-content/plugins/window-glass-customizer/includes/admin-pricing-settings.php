<?php
/**
 * Admin Pricing Settings & Rates Management
 * 
 * Allows WordPress Admin to dynamically change all pricing rates for:
 * - Base fabrication fees
 * - Frame materials ($/linear ft)
 * - Frame profile thickness ($/linear ft)
 * - Glass glazing types ($/sq.ft)
 * - Architecture & mechanism models ($)
 * - Hardware handles ($)
 * 
 * @package Window_Glass_Customizer
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Default Pricing Rates Matrix
 */
function luxury_window_get_default_pricing_rates() {
    return array(
        'base_fee'                => 50.00,

        // Frame Finish Rates ($/ft)
        'frame_black'             => 8.00,
        'frame_gold'              => 14.00,
        'frame_chrome'            => 10.00,
        'frame_bronze'            => 12.00,
        'frame_wood'              => 13.00,
        'frame_navy'              => 11.00,
        'frame_emerald'           => 11.00,
        'frame_white'             => 7.00,

        // Frame Profile Thickness Extra Rates ($/ft)
        'profile_slim'            => 0.00,
        'profile_standard'        => 3.00,
        'profile_heavy'           => 6.00,
        'profile_bold'            => 10.00,

        // Glass Glazing Rates ($/sq.ft)
        'glass_clear'             => 12.00,
        'glass_frosted'           => 16.00,
        'glass_bronze'            => 18.00,
        'glass_obsidian'          => 22.00,
        'glass_acoustic'          => 28.00,
        'glass_lowe'              => 25.00,
        'glass_ocean'             => 20.00,

        // Model & Mechanism Extra Costs ($)
        'model_casement'          => 35.00,
        'model_four_grid'         => 45.00,
        'model_six_grid'          => 60.00,
        'model_sliding'           => 25.00,
        'model_sliding_colonial'  => 45.00,
        'model_eight_grid'        => 75.00,
        'model_single'            => 0.00,
        'model_four_grid_fixed'   => 35.00,

        // Hardware Handles ($)
        'handle_gold'             => 45.00,
        'handle_black'            => 35.00,
        'handle_chrome'           => 40.00,
        'handle_bronze'           => 40.00,
    );
}

/**
 * 2. Get Current Pricing Rates (Merged with Saved Options)
 */
function luxury_window_get_pricing_rates() {
    $defaults = luxury_window_get_default_pricing_rates();
    $saved = get_option('luxury_window_pricing_rates', array());
    return wp_parse_args($saved, $defaults);
}

/**
 * 3. Register Admin Menu for Window Studio Settings
 */
function luxury_window_register_pricing_admin_menu() {
    add_menu_page(
        __('Window Studio Pricing', 'window-glass-customizer'),
        __('Window Studio', 'window-glass-customizer'),
        'manage_options',
        'window-studio-pricing',
        'luxury_window_render_pricing_settings_page',
        'dashicons-calculator',
        56
    );
}
add_action('admin_menu', 'luxury_window_register_pricing_admin_menu');

/**
 * 4. Render Admin Settings Page
 */
function luxury_window_render_pricing_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $message = '';
    $rates = luxury_window_get_pricing_rates();

    // Handle Form Submission
    if (isset($_POST['luxury_window_save_pricing']) && check_admin_referer('luxury_window_pricing_nonce_action', 'luxury_window_pricing_nonce')) {
        
        if (isset($_POST['reset_defaults'])) {
            delete_option('luxury_window_pricing_rates');
            $rates = luxury_window_get_default_pricing_rates();
            $message = '<div class="notice notice-info is-dismissible"><p>' . __('All pricing rates have been reset to default values!', 'window-glass-customizer') . '</p></div>';
        } else {
            $new_rates = array();
            $defaults = luxury_window_get_default_pricing_rates();

            foreach ($defaults as $key => $default_val) {
                if (isset($_POST[$key])) {
                    $new_rates[$key] = floatval($_POST[$key]);
                } else {
                    $new_rates[$key] = $default_val;
                }
            }

            update_option('luxury_window_pricing_rates', $new_rates);
            $rates = $new_rates;
            $message = '<div class="notice notice-success is-dismissible"><p>' . __('Window Studio pricing rates updated successfully!', 'window-glass-customizer') . '</p></div>';
        }
    }

    ?>
    <div class="wrap" style="max-width: 1080px; margin-top: 1.5rem;">
        <h1 style="font-size: 1.8rem; font-weight: 700; color: #1e1e1e; margin-bottom: 0.5rem;">
            ✨ <?php esc_html_e('Window Studio Dynamic Pricing & Rates Manager', 'window-glass-customizer'); ?>
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 1.5rem;">
            <?php esc_html_e('Modify all live customizer prices, base fees, frame extrusion rates, glass glazing rates, and hardware handle costs directly from this panel.', 'window-glass-customizer'); ?>
        </p>

        <?php echo $message; ?>

        <form method="post" action="">
            <?php wp_nonce_field('luxury_window_pricing_nonce_action', 'luxury_window_pricing_nonce'); ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                
                <!-- SECTION 1: Base Fee & Frame Finishes -->
                <div class="postbox" style="padding: 1.2rem;">
                    <h2 style="font-size: 1.15rem; font-weight: 700; border-bottom: 2px solid #d4af37; padding-bottom: 0.6rem; margin-top: 0;">
                        🏷️ <?php esc_html_e('Base Fee & Frame Finishes ($/Linear Ft)', 'window-glass-customizer'); ?>
                    </h2>
                    
                    <table class="form-table" role="presentation" style="margin-top: 0;">
                        <tr>
                            <th scope="row"><label for="base_fee"><?php esc_html_e('Base Fabrication Fee ($)', 'window-glass-customizer'); ?></label></th>
                            <td><input name="base_fee" type="number" step="0.5" id="base_fee" value="<?php echo esc_attr($rates['base_fee']); ?>" class="regular-text" style="width: 120px;" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_black">Obsidian Matte Black ($/ft)</label></th>
                            <td><input name="frame_black" type="number" step="0.5" id="frame_black" value="<?php echo esc_attr($rates['frame_black']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_gold">Champagne Gold Anodized ($/ft)</label></th>
                            <td><input name="frame_gold" type="number" step="0.5" id="frame_gold" value="<?php echo esc_attr($rates['frame_gold']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_chrome">Brushed Silver Chrome ($/ft)</label></th>
                            <td><input name="frame_chrome" type="number" step="0.5" id="frame_chrome" value="<?php echo esc_attr($rates['frame_chrome']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_bronze">Architectural Dark Bronze ($/ft)</label></th>
                            <td><input name="frame_bronze" type="number" step="0.5" id="frame_bronze" value="<?php echo esc_attr($rates['frame_bronze']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_wood">Walnut Woodgrain Texture ($/ft)</label></th>
                            <td><input name="frame_wood" type="number" step="0.5" id="frame_wood" value="<?php echo esc_attr($rates['frame_wood']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_navy">Midnight Royal Navy Blue ($/ft)</label></th>
                            <td><input name="frame_navy" type="number" step="0.5" id="frame_navy" value="<?php echo esc_attr($rates['frame_navy']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_emerald">Forest Emerald Green ($/ft)</label></th>
                            <td><input name="frame_emerald" type="number" step="0.5" id="frame_emerald" value="<?php echo esc_attr($rates['frame_emerald']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="frame_white">Arctic Matte White ($/ft)</label></th>
                            <td><input name="frame_white" type="number" step="0.5" id="frame_white" value="<?php echo esc_attr($rates['frame_white']); ?>" class="small-text" required /></td>
                        </tr>
                    </table>
                </div>

                <!-- SECTION 2: Frame Profile Thickness Rates -->
                <div class="postbox" style="padding: 1.2rem;">
                    <h2 style="font-size: 1.15rem; font-weight: 700; border-bottom: 2px solid #38bdf8; padding-bottom: 0.6rem; margin-top: 0;">
                        📐 <?php esc_html_e('Frame Profile Thickness ($/Linear Ft)', 'window-glass-customizer'); ?>
                    </h2>
                    
                    <table class="form-table" role="presentation" style="margin-top: 0;">
                        <tr>
                            <th scope="row"><label for="profile_slim">1.5″ Slimline Minimalist ($/ft)</label></th>
                            <td><input name="profile_slim" type="number" step="0.5" id="profile_slim" value="<?php echo esc_attr($rates['profile_slim']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="profile_standard">2.5″ Standard Architectural ($/ft)</label></th>
                            <td><input name="profile_standard" type="number" step="0.5" id="profile_standard" value="<?php echo esc_attr($rates['profile_standard']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="profile_heavy">3.5″ Heavy-Duty Thermal ($/ft)</label></th>
                            <td><input name="profile_heavy" type="number" step="0.5" id="profile_heavy" value="<?php echo esc_attr($rates['profile_heavy']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="profile_bold">4.5″ Bold Grand Estate ($/ft)</label></th>
                            <td><input name="profile_bold" type="number" step="0.5" id="profile_bold" value="<?php echo esc_attr($rates['profile_bold']); ?>" class="small-text" required /></td>
                        </tr>
                    </table>

                    <h2 style="font-size: 1.15rem; font-weight: 700; border-bottom: 2px solid #d4af37; padding-bottom: 0.6rem; margin-top: 2rem;">
                        🚪 <?php esc_html_e('Hardware & Handles ($ per pair)', 'window-glass-customizer'); ?>
                    </h2>
                    
                    <table class="form-table" role="presentation" style="margin-top: 0;">
                        <tr>
                            <th scope="row"><label for="handle_gold">Dual Luxury Gold Handles ($)</label></th>
                            <td><input name="handle_gold" type="number" step="0.5" id="handle_gold" value="<?php echo esc_attr($rates['handle_gold']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="handle_black">Dual Obsidian Black Handles ($)</label></th>
                            <td><input name="handle_black" type="number" step="0.5" id="handle_black" value="<?php echo esc_attr($rates['handle_black']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="handle_chrome">Dual Brushed Chrome Handles ($)</label></th>
                            <td><input name="handle_chrome" type="number" step="0.5" id="handle_chrome" value="<?php echo esc_attr($rates['handle_chrome']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="handle_bronze">Dual Architectural Bronze Handles ($)</label></th>
                            <td><input name="handle_bronze" type="number" step="0.5" id="handle_bronze" value="<?php echo esc_attr($rates['handle_bronze']); ?>" class="small-text" required /></td>
                        </tr>
                    </table>
                </div>

                <!-- SECTION 3: Glass Glazing Rates ($/sq.ft) -->
                <div class="postbox" style="padding: 1.2rem;">
                    <h2 style="font-size: 1.15rem; font-weight: 700; border-bottom: 2px solid #10b981; padding-bottom: 0.6rem; margin-top: 0;">
                        💎 <?php esc_html_e('Glass Glazing Rates ($ per Sq.Ft)', 'window-glass-customizer'); ?>
                    </h2>
                    
                    <table class="form-table" role="presentation" style="margin-top: 0;">
                        <tr>
                            <th scope="row"><label for="glass_clear">Crystal Clear Tempered ($/sqft)</label></th>
                            <td><input name="glass_clear" type="number" step="0.5" id="glass_clear" value="<?php echo esc_attr($rates['glass_clear']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="glass_frosted">Frosted Privacy Glass ($/sqft)</label></th>
                            <td><input name="glass_frosted" type="number" step="0.5" id="glass_frosted" value="<?php echo esc_attr($rates['glass_frosted']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="glass_bronze">Tinted Bronze Solar Block ($/sqft)</label></th>
                            <td><input name="glass_bronze" type="number" step="0.5" id="glass_bronze" value="<?php echo esc_attr($rates['glass_bronze']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="glass_obsidian">Obsidian Reflective 1-Way ($/sqft)</label></th>
                            <td><input name="glass_obsidian" type="number" step="0.5" id="glass_obsidian" value="<?php echo esc_attr($rates['glass_obsidian']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="glass_acoustic">Acoustic Double-Glazed ($/sqft)</label></th>
                            <td><input name="glass_acoustic" type="number" step="0.5" id="glass_acoustic" value="<?php echo esc_attr($rates['glass_acoustic']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="glass_lowe">Low-E Thermal Saver Glaze ($/sqft)</label></th>
                            <td><input name="glass_lowe" type="number" step="0.5" id="glass_lowe" value="<?php echo esc_attr($rates['glass_lowe']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="glass_ocean">Ocean Blue Solar Glaze ($/sqft)</label></th>
                            <td><input name="glass_ocean" type="number" step="0.5" id="glass_ocean" value="<?php echo esc_attr($rates['glass_ocean']); ?>" class="small-text" required /></td>
                        </tr>
                    </table>
                </div>

                <!-- SECTION 4: Architecture Model Extra Costs ($) -->
                <div class="postbox" style="padding: 1.2rem;">
                    <h2 style="font-size: 1.15rem; font-weight: 700; border-bottom: 2px solid #8b5cf6; padding-bottom: 0.6rem; margin-top: 0;">
                        🏛️ <?php esc_html_e('Architecture & Mechanism Extra Costs ($)', 'window-glass-customizer'); ?>
                    </h2>
                    
                    <table class="form-table" role="presentation" style="margin-top: 0;">
                        <tr>
                            <th scope="row"><label for="model_casement">Double Casement French Doors ($)</label></th>
                            <td><input name="model_casement" type="number" step="0.5" id="model_casement" value="<?php echo esc_attr($rates['model_casement']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="model_four_grid">4-Grid Colonial French Doors ($)</label></th>
                            <td><input name="model_four_grid" type="number" step="0.5" id="model_four_grid" value="<?php echo esc_attr($rates['model_four_grid']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="model_six_grid">6-Grid Architectural French Doors ($)</label></th>
                            <td><input name="model_six_grid" type="number" step="0.5" id="model_six_grid" value="<?php echo esc_attr($rates['model_six_grid']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="model_sliding">2-Panel Minimalist Sliding ($)</label></th>
                            <td><input name="model_sliding" type="number" step="0.5" id="model_sliding" value="<?php echo esc_attr($rates['model_sliding']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="model_sliding_colonial">Colonial 4-Grid Sliding ($)</label></th>
                            <td><input name="model_sliding_colonial" type="number" step="0.5" id="model_sliding_colonial" value="<?php echo esc_attr($rates['model_sliding_colonial']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="model_eight_grid">8-Grid Prairie Luxury Sliding ($)</label></th>
                            <td><input name="model_eight_grid" type="number" step="0.5" id="model_eight_grid" value="<?php echo esc_attr($rates['model_eight_grid']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="model_single">Single Panoramic Fixed Window ($)</label></th>
                            <td><input name="model_single" type="number" step="0.5" id="model_single" value="<?php echo esc_attr($rates['model_single']); ?>" class="small-text" required /></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="model_four_grid_fixed">4-Grid Architectural Fixed Transom ($)</label></th>
                            <td><input name="model_four_grid_fixed" type="number" step="0.5" id="model_four_grid_fixed" value="<?php echo esc_attr($rates['model_four_grid_fixed']); ?>" class="small-text" required /></td>
                        </tr>
                    </table>
                </div>

            </div>

            <!-- Action Buttons -->
            <div style="margin-top: 1.5rem; display: flex; gap: 1rem; align-items: center;">
                <input type="submit" name="luxury_window_save_pricing" class="button button-primary button-large" value="<?php esc_attr_e('💾 Save All Pricing Settings', 'window-glass-customizer'); ?>" style="font-weight: 700; padding: 0.4rem 1.5rem;" />
                <input type="submit" name="reset_defaults" class="button button-secondary" value="<?php esc_attr_e('🔄 Reset to Factory Defaults', 'window-glass-customizer'); ?>" onclick="return confirm('Are you sure you want to reset all prices to factory defaults?');" />
            </div>

        </form>
    </div>
    <?php
}
