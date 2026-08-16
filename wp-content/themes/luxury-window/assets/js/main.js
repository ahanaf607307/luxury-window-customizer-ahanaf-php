/**
 * Blog & Vlog Hub - Main UI Scripts
 * 
 * ফ্রেশারদের জন্য নোট:
 * - এই ফাইলটি মডাল ওপেন/ক্লোজ, ড্রপডাউন টগল, মোবাইল মেনু এবং টোস্ট নোটিফিকেশন হ্যান্ডেল করে।
 * 
 * @package Blog_Post_Ahanaf
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ১. মোবাইল মেনু টগল
    const mobileToggle = document.querySelector('.mobile-toggle');
    const mainNav = document.querySelector('.main-nav');

    if (mobileToggle && mainNav) {
        mobileToggle.addEventListener('click', function () {
            mainNav.classList.toggle('active');
            const isExpanded = mainNav.classList.contains('active');
            mobileToggle.setAttribute('aria-expanded', isExpanded);
        });
    }

    // ২. ইউজার প্রোফাইল ড্রপডাউন মেনু টগল
    const userBadgeBtn = document.querySelector('.user-badge-btn');
    const userMenuDropdown = document.querySelector('.user-menu-dropdown');

    if (userBadgeBtn && userMenuDropdown) {
        userBadgeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            userMenuDropdown.classList.toggle('active');
        });

        // বাইরে ক্লিক করলে ড্রপডাউন বন্ধ হওয়া
        document.addEventListener('click', function (e) {
            if (!userMenuDropdown.contains(e.target)) {
                userMenuDropdown.classList.remove('active');
            }
        });
    }

    // ৩. গ্লোবাল মডাল কন্ট্রোলার (Sign In / Sign Up Popups)
    window.AhanafModal = {
        open: function (targetTab = 'signin') {
            const modal = document.getElementById('ahanaf-auth-modal');
            if (!modal) return;

            modal.classList.add('is-active');
            document.body.style.overflow = 'hidden';

            // সঠিক ট্যাব সুইচ করা
            this.switchTab(targetTab);
        },

        close: function () {
            const modal = document.getElementById('ahanaf-auth-modal');
            if (!modal) return;

            modal.classList.remove('is-active');
            document.body.style.overflow = '';
        },

        switchTab: function (tabName) {
            const tabBtns = document.querySelectorAll('.modal-tab-btn');
            const signinForm = document.getElementById('ahanaf-signin-form-wrap');
            const signupForm = document.getElementById('ahanaf-signup-form-wrap');

            tabBtns.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.tab === tabName);
            });

            if (tabName === 'signin') {
                if (signinForm) signinForm.style.display = 'block';
                if (signupForm) signupForm.style.display = 'none';
            } else {
                if (signinForm) signinForm.style.display = 'none';
                if (signupForm) signupForm.style.display = 'block';
            }
        }
    };

    // মডাল ওপেন বাটন ইভেন্ট লিসেনার
    document.querySelectorAll('[data-open-modal]').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const tab = this.dataset.openModal || 'signin';
            window.AhanafModal.open(tab);
        });
    });

    // মডাল ক্লোজ বাটন
    document.querySelectorAll('.modal-close-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            window.AhanafModal.close();
        });
    });

    // মডালের ব্যাকড্রপে ক্লিক করলে বন্ধ হওয়া
    const authModal = document.getElementById('ahanaf-auth-modal');
    if (authModal) {
        authModal.addEventListener('click', function (e) {
            if (e.target === authModal) {
                window.AhanafModal.close();
            }
        });
    }

    // Escape কি প্রেস করলে মডাল ক্লোজ হওয়া
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            window.AhanafModal.close();
        }
    });

    // মডাল ট্যাব সুইচিং ক্লিক
    document.querySelectorAll('.modal-tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            window.AhanafModal.switchTab(this.dataset.tab);
        });
    });

    // ৪. গ্লোবাল টোস্ট নোটিফিকেশন সিস্টেম
    window.AhanafToast = function (message, type = 'info') {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        let icon = '🔔';
        if (type === 'success') icon = '✅';
        if (type === 'error') icon = '⚠️';

        toast.innerHTML = `<span>${icon}</span> <span>${message}</span>`;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    };
});
