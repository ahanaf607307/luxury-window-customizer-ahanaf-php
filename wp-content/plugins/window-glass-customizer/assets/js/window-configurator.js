/**
 * Live SVG Window Configurator & Real-Time Dynamic Price Engine
 * 
 * @package Window_Glass_Customizer
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
        model: {
            id: 'casement',
            name: 'Double Casement (Door Open/Close)',
            mechanism: 'door',
            cost: 35.00
        },
        hardware: {
            id: 'dual-gold',
            name: 'Dual Luxury Gold Handles',
            color: '#d4af37',
            cost: 45.00
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
    const modelButtons = studio.querySelectorAll('.grid-style-btn');
    const handleSwatches = studio.querySelectorAll('.handle-swatch-btn');
    const quantityInput = document.getElementById('window-order-qty');
    const orderBtn = document.getElementById('window-order-btn');
    const orderBtnText = orderBtn ? orderBtn.querySelector('.btn-text') : null;

    // DOM Elements - Live SVG Visualizer
    const svgStage = document.getElementById('window-svg-stage');
    const svgFrameOuter = document.getElementById('svg-frame-outer');
    const svgFrameInner = document.getElementById('svg-frame-inner');
    const svgGlassLeft = document.getElementById('svg-glass-left');
    const svgGlassRight = document.getElementById('svg-glass-right');
    const svgFrameLeftSash = document.getElementById('svg-frame-left-sash');
    const svgFrameRightSash = document.getElementById('svg-frame-right-sash');
    const svgSashLeft = document.getElementById('svg-sash-left');
    const svgSashRight = document.getElementById('svg-sash-right');

    const svgGridVertical = document.getElementById('svg-grid-vertical');
    const svgGridHorizontal = document.getElementById('svg-grid-horizontal');
    const svgGridExtraCols = document.getElementById('svg-grid-extra-cols');
    const svgGridExtraCols2 = document.getElementById('svg-grid-extra-cols-2');
    const svgGridExtraRows = document.getElementById('svg-grid-extra-rows');

    const svgHandleLeftGroup = document.getElementById('svg-handle-left');
    const svgHandleRightGroup = document.getElementById('svg-handle-right');
    const svgHandleLeftRect = document.getElementById('svg-handle-left-rect');
    const svgHandleRightRect = document.getElementById('svg-handle-right-rect');

    // Action Toolbar
    const toggleMechanismBtn = document.getElementById('toggle-mechanism-action-btn');
    const mechanismLabel = document.getElementById('mechanism-indicator-label');

    // DOM Elements - Displays & Labels
    const displayWidth = document.getElementById('display-dimension-w');
    const displayHeight = document.getElementById('display-dimension-h');
    const displayArea = document.getElementById('display-dimension-area');
    const displayModelName = document.getElementById('display-model-type');
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

    // 2. Frame Swatch Selector (Strictly changes frame color only)
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

    // 3. Glass Swatch Selector (Strictly changes glass fill only)
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

    // Mechanism Category Tabs Navigation
    const mechanismTabs = studio.querySelectorAll('.mechanism-nav-tab');
    const mechanismGrids = studio.querySelectorAll('.mechanism-models-grid');

    mechanismTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            mechanismTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const targetCategory = this.getAttribute('data-target-category');

            // Hide all model grids and show the target category grid
            mechanismGrids.forEach(grid => {
                grid.style.display = 'none';
                grid.classList.remove('active-category');
            });

            const activeGrid = document.getElementById(`category-models-${targetCategory}`);
            if (activeGrid) {
                activeGrid.style.display = 'grid';
                activeGrid.classList.add('active-category');

                // Automatically select first model in the new category
                const firstModelBtn = activeGrid.querySelector('.grid-style-btn');
                if (firstModelBtn) {
                    firstModelBtn.click();
                }
            }
        });
    });

    // 4. Window Mechanism & Architecture Model Selector
    modelButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Remove active from all model buttons in all grids
            modelButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            state.model.id = this.getAttribute('data-model-id');
            state.model.name = this.getAttribute('data-model-name');
            state.model.mechanism = this.getAttribute('data-model-mechanism') || 'door';
            state.model.cost = parseFloat(this.getAttribute('data-grid-cost')) || 0.00;

            // Reset motion state when switching models
            isMotionActive = false;
            resetMotionPositions();

            // Enforce Strict Handle Rules based on Mechanism:
            const stepHardwareBox = document.getElementById('step-hardware-box');

            if (state.model.mechanism === 'slide') {
                // Rule 1: Sliding models have NO handles (Touch / Push-to-Slide)
                state.hardware = {
                    id: 'none',
                    name: 'No Handles (Touch-Slide Push)',
                    color: 'transparent',
                    cost: 0.00
                };
                if (stepHardwareBox) {
                    stepHardwareBox.style.opacity = '0.4';
                    stepHardwareBox.style.pointerEvents = 'none';
                }
            } else if (state.model.mechanism === 'fixed') {
                // Rule 2: Fixed windows have NO handles
                state.hardware = {
                    id: 'none',
                    name: 'No Handles (Fixed Frame)',
                    color: 'transparent',
                    cost: 0.00
                };
                if (stepHardwareBox) {
                    stepHardwareBox.style.opacity = '0.4';
                    stepHardwareBox.style.pointerEvents = 'none';
                }
            } else {
                // Rule 3: Door Open/Close models ALWAYS have DUAL handles (Left & Right)
                if (stepHardwareBox) {
                    stepHardwareBox.style.opacity = '1';
                    stepHardwareBox.style.pointerEvents = 'auto';
                }
                // Pick active handle or default to gold
                const activeHandleBtn = studio.querySelector('.handle-swatch-btn.active[data-handle-id^="dual"]');
                if (activeHandleBtn) {
                    state.hardware.id = activeHandleBtn.getAttribute('data-handle-id');
                    state.hardware.name = activeHandleBtn.getAttribute('data-handle-name');
                    state.hardware.color = activeHandleBtn.getAttribute('data-handle-color');
                    state.hardware.cost = parseFloat(activeHandleBtn.getAttribute('data-handle-cost')) || 45.00;
                } else {
                    state.hardware = {
                        id: 'dual-gold',
                        name: 'Dual Luxury Gold Handles',
                        color: '#d4af37',
                        cost: 45.00
                    };
                    const goldBtn = studio.querySelector('.handle-swatch-btn[data-handle-id="dual-gold"]');
                    if (goldBtn) goldBtn.classList.add('active');
                }
            }

            updateMechanismToolbar();
            renderSVG();
            calculatePricing();
        });
    });

    // 5. Hardware / Handle Selector
    handleSwatches.forEach(btn => {
        btn.addEventListener('click', function () {
            // Only allow hardware selection if current model allows handles
            if (state.model.mechanism === 'slide' || state.model.mechanism === 'fixed') {
                return;
            }

            handleSwatches.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            state.hardware.id = this.getAttribute('data-handle-id');
            state.hardware.name = this.getAttribute('data-handle-name');
            state.hardware.color = this.getAttribute('data-handle-color');
            state.hardware.cost = parseFloat(this.getAttribute('data-handle-cost')) || 45.00;

            renderSVG();
            calculatePricing();
        });
    });

    // Update Toolbar Button text & icon based on mechanism
    function updateMechanismToolbar() {
        if (!toggleMechanismBtn) return;
        const iconSpan = toggleMechanismBtn.querySelector('.action-btn-icon');
        const textSpan = toggleMechanismBtn.querySelector('.action-btn-text');

        toggleMechanismBtn.classList.remove('active');

        if (state.model.mechanism === 'slide') {
            if (iconSpan) iconSpan.textContent = '↔️';
            if (textSpan) textSpan.textContent = 'Slide Open';
            if (mechanismLabel) mechanismLabel.textContent = '↔️ Mechanism: 2-Panel Sliding (Touch / No Handles)';
            toggleMechanismBtn.style.display = 'inline-flex';
        } else if (state.model.mechanism === 'door') {
            if (iconSpan) iconSpan.textContent = '🚪';
            if (textSpan) textSpan.textContent = 'Open Doors';
            if (mechanismLabel) mechanismLabel.textContent = '🚪 Mechanism: Double Casement Doors (Dual Handles)';
            toggleMechanismBtn.style.display = 'inline-flex';
        } else {
            if (mechanismLabel) mechanismLabel.textContent = '🔲 Mechanism: Fixed Panoramic (Seamless View)';
            toggleMechanismBtn.style.display = 'none';
        }
    }

    // 6. SVG Render Engine
    function renderSVG() {
        // Dynamic Aspect Ratio Sizing
        const baseWidth = 320;
        const aspect = state.width / state.height;
        const calculatedSvgHeight = Math.round(baseWidth / aspect);
        const clampedHeight = Math.max(240, Math.min(430, calculatedSvgHeight));
        const sashHeight = clampedHeight - 40;

        if (svgStage) {
            svgStage.setAttribute('viewBox', `0 0 360 ${clampedHeight}`);
        }

        // Master Outer Frame Casing (Layered firmly on top of sashes)
        if (svgFrameOuter) {
            svgFrameOuter.setAttribute('stroke', state.frame.color);
            svgFrameOuter.setAttribute('height', clampedHeight - 20);
        }
        const svgFrameBezel = document.getElementById('svg-frame-bezel');
        if (svgFrameBezel) {
            svgFrameBezel.setAttribute('height', clampedHeight - 38);
        }
        const svgBackdropView = document.getElementById('svg-backdrop-view');
        if (svgBackdropView) {
            svgBackdropView.setAttribute('height', clampedHeight - 28);
        }

        // Glass Fill (Strictly affects glass panes inside sashes)
        if (svgGlassLeft) {
            svgGlassLeft.setAttribute('fill', state.glass.fill);
            svgGlassLeft.setAttribute('height', sashHeight);
        }
        if (svgGlassRight) {
            svgGlassRight.setAttribute('fill', state.glass.fill);
            svgGlassRight.setAttribute('height', sashHeight);
        }

        // Frame Sash Outlines
        if (svgFrameLeftSash) {
            svgFrameLeftSash.setAttribute('stroke', state.frame.color);
            svgFrameLeftSash.setAttribute('height', sashHeight);
        }
        if (svgFrameRightSash) {
            svgFrameRightSash.setAttribute('stroke', state.frame.color);
            svgFrameRightSash.setAttribute('height', sashHeight);
        }

        // Sash-attached Internal Grid Lines
        const svgGridLeftH = document.getElementById('svg-grid-left-h');
        const svgGridLeftH2 = document.getElementById('svg-grid-left-h2');
        const svgGridLeftH3 = document.getElementById('svg-grid-left-h3');
        const svgGridLeftV = document.getElementById('svg-grid-left-v');

        const svgGridRightH = document.getElementById('svg-grid-right-h');
        const svgGridRightH2 = document.getElementById('svg-grid-right-h2');
        const svgGridRightH3 = document.getElementById('svg-grid-right-h3');
        const svgGridRightV = document.getElementById('svg-grid-right-v');

        // Reset all sash grids
        [svgGridLeftH, svgGridLeftH2, svgGridLeftH3, svgGridLeftV, svgGridRightH, svgGridRightH2, svgGridRightH3, svgGridRightV].forEach(el => {
            if (el) el.style.display = 'none';
        });

        if (state.model.id === 'four-grid' || state.model.id === 'sliding-colonial' || state.model.id === 'four-grid-fixed') {
            [svgGridLeftH, svgGridRightH].forEach(el => {
                if (el) {
                    el.style.display = 'block';
                    el.setAttribute('stroke', state.frame.color);
                    el.setAttribute('y1', clampedHeight / 2);
                    el.setAttribute('y2', clampedHeight / 2);
                }
            });
        } else if (state.model.id === 'six-grid') {
            [svgGridLeftH2, svgGridLeftH3, svgGridRightH2, svgGridRightH3].forEach(el => {
                if (el) {
                    el.style.display = 'block';
                    el.setAttribute('stroke', state.frame.color);
                }
            });
            if (svgGridLeftH2) { svgGridLeftH2.setAttribute('y1', clampedHeight * 0.35); svgGridLeftH2.setAttribute('y2', clampedHeight * 0.35); }
            if (svgGridRightH2) { svgGridRightH2.setAttribute('y1', clampedHeight * 0.35); svgGridRightH2.setAttribute('y2', clampedHeight * 0.35); }
            if (svgGridLeftH3) { svgGridLeftH3.setAttribute('y1', clampedHeight * 0.65); svgGridLeftH3.setAttribute('y2', clampedHeight * 0.65); }
            if (svgGridRightH3) { svgGridRightH3.setAttribute('y1', clampedHeight * 0.65); svgGridRightH3.setAttribute('y2', clampedHeight * 0.65); }
        } else if (state.model.id === 'eight-grid') {
            [svgGridLeftH, svgGridLeftV, svgGridRightH, svgGridRightV].forEach(el => {
                if (el) {
                    el.style.display = 'block';
                    el.setAttribute('stroke', state.frame.color);
                }
            });
            if (svgGridLeftH && svgGridRightH) {
                [svgGridLeftH, svgGridRightH].forEach(el => {
                    el.setAttribute('y1', clampedHeight / 2);
                    el.setAttribute('y2', clampedHeight / 2);
                });
            }
            if (svgGridLeftV && svgGridRightV) {
                svgGridLeftV.setAttribute('y2', clampedHeight - 20);
                svgGridRightV.setAttribute('y2', clampedHeight - 20);
            }
        }

        // Handles (Dual on both panels for doors, none for sliding/fixed)
        const centerY = Math.round((clampedHeight / 2) - 20);

        if (state.hardware.id === 'none') {
            if (svgHandleLeftGroup) svgHandleLeftGroup.style.display = 'none';
            if (svgHandleRightGroup) svgHandleRightGroup.style.display = 'none';
        } else {
            // Dual Handles on both left & right sashes
            if (svgHandleLeftGroup && svgHandleRightGroup) {
                svgHandleLeftGroup.style.display = 'block';
                svgHandleRightGroup.style.display = 'block';

                if (svgHandleLeftRect) {
                    svgHandleLeftRect.setAttribute('fill', state.hardware.color);
                    svgHandleLeftRect.setAttribute('y', centerY);
                }
                const dotLeft = document.getElementById('svg-handle-left-dot');
                if (dotLeft) dotLeft.setAttribute('cy', centerY + 8);

                if (svgHandleRightRect) {
                    svgHandleRightRect.setAttribute('fill', state.hardware.color);
                    svgHandleRightRect.setAttribute('y', centerY);
                }
                const dotRight = document.getElementById('svg-handle-right-dot');
                if (dotRight) dotRight.setAttribute('cy', centerY + 8);
            }
        }

        // Dimension Badge Displays
        if (displayWidth) displayWidth.textContent = `${state.width.toFixed(1)} ft`;
        if (displayHeight) displayHeight.textContent = `${state.height.toFixed(1)} ft`;
        if (displayArea) displayArea.textContent = `${(state.width * state.height).toFixed(1)} sq.ft`;
        if (displayModelName) displayModelName.textContent = state.model.name;
        if (displayGlassName) displayGlassName.textContent = state.glass.name;
        if (displayFrameName) displayFrameName.textContent = state.frame.name;
    }

    // 6.5 Interactive Mechanism Motion Engine (Door Swing vs Slide)
    let isMotionActive = false;

    function resetMotionPositions() {
        if (svgSashLeft) {
            svgSashLeft.style.transform = 'none';
            svgSashLeft.style.filter = 'none';
        }
        if (svgSashRight) {
            svgSashRight.style.transform = 'none';
            svgSashRight.style.filter = 'none';
        }
    }

    if (toggleMechanismBtn) {
        toggleMechanismBtn.addEventListener('click', function () {
            isMotionActive = !isMotionActive;
            const textSpan = toggleMechanismBtn.querySelector('.action-btn-text');

            if (state.model.mechanism === 'slide') {
                // Horizontal Slide Animation
                if (isMotionActive) {
                    if (svgSashLeft) {
                        svgSashLeft.style.transformOrigin = '20px center';
                        svgSashLeft.style.transform = 'translateX(116px)';
                        svgSashLeft.style.filter = 'drop-shadow(4px 0 12px rgba(0,0,0,0.75))';
                    }
                    if (svgSashRight) {
                        svgSashRight.style.transform = 'none';
                    }
                    toggleMechanismBtn.classList.add('active');
                    if (textSpan) textSpan.textContent = 'Slide Close ✖';
                } else {
                    resetMotionPositions();
                    toggleMechanismBtn.classList.remove('active');
                    if (textSpan) textSpan.textContent = 'Slide Open ↔️';
                }
            } else if (state.model.mechanism === 'door') {
                // 3D Door Swing Outward Animation (Clean anchor under outer frame casing)
                if (isMotionActive) {
                    if (svgSashLeft) {
                        svgSashLeft.style.transformOrigin = '20px 50%';
                        svgSashLeft.style.transform = 'perspective(900px) rotateY(-56deg)';
                        svgSashLeft.style.filter = 'drop-shadow(-8px 4px 16px rgba(0,0,0,0.85))';
                    }
                    if (svgSashRight) {
                        svgSashRight.style.transformOrigin = '340px 50%';
                        svgSashRight.style.transform = 'perspective(900px) rotateY(56deg)';
                        svgSashRight.style.filter = 'drop-shadow(8px 4px 16px rgba(0,0,0,0.85))';
                    }
                    toggleMechanismBtn.classList.add('active');
                    if (textSpan) textSpan.textContent = 'Close Doors ✖';
                } else {
                    resetMotionPositions();
                    toggleMechanismBtn.classList.remove('active');
                    if (textSpan) textSpan.textContent = 'Open Doors 🚪';
                }
            }
        });
    }

    // 7. Math & Pricing Matrix Engine
    function calculatePricing() {
        const areaSqft = state.width * state.height;
        const perimeterFt = 2 * (state.width + state.height);

        const glassCost = areaSqft * state.glass.ratePerSqft;
        const frameCost = perimeterFt * state.frame.ratePerFt;
        const modelCost = state.model.cost;
        const hardwareCost = state.hardware.cost;

        state.totalPrice = state.baseFee + glassCost + frameCost + modelCost + hardwareCost;

        // Update displays
        if (displayGlassCost) displayGlassCost.textContent = `$${glassCost.toFixed(2)}`;
        if (displayFrameCost) displayFrameCost.textContent = `$${frameCost.toFixed(2)}`;
        if (displayGridCost) displayGridCost.textContent = `$${modelCost.toFixed(2)}`;
        if (displayHardwareCost) displayHardwareCost.textContent = `$${hardwareCost.toFixed(2)}`;
        if (displayTotalPrice) displayTotalPrice.textContent = `$${state.totalPrice.toFixed(2)}`;
    }

    // 8. Add Custom Window to WooCommerce Cart with Dynamic SVG Thumbnail Preview
    if (orderBtn) {
        orderBtn.addEventListener('click', function () {
            orderBtn.disabled = true;
            const originalText = orderBtnText ? orderBtnText.textContent : 'Order Custom Window';
            if (orderBtnText) orderBtnText.textContent = 'Adding to Cart...';

            const qty = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

            // Generate clean SVG preview snapshot string
            let svgPreviewSnapshot = '';
            if (svgStage) {
                const clonedSvg = svgStage.cloneNode(true);
                // Ensure transforms are reset in thumbnail snapshot
                const leftSashClone = clonedSvg.querySelector('#svg-sash-left');
                const rightSashClone = clonedSvg.querySelector('#svg-sash-right');
                if (leftSashClone) leftSashClone.style.transform = 'none';
                if (rightSashClone) rightSashClone.style.transform = 'none';

                clonedSvg.setAttribute('width', '100%');
                clonedSvg.setAttribute('height', '100%');
                clonedSvg.removeAttribute('id');
                clonedSvg.removeAttribute('class');

                const serializer = new XMLSerializer();
                svgPreviewSnapshot = serializer.serializeToString(clonedSvg);
            }

            const postData = new FormData();
            postData.append('action', 'vlogpulse_add_custom_window_to_cart');
            postData.append('security', window.vlogpulse_window_data ? window.vlogpulse_window_data.nonce : '');
            postData.append('width', state.width);
            postData.append('height', state.height);
            postData.append('area_sqft', (state.width * state.height).toFixed(2));
            postData.append('frame_name', state.frame.name);
            postData.append('glass_name', state.glass.name);
            postData.append('grid_name', state.model.name);
            postData.append('handle_name', state.hardware.name);
            postData.append('calculated_price', state.totalPrice.toFixed(2));
            postData.append('quantity', qty);
            postData.append('svg_preview', svgPreviewSnapshot);

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
                        }, 900);
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

    // Initial Setup
    updateMechanismToolbar();
    renderSVG();
    calculatePricing();
});

