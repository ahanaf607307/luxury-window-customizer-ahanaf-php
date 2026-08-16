# 🪟 Luxury Window — Architectural Glass & Window Systems WordPress Suite

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-Active-purple.svg)](https://woocommerce.com)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-green.svg)](https://php.net)
[![License: GPL-2.0+](https://img.shields.io/badge/License-GPL--2.0%2B-gold.svg)](http://www.gnu.org/licenses/gpl-2.0.html)

**Luxury Window** is an industry-grade, commercial WordPress Theme and Companion Plugin (`window-glass-customizer`) suite engineered specifically for architectural glass, bespoke sliding windows, acoustic glazing, and luxury aluminium frame manufacturing businesses.

Featuring a **real-time 2D SVG Window Studio visualizer**, **live mathematical pricing engine**, and direct **WooCommerce synchronization**, Luxury Window allows clients to custom engineer windows and purchase them directly through an automated e-commerce workflow.

---

## ✨ Key Features

### 🪟 1. Interactive Custom Window Studio (`/window-studio`)
* **Real-Time 2D SVG Visualizer:** Instant visual feedback for frame extrusions, glass tints, reflections, hardware latches, and proportional aspect ratios.
* **Frame Materials & Finishes:** Obsidian Matte Black, Champagne Gold, Brushed Chrome, Walnut Woodgrain, and Arctic White.
* **Glazing & Performance Choices:** Crystal Clear Tempered, Frosted Privacy, Tinted Bronze Solar, Obsidian Reflective (1-way mirror), and Acoustic Soundproof Double-Glazing.
* **Custom Sizing Matrix:** Dynamic Width (2.0 - 10.0 ft) and Height (2.0 - 8.0 ft) range sliders with square footage and perimeter calculation.
* **Grid Architecture:** Single Minimalist Pane, 2-Panel Sliding, 4-Grid Colonial Cross, and 6-Grid Architectural.
* **Hardware & Locking Configurations:** No Handle (push-to-slide), Single Center Gold/Black Handle, Dual Left & Right Handles, and Minimalist Flush Recessed Pull.
* **Interactive Sliding Demo:** Live `↔️ Slide Open / Close` button demonstrating smooth realistic sash sliding motion.

### 💰 2. Real-Time Dynamic Pricing Formula
$$\text{Total Price} = \$50\text{ (Base Assembly)} + (\text{Area (sq.ft)} \times \text{Glass Rate}) + (\text{Perimeter (ft)} \times \text{Frame Rate}) + \text{Grid Fee} + \text{Hardware Fee}$$
* Itemized live cost breakdown calculated on the fly with animated numeric counters.

### 🛒 3. Seamless WooCommerce Synchronization
* **Dynamic Cart Insertion:** Injects customized dimensions, finishes, glazing, grid, hardware, and calculated unit price into the WooCommerce cart.
* **Price Override Hook:** `woocommerce_before_calculate_totals` sets custom price without needing static product variations.
* **Cart & Checkout Line-Item Meta:** Full manufacturing specifications displayed on Mini-Cart, Cart, and Checkout pages.
* **Admin Order Specs:** Workshop-ready engineering dimensions stored directly in WooCommerce Order Line Items for easy manufacturing.

### 🛍️ 4. Ready-to-Sell Glass Window Catalog
* Pre-configured catalog featuring **Obsidian Gold Sliding Windows**, **Acoustic Casement Glazing**, **Colonial Bronze Windows**, **Frosted Privacy Panes**, and **Panoramic Pivot Windows**.
* Luxury Black & Gold product cards, sale tags, and dynamic Mini-Cart header drawer with live AJAX counter badge.

### ✍️ 5. Creator Studio & Content Hub
* **Frontend Post / Vlog Submission (`/create-post`):** Allows authorized users to publish architectural case studies and installation vlogs with YouTube/Vimeo embeds and image uploads without accessing wp-admin.
* **Real-Time AJAX Likes & Authentication:** Instant like counter and sleek glassmorphism login/register modal.

---

## 📂 Repository Structure

```
luxury-window-suite/
├── wp-content/
│   ├── themes/
│   │   └── luxury-window/                 # Theme Presentation Layer (Luxury Window)
│   │       ├── assets/
│   │       │   ├── css/main.css           # Luxury Black & Gold Design System & Window Studio CSS
│   │       │   └── js/main.js             # Frontend Navigation & Modal UI Scripts
│   │       ├── inc/
│   │       │   └── theme-setup.php        # Theme Support (WooCommerce, Menus, Post Formats)
│   │       ├── page-window-builder.php     # Custom Window Studio Interactive Template
│   │       ├── page-create-post.php       # Frontend Creator Submission Template
│   │       ├── page-about.php             # Architectural Brand Story Template
│   │       ├── page-contact.php           # Inquiries & Project Collaboration Template
│   │       ├── woocommerce.php            # WooCommerce Global Template Wrapper
│   │       ├── single.php                 # Single Post & Case Study Player Template
│   │       ├── header.php                 # Header Navigation, Luxury Window Logo & Mini-Cart
│   │       ├── footer.php                 # Footer Widgets & Auth Modal
│   │       └── style.css                  # Theme Header Declaration (Luxury Window)
│   │
│   └── plugins/
│       └── window-glass-customizer/       # Companion Plugin (Business Logic Layer)
│           ├── includes/
│           │   ├── window-configurator.php# Custom Window Math Engine & WooCommerce Cart Hooks
│           │   ├── meta-boxes.php         # Video URL Meta Box & Player Generators
│           │   ├── like-handler.php       # AJAX Likes Database Engine
│           │   ├── auth-handler.php       # AJAX Login & Registration Handlers
│           │   └── post-submission.php    # Frontend Post Submission Handler
│           ├── assets/
│           │   └── js/                    # Modular JavaScript Engines
│           │       ├── window-configurator.js # Live SVG Visualizer & Math Formula
│           │       ├── likes.js           # Real-Time AJAX Likes
│           │       ├── auth.js            # User Authentication Engine
│           │       └── post-submission.js # Media Upload & Publishing Handler
│           └── window-glass-customizer.php# Plugin Bootstrap Loader (Window Glass Customizer)
│
├── .gitignore                             # Clean Git Tracking Rules
└── README.md                              # Technical Documentation
```

---

## 🚀 Quick Setup & Installation

1. **Theme Installation:**
   * Copy `wp-content/themes/luxury-window/` into your WordPress installation's `wp-content/themes/` directory.
   * Go to **WP Admin > Appearance > Themes** and activate **Luxury Window**.

2. **Companion Plugin Installation:**
   * Copy `wp-content/plugins/window-glass-customizer/` into your `wp-content/plugins/` directory.
   * Go to **WP Admin > Plugins** and activate **Window Glass Customizer**.

3. **WooCommerce Setup:**
   * Install and activate **WooCommerce** to enable the product catalog, cart, and Window Studio order checkout.

---

## 👨‍💻 Author

* **Ahanaf Mubasshir**
* GitHub: [@ahanaf607307](https://github.com/ahanaf607307)
* Repository: [luxury-window-customizer-ahanaf-php](https://github.com/ahanaf607307/luxury-window-customizer-ahanaf-php.git)

---

## 📜 License
This project is open-source software licensed under the **GNU General Public License v2.0+ (GPL-2.0+)**.
