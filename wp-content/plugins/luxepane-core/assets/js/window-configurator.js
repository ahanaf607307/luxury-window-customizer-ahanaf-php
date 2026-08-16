/**
 * Live SVG Window Configurator & Real-Time Dynamic Price Engine
 * 
 * @package VlogPulse_Core
 */

document.addEventListener('DOMContentLoaded', function () {
    const studio = document.getElementById('vlogpulse-window-studio');
    if (!studio) return;

    // Configurator State Object
    const state = {
        width: 4.0,
        height: 5.0,
        frame: {
            id: 'black',
            name: 'Obsidian Matte Black Aluminium',
            color: '#18181b',
            accent: '#27272a',
            ratePerFt: 8.00
        },
        glass: {
            id: 'clear',
            name: 'Crystal Clear Tempered Glass',
            fill: 'url(#glassClearGrad)',
            ratePerSqft: 12.00
        },
        grid: {
            id: 'single',
            name: 'Single Pane (Minimalist)',
            cost: 0.00
        },
        hardware: {
            id: 'gold',
            name: 'Signature Luxury Gold Handle',
            color: '#d4af37',
            cost: 35.00
        },
        baseFee: 50.00,
        totalPrice: 0.00
    };

    // DOM Elements - Inputs & Controls
    const widthSlider = document.getElementById('window-width-slider');
    const widthInput = document.getElementById('window-width-input');
    const heightSlider = document.getElementById('window-height-slider');
    const heightInput = document.getElementById('window-height-input');
    const frameSwatches = studio.querySelectorAll('.frame-swatch-btn');
    const glassSwatches = studio.querySelectorAll('.glass-swatch-btn');
    const gridButtons = studio.querySelectorAll('.grid-style-btn');
    const handleSwatches = studio.querySelectorAll('.handle-swatch-btn');
    const quantityInput = document.getElementById('window-order-qty');
    const orderBtn = document.getElementById('window-order-btn');
    const orderBtnText = orderBtn ? orderBtn.querySelector('.btn-text') : null;

    // DOM Elements - Live SVG Visualizer
    const svgStage = document.getElementById('window-svg-stage');
    const svgFrameOuter = document.getElementById('svg-frame-outer');
    const svgFrameInner = document.getElementById('svg-frame-inner');
    const svgGlassPane = document.getElementById('svg-glass-pane');
    const svgGridVertical = document.getElementById('svg-grid-vertical');
    const svgGridHorizontal = document.getElementById('svg-grid-horizontal');
    const svgGridExtraCols = document.getElementById('svg-grid-extra-cols');
    const svgGridExtraRows = document.getElementById('svg-grid-extra-rows');
    const svgHandle = document.getElementById('svg-hardware-handle');

    // DOM Elements - Displays & Labels
    const displayWidth = document.getElementById('display-dimension-w');
    const displayHeight = document.getElementById('display-dimension-h');
    const displayArea = document.getElementById('display-dimension-area');
    const displayGlassName = document.getElementById('display-glass-type');
    const displayFrameName = document.getElementById('display-frame-type');
    const displayTotalPrice = document.getElementById('display-total-price');
    const displayGlassCost = document.getElementById('breakdown-glass-cost');
    const displayFrameCost = document.getElementById('breakdown-frame-cost');
    const displayGridCost = document.getElementById('breakdown-grid-cost');
    const displayHardwareCost = document.getElementById('breakdown-hardware-cost');

    // 1. Dimensions Event Handlers
    function updateDimensions(w, h) {
        state.width = Math.max(2.0, Math.min(10.0, parseFloat(w) || 4.0));
        state.height = Math.max(2.0, Math.min(8.0, parseFloat(h) || 5.0));

        if (widthSlider) widthSlider.value = state.width;
        if (widthInput) widthInput.value = state.width.toFixed(1);
        if (heightSlider) heightSlider.value = state.height;
        if (heightInput) heightInput.value = state.height.toFixed(1);

        renderSVG();
        calculatePricing();
    }

    if (widthSlider && widthInput) {
        widthSlider.addEventListener('input', () => updateDimensions(widthSlider.value, state.height));
        widthInput.addEventListener('change', () => updateDimensions(widthInput.value, state.height));
    }
    if (heightSlider && heightInput) {
        heightSlider.addEventListener('input', () => updateDimensions(state.width, heightSlider.value));
        heightInput.addEventListener('change', () => updateDimensions(state.width, heightInput.value));
    }

    // 2. Frame Swatch Selector
    frameSwatches.forEach(btn => {
        btn.addEventListener('click', function () {
            frameSwatches.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            state.frame.id = this.getAttribute('data-frame-id');
            state.frame.name = this.getAttribute('data-frame-name');
            state.frame.color = this.getAttribute('data-frame-color');
            state.frame.accent = this.getAttribute('data-frame-accent') || '#333';
            state.frame.ratePerFt = parseFloat(this.getAttribute('data-frame-rate')) || 8.00;

            renderSVG();
            calculatePricing();
        });
    });

    // 3. Glass Swatch Selector
    glassSwatches.forEach(btn => {
        btn.addEventListener('click', function () {
            glassSwatches.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            state.glass.id = this.getAttribute('data-glass-id');
            state.glass.name = this.getAttribute('data-glass-name');
            state.glass.fill = this.getAttribute('data-glass-fill') || 'url(#glassClearGrad)';
            state.glass.ratePerSqft = parseFloat(this.getAttribute('data-glass-rate')) || 12.00;

            renderSVG();
            calculatePricing();
        });
    });

    // 4. Grid Pattern Selector
    gridButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            gridButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            state.grid.id = this.getAttribute('data-grid-id');
            state.grid.name = this.getAttribute('data-grid-name');
            state.grid.cost = parseFloat(this.getAttribute('data-grid-cost')) || 0.00;

            renderSVG();
            calculatePricing();
        });
    });

    // 5. Hardware / Handle Selector
    handleSwatches.forEach(btn => {
        btn.addEventListener('click', function () {
            handleSwatches.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            state.hardware.id = this.getAttribute('data-handle-id');
            state.hardware.name = this.getAttribute('data-handle-name');
            state.hardware.color = this.getAttribute('data-handle-color');
            state.hardware.cost = parseFloat(this.getAttribute('data-handle-cost')) || 0.00;

            renderSVG();
            calculatePricing();
        });
    });

    // 6. SVG Render Engine
    function renderSVG() {
        // Dynamic Aspect Ratio Sizing
        const baseWidth = 320;
        const aspect = state.width / state.height;
        const calculatedSvgHeight = Math.round(baseWidth / aspect);
        const clampedHeight = Math.max(220, Math.min(420, calculatedSvgHeight));

        if (svgStage) {
            svgStage.setAttribute('viewBox', `0 0 360 ${clampedHeight}`);
        }

        // Frame Colors
        if (svgFrameOuter) {
            svgFrameOuter.setAttribute('fill', state.frame.color);
            svgFrameOuter.setAttribute('height', clampedHeight);
        }
        if (svgFrameInner) {
            svgFrameInner.setAttribute('stroke', state.frame.accent);
            svgFrameInner.setAttribute('height', clampedHeight - 24);
        }

        // Glass Fill
        if (svgGlassPane) {
            svgGlassPane.setAttribute('fill', state.glass.fill);
            svgGlassPane.setAttribute('height', clampedHeight - 24);
        }

        // Grid Style Configurations
        const paneHeight = clampedHeight - 24;
        const gridStroke = state.frame.color;

        // Reset Grids
        if (svgGridVertical) svgGridVertical.style.display = 'none';
        if (svgGridHorizontal) svgGridHorizontal.style.display = 'none';
        if (svgGridExtraCols) svgGridExtraCols.style.display = 'none';
        if (svgGridExtraRows) svgGridExtraRows.style.display = 'none';

        if (state.grid.id === 'two-panel') {
            if (svgGridVertical) {
                svgGridVertical.style.display = 'block';
                svgGridVertical.setAttribute('stroke', gridStroke);
                svgGridVertical.setAttribute('y2', clampedHeight - 12);
            }
        } else if (state.grid.id === 'four-grid') {
            if (svgGridVertical && svgGridHorizontal) {
                svgGridVertical.style.display = 'block';
                svgGridVertical.setAttribute('stroke', gridStroke);
                svgGridVertical.setAttribute('y2', clampedHeight - 12);

                svgGridHorizontal.style.display = 'block';
                svgGridHorizontal.setAttribute('stroke', gridStroke);
                svgGridHorizontal.setAttribute('y1', clampedHeight / 2);
                svgGridHorizontal.setAttribute('y2', clampedHeight / 2);
            }
        } else if (state.grid.id === 'six-grid') {
            if (svgGridVertical && svgGridHorizontal && svgGridExtraRows) {
                svgGridVertical.style.display = 'block';
                svgGridVertical.setAttribute('stroke', gridStroke);
                svgGridVertical.setAttribute('y2', clampedHeight - 12);

                svgGridHorizontal.style.display = 'block';
                svgGridHorizontal.setAttribute('stroke', gridStroke);
                svgGridHorizontal.setAttribute('y1', clampedHeight * 0.33);
                svgGridHorizontal.setAttribute('y2', clampedHeight * 0.33);

                svgGridExtraRows.style.display = 'block';
                svgGridExtraRows.setAttribute('stroke', gridStroke);
                svgGridExtraRows.setAttribute('y1', clampedHeight * 0.66);
                svgGridExtraRows.setAttribute('y2', clampedHeight * 0.66);
            }
        }

        // 6. Sliding Sash & Handle Dynamic Configurations
        const centerY = Math.round((clampedHeight / 2) - 20);

        const svgHandleCenterGroup = document.getElementById('svg-handle-center');
        const svgHandleLeftGroup = document.getElementById('svg-handle-left');
        const svgHandleRightGroup = document.getElementById('svg-handle-right');
        const svgHandleLeftRect = document.getElementById('svg-handle-left-rect');
        const svgHandleRightRect = document.getElementById('svg-handle-right-rect');
        const svgFrameLeftSash = document.getElementById('svg-frame-left-sash');
        const svgFrameRightSash = document.getElementById('svg-frame-right-sash');

        if (svgFrameLeftSash) svgFrameLeftSash.setAttribute('stroke', state.frame.accent);
        if (svgFrameRightSash) svgFrameRightSash.setAttribute('stroke', state.frame.accent);
        if (svgFrameLeftSash) svgFrameLeftSash.setAttribute('height', paneHeight);
        if (svgFrameRightSash) svgFrameRightSash.setAttribute('height', paneHeight);

        // Reset Handle Groups
        if (svgHandleCenterGroup) svgHandleCenterGroup.style.display = 'none';
        if (svgHandleLeftGroup) svgHandleLeftGroup.style.display = 'none';
        if (svgHandleRightGroup) svgHandleRightGroup.style.display = 'none';

        if (state.hardware.id === 'none') {
            // No handles (Clean Frameless / Sliding Push)
        } else if (state.hardware.id.startsWith('dual')) {
            // Dual Handles (Both Left and Right Sashes)
            if (svgHandleLeftGroup && svgHandleRightGroup) {
                svgHandleLeftGroup.style.display = 'block';
                svgHandleRightGroup.style.display = 'block';

                if (svgHandleLeftRect) {
                    svgHandleLeftRect.setAttribute('fill', state.hardware.color);
                    svgHandleLeftRect.setAttribute('y', centerY);
                }
                const dotLeft = document.getElementById('svg-handle-left-dot');
                if (dotLeft) dotLeft.setAttribute('cy', centerY + 7);

                if (svgHandleRightRect) {
                    svgHandleRightRect.setAttribute('fill', state.hardware.color);
                    svgHandleRightRect.setAttribute('y', centerY);
                }
                const dotRight = document.getElementById('svg-handle-right-dot');
                if (dotRight) dotRight.setAttribute('cy', centerY + 7);
            }
        } else {
            // Single Center Handle (Always Middle Centered)
            if (svgHandleCenterGroup) {
                svgHandleCenterGroup.style.display = 'block';
                if (svgHandle) {
                    svgHandle.setAttribute('fill', state.hardware.color);
                    svgHandle.setAttribute('y', centerY);
                }
                const dotCenter = document.getElementById('svg-hardware-handle-dot');
                if (dotCenter) dotCenter.setAttribute('cy', centerY + 7);
            }
        }

        // Dimension Badge Displays
        if (displayWidth) displayWidth.textContent = `${state.width.toFixed(1)} ft`;
        if (displayHeight) displayHeight.textContent = `${state.height.toFixed(1)} ft`;
        if (displayArea) displayArea.textContent = `${(state.width * state.height).toFixed(1)} sq.ft`;
        if (displayGlassName) displayGlassName.textContent = state.glass.name;
        if (displayFrameName) displayFrameName.textContent = state.frame.name;
    }

    // 6.5 Interactive Sliding Window Mechanism Toggle
    let isWindowSlidOpen = false;
    const toggleSlideBtn = document.getElementById('toggle-slide-window-btn');
    const slidingSashLeft = document.getElementById('svg-sliding-sash-left');

    if (toggleSlideBtn && slidingSashLeft) {
        toggleSlideBtn.addEventListener('click', function () {
            isWindowSlidOpen = !isWindowSlidOpen;
            const slideBtnText = toggleSlideBtn.querySelector('.slide-btn-text');

            if (isWindowSlidOpen) {
                slidingSashLeft.style.transform = 'translateX(115px)';
                slidingSashLeft.style.filter = 'drop-shadow(3px 0 10px rgba(0,0,0,0.8))';
                toggleSlideBtn.classList.add('active');
                if (slideBtnText) slideBtnText.textContent = 'Slide Close ✖';
            } else {
                slidingSashLeft.style.transform = 'translateX(0)';
                slidingSashLeft.style.filter = 'none';
                toggleSlideBtn.classList.remove('active');
                if (slideBtnText) slideBtnText.textContent = 'Slide Open ↔️';
            }
        });
    }

    // 7. Math & Pricing Matrix Engine
    function calculatePricing() {
        const areaSqft = state.width * state.height;
        const perimeterFt = 2 * (state.width + state.height);

        const glassCost = areaSqft * state.glass.ratePerSqft;
        const frameCost = perimeterFt * state.frame.ratePerFt;
        const gridCost = state.grid.cost;
        const hardwareCost = state.hardware.cost;

        state.totalPrice = state.baseFee + glassCost + frameCost + gridCost + hardwareCost;

        // Update displays
        if (displayGlassCost) displayGlassCost.textContent = `$${glassCost.toFixed(2)}`;
        if (displayFrameCost) displayFrameCost.textContent = `$${frameCost.toFixed(2)}`;
        if (displayGridCost) displayGridCost.textContent = `$${gridCost.toFixed(2)}`;
        if (displayHardwareCost) displayHardwareCost.textContent = `$${hardwareCost.toFixed(2)}`;
        if (displayTotalPrice) displayTotalPrice.textContent = `$${state.totalPrice.toFixed(2)}`;
    }

    // 8. Add Custom Window to WooCommerce Cart
    if (orderBtn) {
        orderBtn.addEventListener('click', function () {
            orderBtn.disabled = true;
            const originalText = orderBtnText ? orderBtnText.textContent : 'Order Custom Window';
            if (orderBtnText) orderBtnText.textContent = 'Adding to Cart...';

            const qty = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

            const postData = new FormData();
            postData.append('action', 'vlogpulse_add_custom_window_to_cart');
            postData.append('security', window.vlogpulse_window_data ? window.vlogpulse_window_data.nonce : '');
            postData.append('width', state.width);
            postData.append('height', state.height);
            postData.append('area_sqft', (state.width * state.height).toFixed(2));
            postData.append('frame_name', state.frame.name);
            postData.append('glass_name', state.glass.name);
            postData.append('grid_name', state.grid.name);
            postData.append('handle_name', state.hardware.name);
            postData.append('calculated_price', state.totalPrice.toFixed(2));
            postData.append('quantity', qty);

            const ajaxUrl = window.vlogpulse_window_data ? window.vlogpulse_window_data.ajax_url : '/wp-admin/admin-ajax.php';

            fetch(ajaxUrl, {
                method: 'POST',
                body: postData,
                credentials: 'same-origin'
            })
                .then(res => res.json())
                .then(data => {
                    orderBtn.disabled = false;
                    if (orderBtnText) orderBtnText.textContent = originalText;

                    if (data.success) {
                        if (window.AhanafToast) {
                            window.AhanafToast(data.data.message || 'Custom window added to cart!', 'success');
                        }

                        // Refresh header cart badge counter
                        const cartBadge = document.querySelector('.cart-count-badge');
                        if (cartBadge && data.data.cart_count !== undefined) {
                            cartBadge.textContent = data.data.cart_count;
                        }

                        // Redirect to cart after short delay
                        setTimeout(() => {
                            window.location.href = data.data.cart_url || '/cart/';
                        }, 1000);
                    } else {
                        if (window.AhanafToast) {
                            window.AhanafToast(data.data.message || 'Failed to add to cart.', 'error');
                        }
                    }
                })
                .catch(err => {
                    orderBtn.disabled = false;
                    if (orderBtnText) orderBtnText.textContent = originalText;
                    if (window.AhanafToast) {
                        window.AhanafToast('Network error, please try again.', 'error');
                    }
                });
        });
    }

    // Initial Render & Calculation on Load
    renderSVG();
    calculatePricing();
});
