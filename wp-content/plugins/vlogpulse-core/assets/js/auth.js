/**
 * Frontend AJAX Authentication (Login & Register) Client Script
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'fetch()' API ব্যবহার করে পেজ রিফ্রেশ ছাড়াই ব্যাকএন্ডে POST রিকোয়েস্ট পাঠানো হয়।
 * - 'ahanaf_data.ajax_url' এবং 'ahanaf_data.auth_nonce' পিএইচপি থেকে 'wp_localize_script' দিয়ে পাওয়া যায়।
 * 
 * @package VlogPulse_Core
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    if (typeof ahanaf_data === 'undefined') {
        return;
    }

    // ১. AJAX সাইন ইন (Login) হ্যান্ডলার
    const signinForm = document.getElementById('ahanaf-ajax-signin-form');
    if (signinForm) {
        signinForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const feedback = signinForm.querySelector('.auth-feedback-msg');
            const submitBtn = signinForm.querySelector('.auth-submit-btn');
            const originalBtnText = submitBtn.innerHTML;

            const formData = new FormData(signinForm);
            formData.append('action', 'ahanaf_ajax_login');
            formData.append('security', ahanaf_data.auth_nonce);
            formData.append('redirect_to', window.location.href);

            // লোডিং স্টেট দেখানো
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Signing in...';
            if (feedback) feedback.className = 'auth-feedback-msg';

            fetch(ahanaf_data.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;

                if (data.success) {
                    if (feedback) {
                        feedback.className = 'auth-feedback-msg success';
                        feedback.textContent = data.data.message;
                    }
                    if (typeof window.AhanafToast === 'function') {
                        window.AhanafToast(data.data.message, 'success');
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    if (feedback) {
                        feedback.className = 'auth-feedback-msg error';
                        feedback.textContent = data.data.message || ahanaf_data.strings.error;
                    }
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                if (feedback) {
                    feedback.className = 'auth-feedback-msg error';
                    feedback.textContent = ahanaf_data.strings.error;
                }
            });
        });
    }

    // ২. AJAX সাইন আপ (Register) হ্যান্ডলার
    const signupForm = document.getElementById('ahanaf-ajax-signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const feedback = signupForm.querySelector('.auth-feedback-msg');
            const submitBtn = signupForm.querySelector('.auth-submit-btn');
            const originalBtnText = submitBtn.innerHTML;

            const formData = new FormData(signupForm);
            formData.append('action', 'ahanaf_ajax_register');
            formData.append('security', ahanaf_data.auth_nonce);

            // লোডিং স্টেট দেখানো
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Creating Account...';
            if (feedback) feedback.className = 'auth-feedback-msg';

            fetch(ahanaf_data.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;

                if (data.success) {
                    if (feedback) {
                        feedback.className = 'auth-feedback-msg success';
                        feedback.textContent = data.data.message;
                    }
                    if (typeof window.AhanafToast === 'function') {
                        window.AhanafToast(data.data.message, 'success');
                    }
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    if (feedback) {
                        feedback.className = 'auth-feedback-msg error';
                        feedback.textContent = data.data.message || ahanaf_data.strings.error;
                    }
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                if (feedback) {
                    feedback.className = 'auth-feedback-msg error';
                    feedback.textContent = ahanaf_data.strings.error;
                }
            });
        });
    }
});
