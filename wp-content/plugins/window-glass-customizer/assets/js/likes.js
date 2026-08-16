/**
 * Interactive AJAX Post Like / Unlike Client Script
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'fetch()' দিয়ে 'admin-ajax.php' তে POST রিকোয়েস্ট পাঠানো হয়।
 * - 'ahanaf_data' অবজেক্টটি পিএইচপি থেকে 'wp_localize_script' দিয়ে পাস করা হয়েছে।
 * 
 * @package VlogPulse_Core
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    if (typeof ahanaf_data === 'undefined') {
        return;
    }

    // লাইক বাটন হ্যান্ডলার (Event Delegation)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.ahanaf-like-btn');
        if (!btn) return;

        e.preventDefault();

        const postId = btn.dataset.postId;
        const isLoggedIn = parseInt(ahanaf_data.is_logged_in, 10) === 1;

        // ১. যদি ইউজার লগইন না করা থাকে
        if (!isLoggedIn) {
            if (typeof window.AhanafToast === 'function') {
                window.AhanafToast(ahanaf_data.strings.login_required, 'error');
            } else {
                alert(ahanaf_data.strings.login_required);
            }

            if (window.AhanafModal && typeof window.AhanafModal.open === 'function') {
                window.AhanafModal.open('signin');
            }
            return;
        }

        // ২. বাটন ডিজেবল ও অ্যানিমেশন স্টেট
        if (btn.classList.contains('is-loading')) return;
        btn.classList.add('is-loading');

        // ৩. FormData তৈরি
        const formData = new FormData();
        formData.append('action', 'ahanaf_toggle_like');
        formData.append('security', ahanaf_data.like_nonce);
        formData.append('post_id', postId);

        // ৪. AJAX রিকোয়েস্ট পাঠানো
        fetch(ahanaf_data.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.classList.remove('is-loading');

            if (data.success) {
                const isLiked = data.data.liked;
                const newCount = data.data.count;

                // একই পোস্ট আইডির যতগুলো বাটন পেজে আছে সব আপডেট করা
                document.querySelectorAll(`.ahanaf-like-btn[data-post-id="${postId}"]`).forEach(el => {
                    const countEl = el.querySelector('.ahanaf-like-count');
                    const labelEl = el.querySelector('.ahanaf-like-label');
                    const iconSvg = el.querySelector('.ahanaf-like-icon svg');

                    if (countEl) countEl.textContent = newCount;
                    if (labelEl) labelEl.textContent = isLiked ? 'Liked' : 'Like';

                    if (isLiked) {
                        el.classList.add('is-liked');
                        if (iconSvg) iconSvg.setAttribute('fill', 'currentColor');
                    } else {
                        el.classList.remove('is-liked');
                        if (iconSvg) iconSvg.setAttribute('fill', 'none');
                    }

                    // বাউন্স অ্যানিমেশন
                    el.style.transform = 'scale(1.15)';
                    setTimeout(() => el.style.transform = '', 200);
                });

                if (typeof window.AhanafToast === 'function') {
                    window.AhanafToast(data.data.message, isLiked ? 'success' : 'info');
                }
            } else {
                if (typeof window.AhanafToast === 'function') {
                    window.AhanafToast(data.data.message || ahanaf_data.strings.error, 'error');
                }
            }
        })
        .catch(err => {
            btn.classList.remove('is-loading');
            if (typeof window.AhanafToast === 'function') {
                window.AhanafToast(ahanaf_data.strings.error, 'error');
            }
        });
    });
});
