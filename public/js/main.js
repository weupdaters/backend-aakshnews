document.addEventListener('DOMContentLoaded', () => {
    // 1. Font Size Controls
    let currentFontSize = 16; // default in px
    const fontMinus = document.getElementById('font-minus');
    const fontReset = document.getElementById('font-reset');
    const fontPlus = document.getElementById('font-plus');

    const updateFontSize = (size) => {
        currentFontSize = size;
        document.documentElement.style.setProperty('--base-font-size', `${size}px`);
        localStorage.setItem('baseFontSize', size);
    };

    // Load saved font size
    const savedFontSize = localStorage.getItem('baseFontSize');
    if (savedFontSize) {
        updateFontSize(parseInt(savedFontSize));
    }

    // 1.1 Push Notification (Allow) Manager
    const bellBtn = document.getElementById('notification-bell-btn');

    const updateBellUI = () => {
        if (!bellBtn) return;
        if (!("Notification" in window)) {
            bellBtn.style.display = 'none';
            return;
        }
        if (Notification.permission === 'granted') {
            bellBtn.style.color = '#38a169'; // Green active color
            bellBtn.title = 'Notifications Enabled';
            const bellIcon = bellBtn.querySelector('i');
            if (bellIcon) {
                bellIcon.style.stroke = '#38a169';
                bellIcon.style.fill = 'rgba(56, 161, 105, 0.2)';
            }
        } else if (Notification.permission === 'denied') {
            bellBtn.style.opacity = '0.4';
            bellBtn.title = 'Notifications Blocked';
        } else {
            bellBtn.style.opacity = '1';
            bellBtn.style.color = 'var(--text-main)';
            bellBtn.title = 'Enable Notifications';
        }
    };

    const requestPushPermission = () => {
        if (!("Notification" in window)) return;

        Notification.requestPermission().then((permission) => {
            updateBellUI();
            if (permission === "granted") {
                new Notification("Aakash News 24", {
                    body: "Thank you for subscribing! You will now receive breaking news notifications.",
                    icon: "/images/logo.png"
                });
                createToast("Notifications enabled successfully!");
            }
        });
    };

    const showPushOptInBanner = () => {
        if (!("Notification" in window)) return;
        if (Notification.permission !== 'default') return;
        if (sessionStorage.getItem('push-banner-dismissed')) return;

        // Check if banner already exists
        if (document.querySelector('.push-notify-banner')) return;

        const banner = document.createElement('div');
        banner.className = 'push-notify-banner';
        banner.innerHTML = `
            <div class="push-notify-header">
                <div class="push-notify-icon">
                    <i data-feather="bell"></i>
                </div>
                <span class="push-notify-title" style="font-size: 1rem; font-weight: 700; color: var(--text-main);">Enable Notifications</span>
            </div>
            <div class="push-notify-desc" style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.4; margin: 8px 0;">
                Get the latest breaking news alerts and real-time updates from Aakash News 24 directly on your screen.
            </div>
            <div class="push-notify-actions" style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 12px;">
                <button class="push-notify-btn later" id="push-later-btn" style="padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: 1px solid var(--border-color); background: transparent; color: var(--text-muted);">Later</button>
                <button class="push-notify-btn allow" id="push-allow-btn" style="padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: none; background: var(--primary-color); color: #fff;">Allow</button>
            </div>
        `;
        
        // Custom styling helper directly injected to make banner look professional without css conflicts
        banner.style.cssText = 'position: fixed; bottom: 24px; left: 24px; background: var(--bg-card); border: 1px solid var(--border-color); box-shadow: var(--box-shadow); border-radius: var(--border-radius); padding: 20px; z-index: 9999; max-width: 360px; display: flex; flex-direction: column; transform: translateY(150%); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);';
        
        document.body.appendChild(banner);
        
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        setTimeout(() => {
            banner.style.transform = 'translateY(0)';
        }, 1500);

        document.getElementById('push-allow-btn').addEventListener('click', () => {
            banner.style.transform = 'translateY(150%)';
            setTimeout(() => banner.remove(), 400);
            requestPushPermission();
        });

        document.getElementById('push-later-btn').addEventListener('click', () => {
            banner.style.transform = 'translateY(150%)';
            setTimeout(() => banner.remove(), 400);
            sessionStorage.setItem('push-banner-dismissed', 'true');
        });
    };

    // Initialize Bell UI and set auto banner timer
    updateBellUI();
    setTimeout(showPushOptInBanner, 2000);

    if (bellBtn) {
        bellBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (!("Notification" in window)) {
                alert("This browser does not support desktop notifications.");
                return;
            }
            if (Notification.permission === 'granted') {
                new Notification("Aakash News 24", {
                    body: "Notifications are already enabled! You're good to go.",
                    icon: "/images/logo.png"
                });
            } else if (Notification.permission === 'denied') {
                alert("Notifications are currently blocked. Please reset site permissions in your browser settings to enable them.");
            } else {
                requestPushPermission();
            }
        });
    }

    const triggerPushNotification = () => {
        requestPushPermission();
    };

    if (fontMinus) {
        fontMinus.addEventListener('click', () => {
            if (currentFontSize > 12) updateFontSize(currentFontSize - 2);
        });
    }
    if (fontReset) {
        fontReset.addEventListener('click', () => {
            updateFontSize(16);
        });
    }
    if (fontPlus) {
        fontPlus.addEventListener('click', () => {
            if (currentFontSize < 22) updateFontSize(currentFontSize + 2);
        });
    }

    // 2. Theme Toggle (Light / Dark)
    const themeToggleBtn = document.getElementById('theme-toggle-btn');
    const themeIcon = themeToggleBtn ? themeToggleBtn.querySelector('i') : null;

    const toggleTheme = () => {
        const isDark = document.body.classList.toggle('dark-theme');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        if (themeIcon) {
            themeIcon.setAttribute('data-feather', isDark ? 'sun' : 'moon');
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
    };

    // Load saved theme
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
        if (themeIcon) {
            themeIcon.setAttribute('data-feather', 'sun');
        }
    } else {
        document.body.classList.remove('dark-theme');
        if (themeIcon) {
            themeIcon.setAttribute('data-feather', 'moon');
        }
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', toggleTheme);
    }

    // 3. Mobile Sidebar Drawer
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    const openSidebar = () => {
        mobileSidebar.classList.add('open');
        sidebarOverlay.classList.add('show');
    };

    const closeSidebar = () => {
        mobileSidebar.classList.remove('open');
        sidebarOverlay.classList.remove('show');
    };

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openSidebar);
    if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    // 4. Breaking News Slider Ticker
    const slides = document.querySelectorAll('.breaking-slide');
    const prevBtn = document.getElementById('breaking-prev');
    const nextBtn = document.getElementById('breaking-next');
    let currentSlide = 0;
    let slideInterval;

    const showSlide = (index) => {
        slides.forEach(slide => slide.classList.remove('active'));

        currentSlide = index;
        if (currentSlide >= slides.length) currentSlide = 0;
        if (currentSlide < 0) currentSlide = slides.length - 1;

        slides[currentSlide].classList.add('active');
    };

    const nextSlide = () => showSlide(currentSlide + 1);
    const prevSlide = () => showSlide(currentSlide - 1);

    const startSlideShow = () => {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    };

    if (slides.length > 0) {
        showSlide(0);
        startSlideShow();

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                startSlideShow();
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                startSlideShow();
            });
        }
    }

    // 5. Photo Gallery Carousel navigation
    const carousel = document.getElementById('gallery-carousel');
    const carouselPrev = document.getElementById('gallery-prev');
    const carouselNext = document.getElementById('gallery-next');

    if (carousel) {
        if (carouselPrev) {
            carouselPrev.addEventListener('click', () => {
                carousel.scrollBy({ left: -200, behavior: 'smooth' });
            });
        }
        if (carouselNext) {
            carouselNext.addEventListener('click', () => {
                carousel.scrollBy({ left: 200, behavior: 'smooth' });
            });
        }
    }

    // 6. Newsletter Subscription API Form
    const newsletterForm = document.getElementById('newsletter-form');
    const subModal = document.getElementById('subscribed-modal');
    const subModalMsg = document.getElementById('subscribed-modal-message');
    const subModalClose = document.getElementById('subscribed-modal-close');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector('.newsletter-input');
            const email = emailInput.value.trim();

            if (!email) return;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch('/api/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify({ email })
                });
                const result = await response.json();

                if (response.ok && result.success) {
                    if (subModalMsg) subModalMsg.innerText = result.message;
                    if (subModal) subModal.classList.add('show');
                    emailInput.value = '';
                    // Trigger push notification request & show one push
                    triggerPushNotification();
                } else {
                    alert(result.message || 'त्रुटि: कृपया पुनः प्रयास करें।');
                }
            } catch (err) {
                console.error(err);
                alert('सर्वर से कनेक्ट करने में असमर्थ।');
            }
        });
    }

    if (subModalClose && subModal) {
        subModalClose.addEventListener('click', () => {
            subModal.classList.remove('show');
        });
    }

    // 7. Interactive Toast for general News Cards
    const createToast = (message) => {
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.innerHTML = `
            <div style="background-color: var(--bg-card); color: var(--text-main); border-left: 4px solid var(--primary-color); padding: 15px 20px; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 10px;">
                <i data-feather="info" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                <span style="font-weight: 600; font-size: 0.9rem;">${message}</span>
            </div>
        `;

        // Custom styling for container
        toast.style.position = 'fixed';
        toast.style.bottom = '30px';
        toast.style.right = '30px';
        toast.style.zIndex = '500';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        toast.style.transition = 'all 0.3s ease';

        document.body.appendChild(toast);
        
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 100);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // Attach click events on news items for premium interactive feel
    const interactiveElements = document.querySelectorAll('.hero-large-card, .middle-stack-card, .panel-item, .news-card, .category-news-item');
    interactiveElements.forEach(elem => {
        elem.addEventListener('click', (e) => {
            // Check if user clicked on nested button or link inside
            if (e.target.closest('button') || e.target.closest('a')) return;

            const articleId = elem.getAttribute('data-id');
            if (articleId) {
                // Determine the current language parameter if any
                const urlParams = new URLSearchParams(window.location.search);
                const currentLang = urlParams.get('lang') || 'en';
                // Redirect directly to the article detail view without requiring login!
                window.location.href = `/?article_id=${articleId}&lang=${currentLang}`;
                return;
            }
        });
    });

    // Bookmark toggles
    const bookmarkBtns = document.querySelectorAll('.bookmark-icon-btn, .news-card-footer i.fa-bookmark');
    bookmarkBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isBookmarked = btn.classList.toggle('bookmark-active');
            if (isBookmarked) {
                createToast('समाचार बुकमार्क कर लिया गया है!');
            } else {
                createToast('बुकमार्क हटा दिया गया!');
            }
        });
    });

    // 8. Instagram Video Modal & Submit Handler
    const addInstaBtn = document.getElementById('add-instagram-video-btn');
    const instaModal = document.getElementById('instagram-video-modal');
    const instaClose = document.getElementById('instagram-modal-close');
    const instaCancel = document.getElementById('instagram-modal-cancel-btn');
    const instaForm = document.getElementById('add-instagram-video-form');
    const instaContainer = document.getElementById('instagram-videos-container');
    const noInstaDiv = document.getElementById('no-instagram-videos');

    if (addInstaBtn && instaModal) {
        addInstaBtn.addEventListener('click', () => {
            instaModal.classList.add('show');
            if (sidebarOverlay) sidebarOverlay.classList.add('show');
        });
    }

    const closeInstaModal = () => {
        if (instaModal) instaModal.classList.remove('show');
        if (sidebarOverlay) sidebarOverlay.classList.remove('show');
        if (instaForm) instaForm.reset();
    };

    if (instaClose) instaClose.addEventListener('click', closeInstaModal);
    if (instaCancel) instaCancel.addEventListener('click', closeInstaModal);
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            closeInstaModal();
        });
    }

    if (instaForm) {
        instaForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const titleInput = document.getElementById('insta-title');
            const urlInput = document.getElementById('insta-url');
            const title = titleInput.value.trim();
            const url = urlInput.value.trim();

            if (!url) return;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch('/api/instagram-videos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify({ title, url })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    closeInstaModal();
                    createToast(result.message);

                    // Add new video card to the container dynamically
                    if (noInstaDiv) noInstaDiv.remove();

                    const video = result.video;
                    const card = document.createElement('div');
                    card.className = 'instagram-card';
                    card.style.cssText = 'background: var(--bg-card); border-radius: 12px; box-shadow: var(--box-shadow); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease;';
                    card.innerHTML = `
                        <div style="position: relative; width: 100%; padding-top: 120%; background: #000;">
                            <iframe src="${video.embed_url}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowtransparency="true" allow="encrypted-media" scrolling="no"></iframe>
                        </div>
                        <div style="padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                                    <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 8px; color: var(--text-main); flex-grow: 1;">${video.title || 'इंस्टाग्राम वीडियो'}</h4>
                                    <button class="delete-insta-btn" data-id="${video.id}" style="background: none; border: none; color: #e53e3e; cursor: pointer; font-size: 0.95rem; padding: 4px; transition: transform 0.2s;" title="वीडियो हटाएं">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <span style="font-size: 0.8rem; color: var(--text-muted);"><i class="far fa-clock"></i> अभी-अभी</span>
                        </div>
                    `;
                    if (instaContainer) {
                        instaContainer.insertBefore(card, instaContainer.firstChild);
                    }
                } else {
                    alert(result.message || 'त्रुटि: वीडियो जोड़ने में असमर्थ।');
                }
            } catch (err) {
                console.error(err);
                alert('सर्वर से कनेक्ट करने में असमर्थ।');
            }
        });
    }

    // 9. Delete Instagram Video Handler
    if (instaContainer) {
        instaContainer.addEventListener('click', async (e) => {
            const deleteBtn = e.target.closest('.delete-insta-btn');
            if (!deleteBtn) return;

            const videoId = deleteBtn.getAttribute('data-id');
            const card = deleteBtn.closest('.instagram-card');

            if (!confirm('क्या आप सचमुच इस इंस्टाग्राम वीडियो को हटाना चाहते हैं?')) {
                return;
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch(`/api/instagram-videos/${videoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || ''
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    createToast(result.message);
                    
                    // Smooth visual fade-out transition
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        card.remove();
                        // Show empty state if no videos are left
                        const remainingCards = instaContainer.querySelectorAll('.instagram-card');
                        if (remainingCards.length === 0) {
                            instaContainer.innerHTML = `
                                <div id="no-instagram-videos" style="grid-column: 1 / -1; text-align: center; padding: 40px; background: var(--bg-card); border-radius: 12px; color: var(--text-muted);">
                                    <i class="fab fa-instagram" style="font-size: 3rem; color: #ddd; margin-bottom: 10px; display: block;"></i>
                                    <span>अभी तक कोई इंस्टाग्राम वीडियो नहीं जोड़ा गया है। पहला वीडियो जोड़ने के लिए ऊपर दिए गए बटन पर क्लिक करें!</span>
                                </div>
                            `;
                        }
                    }, 500);
                } else {
                    alert(result.message || 'त्रुटि: वीडियो हटाने में असमर्थ।');
                }
            } catch (err) {
                console.error(err);
                alert('सर्वर से कनेक्ट करने में असमнения।');
            }
        });
    }

    // 10. Authentication Modal Logic (Laravel Page)
    const authModal = document.getElementById('auth-modal');
    const authModalCloseBtn = document.getElementById('auth-modal-close');
    const loginLinkBtn = document.getElementById('laravel-login-btn');
    const logoutLinkBtn = document.getElementById('laravel-logout-btn');
    const authSwitchBtn = document.getElementById('auth-switch-btn');
    const authForm = document.getElementById('auth-form');
    const authErrorDiv = document.getElementById('auth-error');

    let laravelAuthMode = 'login'; // 'login' or 'register'

    const updateAuthFormUI = () => {
        const modalTitle = document.getElementById('auth-modal-title');
        const nameGroup = document.getElementById('auth-name-group');
        const confirmGroup = document.getElementById('auth-confirm-group');
        const submitBtn = document.getElementById('auth-submit-btn');
        const switchPrompt = document.getElementById('auth-switch-prompt');

        if (laravelAuthMode === 'login') {
            modalTitle.textContent = 'Login';
            nameGroup.style.display = 'none';
            confirmGroup.style.display = 'none';
            submitBtn.textContent = 'Login';
            switchPrompt.textContent = "Don't have an account?";
            authSwitchBtn.textContent = 'Register Now';
            document.getElementById('auth-name').required = false;
            document.getElementById('auth-password-confirm').required = false;
        } else {
            modalTitle.textContent = 'Create New Account';
            nameGroup.style.display = 'block';
            confirmGroup.style.display = 'block';
            submitBtn.textContent = 'Register';
            switchPrompt.textContent = 'Already have an account?';
            authSwitchBtn.textContent = 'Login Now';
            document.getElementById('auth-name').required = true;
            document.getElementById('auth-password-confirm').required = true;
        }
    };

    if (loginLinkBtn) {
        loginLinkBtn.addEventListener('click', (e) => {
            e.preventDefault();
            laravelAuthMode = 'login';
            updateAuthFormUI();
            if (authErrorDiv) authErrorDiv.style.display = 'none';
            if (authModal) authModal.classList.add('show');
            if (sidebarOverlay) sidebarOverlay.classList.add('show');
        });
    }

    if (authModalCloseBtn) {
        authModalCloseBtn.addEventListener('click', () => {
            if (authModal) authModal.classList.remove('show');
            if (sidebarOverlay) sidebarOverlay.classList.remove('show');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            if (authModal) authModal.classList.remove('show');
        });
    }

    if (authSwitchBtn) {
        authSwitchBtn.addEventListener('click', () => {
            laravelAuthMode = laravelAuthMode === 'login' ? 'register' : 'login';
            updateAuthFormUI();
            if (authErrorDiv) authErrorDiv.style.display = 'none';
        });
    }

    // Handle authentication form submission
    if (authForm) {
        authForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (authErrorDiv) authErrorDiv.style.display = 'none';

            const name = document.getElementById('auth-name').value;
            const email = document.getElementById('auth-email').value;
            const password = document.getElementById('auth-password').value;
            const passwordConfirmation = document.getElementById('auth-password-confirm').value;

            if (laravelAuthMode === 'register' && password !== passwordConfirmation) {
                if (authErrorDiv) {
                    authErrorDiv.textContent = 'Password and password confirmation do not match.';
                    authErrorDiv.style.display = 'block';
                }
                return;
            }

            const endpoint = laravelAuthMode === 'login' ? '/api/login' : '/api/register';
            const payload = laravelAuthMode === 'login' 
                ? { email, password }
                : { name, email, password, password_confirmation: passwordConfirmation };

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify(payload)
                });

                const result = await res.json();

                if (res.ok && result.success) {
                    if (authModal) authModal.classList.remove('show');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('show');
                    
                    // Show success toast
                    createToast(result.message);
                    
                    // Reload to update authentication state dynamically across page templates
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    if (authErrorDiv) {
                        authErrorDiv.textContent = result.message || 'Error: Please try again.';
                        authErrorDiv.style.display = 'block';
                    }
                }
            } catch (err) {
                console.error(err);
                if (authErrorDiv) {
                    authErrorDiv.textContent = 'Unable to contact server.';
                    authErrorDiv.style.display = 'block';
                }
            }
        });
    }

    // Handle Logout
    if (logoutLinkBtn) {
        logoutLinkBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            if (!confirm('Are you sure you want to log out?')) return;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    }
                });

                const result = await res.json();

                if (res.ok && result.success) {
                    createToast(result.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(result.message || 'Unable to log out.');
                }
            } catch (err) {
                console.error(err);
                alert('Unable to contact server.');
            }
        });
    }

    // Subscribe button click handler
    const headerSubscribeBtn = document.getElementById('header-subscribe-btn');
    if (headerSubscribeBtn) {
        headerSubscribeBtn.addEventListener('click', () => {
            const newsletterSection = document.querySelector('.newsletter-bar');
            if (newsletterSection) {
                newsletterSection.scrollIntoView({ behavior: 'smooth' });
            }
            triggerPushNotification();
        });
    }

    // 11. Today's Horoscope (Rashifal) Daily predictions
    const horoscopeData = {
        aries: {
            en: "Today brings fresh energy. Focus on career opportunities and take action on pending tasks. Financial gains are likely.",
            hi: "आज का दिन नई ऊर्जा लेकर आएगा। अपने करियर पर ध्यान केंद्रित करें और अटके हुए कार्यों को पूरा करें। धन लाभ के योग हैं।",
            pb: "ਅੱਜ ਦਾ ਦਿਨ ਨਵੀਂ ਊਰਜਾ ਲੈ ਕੇ ਆਵੇਗਾ। ਆਪਣੇ ਕਰੀਅਰ 'ਤੇ ਧਿਆਨ ਦਿਓ ਅਤੇ ਅਧੂਰੇ ਕੰਮਾਂ ਨੂੰ ਪੂਰਾ ਕਰੋ। ਧਨ ਲਾਭ ਦੇ ਯੋਗ ਹਨ।"
        },
        taurus: {
            en: "Patience will be your greatest asset today. Avoid arguments at the workplace. Health remains stable.",
            hi: "आज धैर्य आपका सबसे बड़ा गुण रहेगा। कार्यक्षेत्र में वाद-विवाद से बचें। स्वास्थ्य स्थिर रहेगा।",
            pb: "ਅੱਜ ਸਬਰ ਤੁਹਾਡਾ ਸਭ ਤੋਂ ਵੱਡਾ ਗੁਣ ਰਹੇਗਾ। ਕੰਮ ਵਾਲੀ ਥਾਂ 'ਤੇ ਬਹਿਸਬਾਜ਼ੀ ਤੋਂ ਬਚੋ। ਸਿਹਤ ਠੀਕ ਰਹੇਗੀ।"
        },
        gemini: {
            en: "A great day for social interactions. Your creativity is high, and a family gathering will bring joy.",
            hi: "सामाजिक मेलजोल के लिए बेहतरीन दिन है। आपकी रचनात्मकता चरम पर रहेगी और पारिवारिक मिलन खुशी लाएगा।",
            pb: "ਸਮਾਜਿਕ ਮੇਲ-ਜੋਲ ਲਈ ਵਧੀਆ ਦਿਨ ਹੈ। ਤੁਹਾਡੀ ਸਿਰਜਣਾਤਮਕਤਾ ਉੱਚੀ ਰਹੇਗੀ ਅਤੇ ਪਰਿਵਾਰਕ ਮਿਲਣੀ ਖੁਸ਼ੀ ਲਿਆਵੇਗੀ।"
        },
        cancer: {
            en: "Focus on domestic harmony today. Financial decisions should be made carefully. Take time to meditate.",
            hi: "आज घरेलू शांति पर ध्यान दें। वित्तीय निर्णय सोच-समझकर लें। ध्यान लगाने के लिए समय निकालें।",
            pb: "ਅੱਜ ਘਰੇਲੂ ਸ਼ਾਂਤੀ 'ਤੇ ਧਿਆਨ ਦਿਓ। ਵਿੱਤੀ ਫੈਸਲੇ ਸਮਝਦਾਰੀ ਨਾਲ ਲਓ। ਮਨਨ ਕਰਨ ਲਈ ਸਮਾਂ ਕੱਢੋ।"
        },
        leo: {
            en: "Your confidence will open new doors. Leadership opportunities are coming your way. Keep a check on your temper.",
            hi: "आपका आत्मविश्वास नए रास्ते खोलेगा। नेतृत्व के अवसर आपके सामने आएंगे। अपने गुस्से पर नियंत्रण रखें।",
            pb: "ਤੁਹਾਡਾ ਆਤਮਵਿਸ਼ਵਾਸ ਨਵੇਂ ਰਸਤੇ ਖੋਲ੍ਹੇਗਾ। ਅਗਵਾਈ ਦੇ ਮੌਕੇ ਤੁਹਾਡੇ ਸਾਹਮਣੇ ਆਉਣਗੇ। ਆਪਣੇ ਗੁੱਸੇ 'ਤੇ ਕਾਬੂ ਰੱਖੋ।"
        },
        virgo: {
            en: "Analyze your investments today. A good time to start a new fitness regime. A friend might seek your advice.",
            hi: "आज अपने निवेश का विश्लेषण करें। नया फिटनेस रूटीन शुरू करने का अच्छा समय है। कोई मित्र आपकी सलाह ले सकता है।",
            pb: "ਅੱਜ ਆਪਣੇ ਨਿਵੇਸ਼ਾਂ ਦਾ ਵਿਸ਼ਲੇਸ਼ਣ ਕਰੋ। ਨਵਾਂ ਫਿਟਨੈਸ ਰੁਟੀਨ ਸ਼ੁਰੂ ਕਰਨ ਦਾ ਵਧੀਆ ਸਮਾਂ ਹੈ। ਕੋਈ ਦੋਸਤ ਤੁਹਾਡੀ ਸਲਾਹ ਲੈ ਸਕਦਾ ਹੈ।"
        },
        libra: {
            en: "Balance is key today. Your relationship with your partner will strengthen. A surprise is waiting for you.",
            hi: "आज संतुलन बनाए रखना महत्वपूर्ण है। जीवनसाथी के साथ संबंध मजबूत होंगे। आपके लिए कोई सरप्राइज इंतजार कर रहा है।",
            pb: "ਅੱਜ ਸੰਤੁਲਨ ਬਣਾਈ ਰੱਖਣਾ ਅਹਿਮ ਹੈ। ਜੀਵਨਸਾਥੀ ਨਾਲ ਸਬੰਧ ਮਜ਼ਬੂਤ ​​ਹੋਣਗੇ। ਤੁਹਾਡੇ ਲਈ ਕੋਈ ਤੋਹਫਾ ਉਡੀਕ ਰਿਹਾ ਹੈ।"
        },
        scorpio: {
            en: "Trust your intuition today. Work challenges will be resolved easily. Spend quality time with loved ones.",
            hi: "आज अपने अंतर्ज्ञान पर भरोसा करें। काम की चुनौतियां आसानी से हल हो जाएंगी। अपनों के साथ अच्छा समय बिताएं।",
            pb: "ਅੱਜ ਆਪਣੇ ਅੰਤਰ-ਗਿਆਨ 'ਤੇ ਭਰੋਸਾ ਕਰੋ। ਕੰਮ ਦੀਆਂ ਚੁਣੌਤੀਆਂ ਆਸਾਨੀ ਨਾਲ ਹੱਲ ਹੋ ਜਾਣਗੀਆਂ। ਆਪਣਿਆਂ ਨਾਲ ਚੰਗਾ ਸਮਾਂ ਬਿਤਾਓ।"
        },
        sagittarius: {
            en: "An optimistic outlook will guide you. Travel plans might finalize. Learning something new will benefit you.",
            hi: "सकारात्मक दृष्टिकोण आपका मार्गदर्शन करेगा। यात्रा की योजनाएं अंतिम रूप ले सकती हैं। कुछ नया सीखना फायदेमंद होगा।",
            pb: "ਸਕਾਰਾਤਮਕ ਨਜ਼ਰੀਆ ਤੁਹਾਡਾ ਮਾਰਗਦਰਸ਼ਨ ਕਰੇਗਾ। ਯਾਤਰਾ ਦੀਆਂ ਯੋਜਨਾਵਾਂ ਫਾਈਨਲ ਹੋ ਸਕਦੀਆਂ ਹਨ। ਕੁਝ ਨਵਾਂ ਸਿੱਖਣਾ ਫਾਇਦੇਮੰਦ ਹੋਵੇਗਾ।"
        },
        capricorn: {
            en: "Hard work pays off today. Your career dedication will be recognized. Focus on organizing your workspace.",
            hi: "आज कड़ी मेहनत का फल मिलेगा। आपके समर्पण की सराहना होगी। अपने कार्यक्षेत्र को व्यवस्थित करने पर ध्यान दें।",
            pb: "ਅੱਜ ਮਿਹਨਤ ਦਾ ਫਲ ਮਿਲੇਗਾ। ਤੁਹਾਡੀ ਲਗਨ ਦੀ ਸ਼ਲਾਘਾ ਕੀਤੀ ਜਾਵੇਗੀ। ਆਪਣੇ ਕੰਮ ਵਾਲੀ ਥਾਂ ਨੂੰ ਸੰਗਠਿਤ ਕਰਨ 'ਤੇ ਧਿਆਨ ਦਿਓ।"
        },
        aquarius: {
            en: "Innovative ideas will help you stand out. Financial clarity is expected. A good day for romantic life.",
            hi: "नवीन विचार आपको दूसरों से अलग बनाएंगे। वित्तीय स्थिरता की उम्मीद है। प्रेम जीवन के लिए अच्छा दिन है।",
            pb: "ਨਵੇਂ ਵਿਚਾਰ ਤੁਹਾਨੂੰ ਦੂਜਿਆਂ ਤੋਂ ਵੱਖਰਾ ਬਣਾਉਣਗੇ। ਵਿੱਤੀ ਸਥਿਰਤਾ ਦੀ ਉਮੀਦ ਹੈ। ਪ੍ਰੇਮ ਜੀਵਨ ਲਈ ਵਧੀਆ ਦਿਨ ਹੈ।"
        },
        pisces: {
            en: "Listen to your inner voice today. A spiritual journey or activity will calm you. Health is in perfect state.",
            hi: "आज अपनी अंतरात्मा की आवाज सुनें। कोई आध्यात्मिक यात्रा या गतिविधि आपको शांति देगी। स्वास्थ्य उत्तम रहेगा।",
            pb: "ਅੱਜ ਆਪਣੀ ਅੰਤਰ-ਆਤਮਾ ਦੀ ਆਵਾਜ਼ ਸੁਣੋ। ਕੋਈ ਅਧਿਆਤਮਿਕ ਯਾਤਰਾ ਜਾਂ ਗਤੀਵਿਧੀ ਤੁਹਾਨੂੰ ਸ਼ਾਂਤੀ ਦੇਵੇਗੀ। ਸਿਹਤ ਵਧੀਆ ਰਹੇਗੀ।"
        }
    };

    const horoscopeCards = document.querySelectorAll('.horoscope-card');
    horoscopeCards.forEach(card => {
        card.addEventListener('click', () => {
            const signId = card.getAttribute('data-sign');
            const lang = document.documentElement.getAttribute('lang') || 'en';
            const signData = horoscopeData[signId];
            if (!signData) return;

            const signEmoji = card.querySelector('span') ? card.querySelector('span').textContent.trim() : '';
            const nameSpan = card.querySelector('div span');
            const signName = nameSpan ? nameSpan.textContent.trim() : '';

            // Create or reuse modal
            let horoModal = document.getElementById('horo-modal');
            if (!horoModal) {
                horoModal = document.createElement('div');
                horoModal.id = 'horo-modal';
                horoModal.className = 'subscribed-modal';
                horoModal.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.9); background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 25px; z-index: 10000; max-width: 420px; width: 90%; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.3); opacity: 0; pointer-events: none; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);';
                document.body.appendChild(horoModal);
            }

            horoModal.innerHTML = `
                <div style="font-size: 3rem; margin-bottom: 12px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; width: 70px; height: 70px; background: var(--bg-main); border: 1px solid var(--border-color);">${signEmoji}</div>
                <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--text-main); margin: 0 0 5px 0;">${signName}</h3>
                <span style="font-size: 0.68rem; background: var(--primary-color); color: #fff; padding: 3px 12px; border-radius: 20px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">${lang === 'en' ? 'Today\'s Prediction' : (lang === 'pb' ? 'ਅੱਜ ਦਾ ਭਵਿੱਖਫਲ' : 'आज का राशिफल')}</span>
                <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.5; margin: 15px 0;">${signData[lang] || signData['en']}</p>
                <button id="horo-modal-close" style="background: var(--primary-color); color: #fff; border: none; padding: 10px 24px; border-radius: 25px; font-weight: 700; cursor: pointer; transition: all 0.2s; width: 100%; font-size: 0.9rem;">${lang === 'en' ? 'Close' : (lang === 'pb' ? 'ਬੰਦ ਕਰੋ' : 'बंद करें')}</button>
            `;

            // Open modal
            setTimeout(() => {
                horoModal.classList.add('show');
                horoModal.style.opacity = '1';
                horoModal.style.pointerEvents = 'auto';
                horoModal.style.transform = 'translate(-50%, -50%) scale(1)';
                if (sidebarOverlay) sidebarOverlay.classList.add('show');
            }, 50);

            // Close logic
            const closeBtn = document.getElementById('horo-modal-close');
            const closeModal = () => {
                horoModal.classList.remove('show');
                horoModal.style.opacity = '0';
                horoModal.style.pointerEvents = 'none';
                horoModal.style.transform = 'translate(-50%, -50%) scale(0.9)';
                if (sidebarOverlay) sidebarOverlay.classList.remove('show');
            };

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeModal, { once: true });
            }
        });
    });

    // Event delegation for video card share buttons (.card-share-btn)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.card-share-btn');
        if (!btn) return;

        // Prevent opening the video/modal/overlay of the parent card
        e.preventDefault();
        e.stopPropagation();

        const url = btn.getAttribute('data-url');
        const title = btn.getAttribute('data-title') || 'Video News';
        const lang = document.documentElement.getAttribute('lang') || 'en';

        if (navigator.share) {
            navigator.share({
                title: title,
                text: title,
                url: url
            }).catch(err => console.log('Error sharing:', err));
        } else {
            // Fallback: Copy link and alert the user
            navigator.clipboard.writeText(url).then(function() {
                const msg = lang === 'en' ? 'Share link copied to clipboard!' : (lang === 'pb' ? 'ਸਾਂਝਾ ਕਰਨ ਵਾਲਾ ਲਿੰਕ ਕਾਪੀ ਕੀਤਾ ਗਿਆ!' : 'साझा करने वाला लिंक कॉपी कर लिया गया है!');
                alert(msg);
            }).catch(err => {
                console.error('Failed to copy link:', err);
            });
        }
    }, true); // Use capture phase to intercept before card click handlers run
});
