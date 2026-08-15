# 👑 VlogPulse — Luxury WordPress Theme & Companion Plugin

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%20%7C%208.0%2B-777bb4.svg)](https://www.php.net/)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-Compatible-96588a.svg)](https://woocommerce.com/)
[![License](https://img.shields.io/badge/License-GPLv2-gold.svg)](LICENSE)

**VlogPulse** is a modern, high-performance **WordPress Theme & Core Companion Plugin** designed for video content creators, vloggers, and modern digital storytellers. Built following WordPress industry standards with clean architecture, strict presentation/logic separation, real-time AJAX interactions, and full WooCommerce e-commerce support.

---

## ✨ Features Overview

### 🎨 1. Luxury Black & Gold Design System
* **Deep Obsidian Dark Palette:** `#070709` / `#0e0e12` with subtle metallic gold highlights (`#d4af37`, `#e5c05b`).
* **Clean Solid Typography:** Modern Inter & Outfit fonts without gradient text artifacts.
* **Glassmorphic UI Components:** Sleek frosted glass cards with 1px gold borders and smooth hover elevation.

### 🎥 2. Dynamic Vlog & Blog Engine
* **Dedicated Video Player:** Seamlessly embeds YouTube, Vimeo, or direct MP4 video URLs directly into posts.
* **Real-time Filter Pills:** One-click instant filtering between *All Posts* and *Only Vlogs*.
* **Interactive AJAX Likes:** Instant like toggling with persistent database counters and login prompts.
* **Estimated Reading Time:** Automatically computed reading time badge for each story.

### ✍️ 3. Frontend Creator Studio (`/create-post`)
* **Client-Friendly Publishing Form:** Publish articles or video vlogs directly from the frontend without opening the WordPress Gutenberg editor.
* **Format Switcher:** Toggle between *Standard Article* and *Video Vlog* with dynamic video URL inputs.
* **Drag-and-Drop Thumbnail Upload:** Instant image preview before publishing.
* **Instant AJAX Publishing:** Fast post creation with live permalink redirection.

### 🛒 4. Full WooCommerce E-Commerce Integration
* **Header Mini-Cart:** Dynamic floating cart icon with real-time AJAX item count badge.
* **Creator Merch & Presets Shop:** Styled shop grid for physical gear, Lightroom/LUT presets, and courses.
* **Luxury Single Product & Checkout:** Fully styled product gallery, star ratings, tabs, and dark glass checkout forms.

### 📄 5. Custom Page Templates
* **About Us (`page-about.php`):** Mission statement, animated stats counters (50K+ Community, 250+ Vlogs), and creator profile showcase.
* **Contact Us (`page-contact.php`):** Interactive contact form with real-time toast feedback and direct collaboration channels.
* **Privacy Policy (`page-privacy.php`):** Clean, structured layout covering user data, cookies, and media rights.

---

## 📂 Repository Structure

```
vlogpulse-theme-plugin/
├── wp-content/
│   ├── themes/
│   │   └── blog-post-ahanaf/         # Luxury WordPress Theme (Presentation & Templates)
│   │       ├── assets/
│   │       │   ├── css/main.css      # Luxury Black & Gold Design System
│   │       │   └── js/main.js        # Frontend Navigation & Modal UI
│   │       ├── inc/
│   │       │   └── theme-setup.php   # Theme Support (WooCommerce, Menus, HTML5)
│   │       ├── page-about.php        # About Us Template
│   │       ├── page-contact.php      # Contact Us Template
│   │       ├── page-privacy.php      # Privacy Policy Template
│   │       ├── page-create-post.php  # Frontend Creator Studio Template
│   │       ├── woocommerce.php       # WooCommerce Template Wrapper
│   │       ├── single.php            # Single Post & Vlog Player Template
│   │       ├── header.php            # Header & Mini-Cart
│   │       ├── footer.php            # Footer & Auth Modal
│   │       └── style.css             # Theme Header Declaration
│   │
│   └── plugins/
│       └── vlogpulse-core/           # Core Companion Plugin (Business Logic & Handlers)
│           ├── includes/
│           │   ├── meta-boxes.php     # Vlog Video URL Meta Box & Player Generator
│           │   ├── like-handler.php   # AJAX Like / Unlike Database Handler
│           │   ├── auth-handler.php   # AJAX Login & Registration Endpoints
│           │   └── post-submission.php# Frontend Creator Post Submission Handler
│           ├── assets/
│           │   └── js/               # Modular AJAX Scripts (likes.js, auth.js, post-submission.js)
│           └── vlogpulse-core.php    # Plugin Bootstrap Loader
│
├── .gitignore
└── README.md
```

---

## 🚀 Installation & Setup

1. **Upload Theme:**
   * Copy `wp-content/themes/blog-post-ahanaf/` to your WordPress `wp-content/themes/` directory.
   * Navigate to **Appearance > Themes** and activate **Blog Post Theme (Ahanaf)**.

2. **Upload & Activate Plugin:**
   * Copy `wp-content/plugins/vlogpulse-core/` to your WordPress `wp-content/plugins/` directory.
   * Navigate to **Plugins > Installed Plugins** and activate **VlogPulse Core**.

3. **Install WooCommerce (Optional for Shop):**
   * Install and activate **WooCommerce** to enable the shop and creator merchandise store.

---

## 👨‍💻 Author

* **Ahanaf Mubasshir**
* GitHub: [@ahanaf607307](https://github.com/ahanaf607307)
* Website: [VlogPulse](http://blog-post-theme-ahanaf.local)

---

## 📜 License
This project is open-source software licensed under the **GPL-2.0+ License**.
