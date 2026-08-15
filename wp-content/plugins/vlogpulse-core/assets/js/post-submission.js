/**
 * Frontend Post & Vlog Submission Script
 * 
 * @package VlogPulse_Core
 */

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('vlogpulse-create-post-form');
    if (!form) return;

    const typeToggleBtns = form.querySelectorAll('.type-toggle-btn');
    const isVlogInput = document.getElementById('create-post-is-vlog');
    const videoUrlGroup = document.getElementById('vlog-video-url-group');
    const videoUrlInput = document.getElementById('create-post-video-url');
    const fileInput = document.getElementById('create-post-thumbnail');
    const dropzone = document.getElementById('create-post-dropzone');
    const previewContainer = document.getElementById('create-post-thumb-preview');
    const previewImg = document.getElementById('preview-image-tag');
    const submitBtn = form.querySelector('.create-post-submit-btn');
    const submitBtnText = submitBtn.querySelector('.btn-text');
    const feedbackBox = form.querySelector('.create-post-feedback');

    // 1. Post Type Switcher (Blog vs Vlog)
    typeToggleBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            typeToggleBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const type = this.getAttribute('data-type');
            if (type === 'vlog') {
                isVlogInput.value = '1';
                videoUrlGroup.style.display = 'block';
                videoUrlInput.setAttribute('required', 'required');
                videoUrlInput.focus();
            } else {
                isVlogInput.value = '0';
                videoUrlGroup.style.display = 'none';
                videoUrlInput.removeAttribute('required');
            }
        });
    });

    // 2. Thumbnail Preview
    if (fileInput && dropzone) {
        fileInput.addEventListener('change', function () {
            handleFileSelect(this.files);
        });

        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            dropzone.classList.add('drag-active');
        });

        dropzone.addEventListener('dragleave', function () {
            dropzone.classList.remove('drag-active');
        });

        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            dropzone.classList.remove('drag-active');
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelect(e.dataTransfer.files);
            }
        });
    }

    function handleFileSelect(files) {
        if (!files || !files[0]) return;
        const file = files[0];
        if (!file.type.match('image.*')) {
            alert('Please select an image file (PNG, JPG, WEBP).');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            if (previewImg && previewContainer) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
                dropzone.querySelector('.dropzone-prompt').style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }

    // 3. Form Submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Loading state
        submitBtn.disabled = true;
        const originalText = submitBtnText.textContent;
        submitBtnText.textContent = 'Publishing...';
        feedbackBox.innerHTML = '';
        feedbackBox.className = 'create-post-feedback';

        const formData = new FormData(form);
        formData.append('action', 'vlogpulse_submit_post');
        formData.append('security', window.vlogpulse_core_data ? window.vlogpulse_core_data.post_nonce : '');

        const ajaxUrl = window.vlogpulse_core_data ? window.vlogpulse_core_data.ajax_url : '/wp-admin/admin-ajax.php';

        fetch(ajaxUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtnText.textContent = originalText;

                if (data.success) {
                    feedbackBox.className = 'create-post-feedback success';
                    feedbackBox.textContent = data.data.message || 'Published successfully! Redirecting...';

                    if (window.AhanafToast) {
                        window.AhanafToast(data.data.message || 'Post published!', 'success');
                    }

                    setTimeout(() => {
                        window.location.href = data.data.redirect;
                    }, 1200);
                } else {
                    feedbackBox.className = 'create-post-feedback error';
                    feedbackBox.textContent = data.data.message || 'An error occurred. Please try again.';
                    if (window.AhanafToast) {
                        window.AhanafToast(data.data.message || 'Error publishing post', 'error');
                    }
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtnText.textContent = originalText;
                feedbackBox.className = 'create-post-feedback error';
                feedbackBox.textContent = 'Network or server error. Please try again.';
            });
    });
});
