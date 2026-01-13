// =============================================
// MAIN INITIALIZATION
// =============================================

document.addEventListener("DOMContentLoaded", () => {
  // Load header and footer first
  loadHeaderAndFooter().then(() => {
    // Initialize all functions after header/footer are loaded
    initializeAllFunctions();
    // If a server-side flash success message is present, show toast
    try {
      if (window.__flashSuccess) {
        showToast(window.__flashSuccess, { type: 'success' });
      }
    } catch (e) {
      console.error('Error showing flash toast:', e);
    }
  });
});

// =============================================
// LOAD HEADER AND FOOTER
// =============================================

function getBasePath() {
  const path = window.location.pathname;
  const depth = (path.match(/\//g) || []).length - 1;
  return depth > 0 ? "../" : "./";
}

function loadComponent(elementId, filePath, basePath) {
  return fetch(filePath)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Failed to load ${filePath}`);
      }
      return response.text();
    })
    .then((data) => {
      // Replace all ./ paths with the correct basePath
      const updatedData = data
        .replace(/href="\.\//g, `href="${basePath}`)
        .replace(/src="\.\//g, `src="${basePath}`);

      const element = document.getElementById(elementId);
      if (element) {
        element.innerHTML = updatedData;
      }
    })
    .catch((error) => {
      console.error("Error loading component:", error);

      // Fallback: try loading from absolute path (document root).
      // This helps when pages are served from nested paths and
      // `basePath + 'footer.html'` doesn't exist on the relative location.
      try {
        const filename = filePath.split('/').pop();
        if (filename) {
          const absolutePath = '/' + filename;
          return fetch(absolutePath)
            .then((resp) => {
              if (!resp.ok) throw new Error(`Fallback failed for ${absolutePath}`);
              return resp.text();
            })
            .then((fallbackData) => {
              const updatedData = fallbackData
                .replace(/href="\.\//g, `href="${basePath}`)
                .replace(/src="\.\//g, `src="${basePath}`);
              const element = document.getElementById(elementId);
              if (element) element.innerHTML = updatedData;
            })
            .catch((err) => {
              console.error('Fallback error loading component:', err);
            });
        }
      } catch (e) {
        console.error('Error during fallback handling:', e);
      }
    });
}

function loadHeaderAndFooter() {
  const basePath = getBasePath();

  // Load both header and footer, return promise when header is done
  const headerPromise = loadComponent(
    "header-placeholder",
    basePath + "header.html",
    basePath
  );
  loadComponent("footer-placeholder", basePath + "footer.html", basePath);

  return headerPromise;
}

// =============================================
// INITIALIZE ALL FUNCTIONS
// =============================================

function initializeAllFunctions() {
  // Mobile Navigation
  initializeMobileMenu();

  // Header Effects
  initializeHeaderEffects();

  // Navigation Management
  initializeNavigation();

  // FAQ Accordion
  initializeFAQAccordion();

  // Contact Form
  initializeContactForm();

  // Product Interactions
  initializeProductInteractions();

  // Sliders
  initializeHeroSlider();
  initializeProductSlider();
  initializeProductSpotlightSlider();
  initializeVideoSpotlightSlider();

  // Animations
  initializeCounterAnimation();
  initializeHeroAnimation();

  // Error Handling
  initializeErrorHandling();

  // Video Modal
  initializeVideoModal();
}

/* Toast helper */
function showToast(message, options = {}) {
  const type = options.type || 'info';
  const id = 'site-toast';

  // Avoid duplicate
  if (document.getElementById(id)) return;

  const toast = document.createElement('div');
  toast.id = id;
  toast.className = `site-toast site-toast-${type}`;
  toast.innerText = message || '';

  // Basic styles (kept inline to avoid stylesheet edits)
  toast.style.position = 'fixed';
  toast.style.right = '20px';
  toast.style.bottom = '20px';
  toast.style.background = type === 'success' ? '#28a745' : '#333';
  toast.style.color = 'white';
  toast.style.padding = '12px 18px';
  toast.style.borderRadius = '8px';
  toast.style.boxShadow = '0 6px 20px rgba(0,0,0,0.12)';
  toast.style.zIndex = 99999;
  toast.style.fontSize = '14px';

  // Close button
  const close = document.createElement('button');
  close.type = 'button';
  close.innerHTML = '\u00D7';
  close.style.marginLeft = '12px';
  close.style.border = 'none';
  close.style.background = 'transparent';
  close.style.color = 'white';
  close.style.fontSize = '16px';
  close.style.cursor = 'pointer';
  close.addEventListener('click', () => {
    toast.remove();
  });

  toast.appendChild(close);
  document.body.appendChild(toast);

  // Auto-dismiss after 5s
  setTimeout(() => {
    toast.remove();
  }, 5000);
}

// =============================================
// MOBILE MENU FUNCTIONALITY
// =============================================

function initializeMobileMenu() {
  const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
  const navMenu = document.querySelector(".nav-menu");
  const mobileCloseBtn = document.querySelector(".mobile-close-btn");

  function toggleMobileMenu() {
    navMenu?.classList.toggle("active");
    document.body.style.overflow = navMenu?.classList.contains("active")
      ? "hidden"
      : "";

    if (mobileCloseBtn) {
      mobileCloseBtn.style.display = navMenu?.classList.contains("active")
        ? "block"
        : "none";
    }
  }

  mobileMenuBtn?.addEventListener("click", toggleMobileMenu);
  mobileCloseBtn?.addEventListener("click", toggleMobileMenu);

  // Close mobile menu when clicking on links
  document.querySelectorAll(".nav-link, .mobile-top-item").forEach((link) => {
    link.addEventListener("click", () => {
      if (window.innerWidth <= 768) {
        toggleMobileMenu();
      }
    });
  });

  // Close menu on resize to desktop
  window.addEventListener("resize", () => {
    if (window.innerWidth > 768 && navMenu?.classList.contains("active")) {
      toggleMobileMenu();
    }
  });
}

// =============================================
// HEADER EFFECTS
// =============================================

function initializeHeaderEffects() {
  const header = document.getElementById("header");
  let lastScrollY = window.scrollY;
  let ticking = false;

  if (!header) return;

  function updateHeader() {
    const currentScrollY = window.scrollY;

    // Add/remove scrolled class for background change
    if (currentScrollY > 50) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }

    // Hide/show header based on scroll direction
    if (currentScrollY > lastScrollY && currentScrollY > 100) {
      // Scrolling down - hide header
      header.style.transform = "translateY(-100%)";
    } else {
      // Scrolling up or at top - show header
      header.style.transform = "translateY(0)";
    }

    lastScrollY = currentScrollY;
    ticking = false;
  }

  function requestTick() {
    if (!ticking) {
      requestAnimationFrame(updateHeader);
      ticking = true;
    }
  }

  window.addEventListener("scroll", requestTick);
}

// =============================================
// NAVIGATION MANAGEMENT
// =============================================

function initializeNavigation() {
  setActiveNavLink();
  initializeSmoothScrolling();
}

function setActiveNavLink() {
  const navLinks = document.querySelectorAll(".nav-link");
  const currentPath = window.location.pathname;

  // Get the base path for relative comparison
  const basePath = currentPath.split("/").slice(0, -1).join("/") || "/";

  navLinks.forEach((link) => {
    link.classList.remove("active");

    let linkPath = link.getAttribute("href");

    // Convert relative paths to absolute paths for comparison
    if (linkPath.startsWith("./")) {
      linkPath = basePath + linkPath.substring(1);
    } else if (linkPath.startsWith("../")) {
      // Handle parent directory paths if needed
      const parentLevels = (linkPath.match(/\.\.\//g) || []).length;
      const pathParts = basePath.split("/").filter((part) => part);
      const newPath =
        "/" +
        pathParts.slice(0, -parentLevels).join("/") +
        linkPath.replace(/\.\.\//g, "");
      linkPath = newPath;
    }

    // Normalize paths by removing trailing slashes
    const normalizedCurrent = currentPath.replace(/\/$/, "");
    const normalizedLink = linkPath.replace(/\/$/, "");
    console.log("normalizedCurrent",normalizedCurrent)
    console.log("normalizedLink",normalizedLink)
    // Check for exact match first (most specific)
    if (normalizedLink === normalizedCurrent) {
      link.classList.add("active");
    }
    // Check for home page - only activate when we're actually on home page
    else if (
      (normalizedCurrent === "" || normalizedCurrent === "/") &&
      (normalizedLink === "/" || normalizedLink === "/index.html")
    ) {
      link.classList.add("active");
    }
    // Check for products pages
    else if (
      normalizedCurrent.includes("/products") &&
      normalizedLink.includes("/products")
    ) {
      link.classList.add("active");
    }
    // Check for product detail pages
    else if (
      normalizedCurrent.includes("/product/") &&
      normalizedLink.includes("/product")
    ) {
      link.classList.add("active");
    }
  });
}

function initializeSmoothScrolling() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");

      if (targetId === "#" || !targetId.startsWith("#")) return;

      e.preventDefault();
      const targetElement = document.querySelector(targetId);

      if (targetElement) {
        const headerHeight =
          document.getElementById("header")?.offsetHeight || 100;
        const targetPosition = targetElement.offsetTop - headerHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth",
        });

        // Close mobile menu if open
        if (window.innerWidth <= 768) {
          const navMenu = document.querySelector(".nav-menu");
          if (navMenu?.classList.contains("active")) {
            navMenu.classList.remove("active");
            document.body.style.overflow = "";
          }
        }

        history.pushState(null, null, targetId);
      }
    });
  });
}

// =============================================
// FAQ ACCORDION
// =============================================

function initializeFAQAccordion() {
  document.querySelectorAll(".faq-question").forEach((question) => {
    question.addEventListener("click", () => {
      const item = question.parentElement;
      const isActive = item.classList.contains("active");

      // Close all other FAQ items
      document.querySelectorAll(".faq-item").forEach((faqItem) => {
        faqItem.classList.remove("active");
      });

      // Open clicked item if it wasn't active
      if (!isActive) {
        item.classList.add("active");
      }
    });
  });
}

// =============================================
// CONTACT FORM
// =============================================

function initializeContactForm() {
  const contactForm = document.getElementById("contactForm");

  if (!contactForm) return;

  contactForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.textContent : null;

    const formData = new FormData(this);

    // Basic client-side validation
    const name = formData.get('name')?.trim();
    const email = formData.get('email')?.trim();
    const subject = formData.get('subject')?.trim();
    const message = formData.get('message')?.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!name || !email || !subject || !message) {
      showNotification('Please fill in all required fields.', 'error');
      return;
    }

    if (!emailRegex.test(email)) {
      showNotification('Please enter a valid email address.', 'error');
      return;
    }

    if (submitBtn) {
      submitBtn.textContent = 'Sending...';
      submitBtn.disabled = true;
    }

    // Send via fetch to keep user on same page
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrf = tokenMeta ? tokenMeta.getAttribute('content') : '';

    fetch(this.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrf
      },
      body: formData
    })
    .then(async (res) => {
      if (res.status === 201 || res.status === 200) {
        const data = await res.json();
        showNotification(data.message || 'Thank you for your message! We will get back to you soon.', 'success');
        contactForm.reset();
      } else if (res.status === 422) {
        // Validation error
        const data = await res.json();
        const errors = data.errors || {};
        const firstKey = Object.keys(errors)[0];
        const firstMsg = errors[firstKey] ? errors[firstKey][0] : 'Please check the form.';
        showNotification(firstMsg, 'error');
      } else {
        const data = await res.json().catch(() => ({}));
        showNotification(data.error || 'Something went wrong. Please try again.', 'error');
      }
    })
    .catch((err) => {
      console.error('Contact submit error:', err);
      showNotification('Network error. Please try again.', 'error');
    })
    .finally(() => {
      if (submitBtn) {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }
    });
  });
}

// =============================================
// NOTIFICATION SYSTEM
// =============================================

function showNotification(message, type = "info") {
  const existingNotification = document.querySelector(".notification");
  if (existingNotification) {
    existingNotification.remove();
  }

  const notification = document.createElement("div");
  notification.className = `notification ${type}`;
  notification.textContent = message;

  if (!document.querySelector("#notification-styles")) {
    const styles = document.createElement("style");
    styles.id = "notification-styles";
    styles.textContent = `
          .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translate(-50%, -40px);
            padding: 12px 18px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            z-index: 100000;
            transition: transform 0.35s cubic-bezier(.2,.8,.2,1), opacity 0.35s;
            opacity: 0;
            max-width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            text-align: center;
          }
          .notification.success { background: #28a745; }
          .notification.error { background: #e74c3c; }
          .notification.info { background: #333; }
          .notification.show { transform: translate(-50%, 0); opacity: 1; }
        `;
    document.head.appendChild(styles);
  }

  document.body.appendChild(notification);

  // Trigger enter animation
  setTimeout(() => notification.classList.add("show"), 50);

  // Auto-dismiss
  setTimeout(() => {
    notification.classList.remove("show");
    setTimeout(() => notification.remove(), 350);
  }, 4500);
}

// =============================================
// PRODUCT INTERACTIONS
// =============================================

function initializeProductInteractions() {
  // Product Image Thumbnail Switching
  const thumbnails = document.querySelectorAll(".product-thumbnail");
  const mainImage = document.getElementById("mainImage");

  if (thumbnails.length > 0 && mainImage) {
    thumbnails.forEach((thumbnail) => {
      thumbnail.addEventListener("click", function () {
        thumbnails.forEach((t) => t.classList.remove("active"));
        this.classList.add("active");
        mainImage.src = this.getAttribute("data-image");
      });
    });
  }

  // Tab Switching
  const tabButtons = document.querySelectorAll(".tab-button");
  const tabContents = document.querySelectorAll(".tab-content");

  if (tabButtons.length > 0) {
    tabButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const tabId = this.getAttribute("data-tab");

        tabButtons.forEach((btn) => btn.classList.remove("active"));
        tabContents.forEach((content) => content.classList.remove("active"));

        this.classList.add("active");
        document.getElementById(tabId)?.classList.add("active");
      });
    });
  }
}

// =============================================
// HERO SLIDER
// =============================================

function initializeHeroSlider() {
  const heroSlider = document.querySelector(".hero-slider");
  const heroSliderNav = document.querySelector(".hero-slider-nav");

  if (!heroSlider) return;

  let heroSlidesData = [];

  // Prefer admin-uploaded videos exposed via Blade (`window.HOME_VIDEOS`).
  if (window.HOME_VIDEOS && Array.isArray(window.HOME_VIDEOS) && window.HOME_VIDEOS.length > 0) {
    console.log('Using HOME_VIDEOS for hero slider', window.HOME_VIDEOS);
    heroSlidesData = window.HOME_VIDEOS.map((v) => ({
      type: "video",
      src: v.path || v.url || v.file || '',
      title: v.filename || v.title || 'Video',
    })).filter(s => s.src);
  }

  // Fallback to static local assets when no admin videos available
  if (heroSlidesData.length === 0) {
    console.warn('No admin videos found; falling back to static hero assets');
    heroSlidesData = [
      { type: "video", src: "/assets/video6.mp4", title: "Professional Painting" },
      { type: "video", src: "/assets/rust.mp4", title: "Professional Painting" },
      { type: "video", src: "/assets/video5.mp4", title: "Professional Painting" },
      { type: "video", src: "/assets/whitepaint.mp4", title: "Professional Painting" },
    ];
  }

  console.log('heroSlidesData final:', heroSlidesData);

  // Clear existing slides
  heroSlider.innerHTML = "";
  heroSliderNav.innerHTML = "";

  // Add CSS for full video visibility
  if (!document.querySelector("#hero-video-fix")) {
    const style = document.createElement("style");
    style.id = "hero-video-fix";
    style.textContent = `
    /* Default (large screens) - unchanged */
    .hero-slide video {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover !important;
      object-position: center center !important;
      display: block !important;
    }
    .hero-slider {
      height: 100vh !important;
      min-height: 100vh !important;
    }
    .hero-slide {
      height: 100% !important;
    }

    /*  Mobile-specific fixes */
    @media (max-width: 768px) {
      .hero {
        height: 60vh !important;
        min-height: 60vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-direction: column !important;
        padding: 0 !important;
        overflow: hidden !important;
      }

      .hero-slider {
        height: 60vh !important;
        min-height: 60vh !important;
        position: absolute !important;
        width: 100% !important;
      }

      .hero-slide {
        height: 60vh !important;
        min-height: 60vh !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
      }

      .hero-slide video,
      .hero-slide img {
        width: 100% !important;
        height: 60vh !important;
        min-height: 60vh !important;
        max-height: 60vh !important;
        object-fit: cover !important;
        object-position: center center !important;
        display: block !important;
      }

      .hero-content {
        padding: 20px 15px !important;
        z-index: 3 !important;
        text-align: center !important;
      }

      .hero-title {
        font-size: 2rem !important;
        line-height: 1.2 !important;
        margin-bottom: 15px !important;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8) !important;
      }

      .hero-subtitle {
       margin-top:2rem !important;
        font-size: 1rem !important;
        margin-top: 5rem !important;
        margin-bottom: 25px !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8) !important;
        opacity: 0.95 !important;
      }

      .hero .btn {
      margin-top: 2rem !important;
        padding: 12px 24px !important;
        font-size: 0.9rem !important;
      }
    }

    /* Small phones */
    @media (max-width: 576px) {
      .hero {
        height: 50vh !important;
        min-height: 50vh !important;
        padding: 0 !important;
      }

      .hero-slider {
        height: 50vh !important;
        min-height: 50vh !important;
      }

      .hero-slide {
        height: 50vh !important;
        min-height: 50vh !important;
      }

      .hero-slide video,
      .hero-slide img {
        width: 100% !important;
        height: 50vh !important;
        min-height: 50vh !important;
        max-height: 50vh !important;
      }

      .hero-title {
        font-size: 1.8rem !important;
        margin-bottom: 12px !important;
      }

      .hero-subtitle {
        font-size: 0.9rem !important;
        margin-bottom: 20px !important;
      }

      .hero-content {
        padding: 15px 10px !important;
      }
    }


    @media (max-width: 768px) and (orientation: landscape) {
      .hero {
        height: 70vh !important;
        min-height: 70vh !important;
      }

      .hero-slider {
        height: 70vh !important;
        min-height: 70vh !important;
      }

      .hero-slide {
        height: 70vh !important;
        min-height: 70vh !important;
      }

      .hero-slide video,
      .hero-slide img {
        width: 100% !important;
        height: 70vh !important;
        min-height: 70vh !important;
        max-height: 70vh !important;
        object-fit: cover !important;
      }

      .hero-content {
        padding: 10px 15px !important;
      }

      .hero-title {
        font-size: 1.8rem !important;
        margin-bottom: 10px !important;
      }

      .hero-subtitle {
        font-size: 0.9rem !important;
        margin-bottom: 15px !important;
      }
    }

    /* ✅ Extra small devices */
    @media (max-width: 380px) {
      .hero {
        height: 45vh !important;
        min-height: 45vh !important;
        padding: 0 !important;
      }

      .hero-slider {
        height: 45vh !important;
        min-height: 45vh !important;
      }

      .hero-slide {
        height: 45vh !important;
        min-height: 45vh !important;
      }

      .hero-slide video,
      .hero-slide img {
        width: 100% !important;
        height: 45vh !important;
        min-height: 45vh !important;
        max-height: 45vh !important;
      }

      .hero-title {
        font-size: 1.6rem !important;
      }

      .hero-subtitle {
        font-size: 0.85rem !important;
      }

      .hero-content {
        padding: 10px 8px !important;
      }
    }

    
    .hero-slide > div:last-child {
      background: transparent !important;
      backdrop-filter: none !important;
      -webkit-backdrop-filter: none !important;
    }
  `;
    document.head.appendChild(style);
  }

  heroSlidesData.forEach((slideData, index) => {
    const slide = document.createElement("div");
    slide.className = `hero-slide ${index === 0 ? "active" : ""}`;
    slide.style.position = "absolute";
    slide.style.top = "0";
    slide.style.left = "0";
    slide.style.width = "100%";
    slide.style.height = "100%";
    slide.style.overflow = "hidden";

    if (slideData.type === "video") {
      const videoContainer = document.createElement("div");
      videoContainer.style.position = "absolute";
      videoContainer.style.top = "0";
      videoContainer.style.left = "0";
      videoContainer.style.width = "100%";
      videoContainer.style.height = "100%";
      videoContainer.style.overflow = "hidden";

      const video = document.createElement("video");
      video.style.width = "100%";
      video.style.height = "100%";
      video.style.objectFit = "cover";
      video.style.objectPosition = "center";
      video.style.display = "block";
      video.src = slideData.src;
      video.autoplay = true;
      video.muted = true;
      video.loop = true;
      video.playsInline = true;
      video.setAttribute("playsinline", "true");
      video.setAttribute("webkit-playsinline", "true");

      const playOverlay = document.createElement("div");
      playOverlay.className = "video-play-overlay";
      playOverlay.innerHTML = '<i class="fas fa-play"></i>';
      playOverlay.onclick = () =>
        openVideoModal(slideData.src, slideData.title);

      videoContainer.appendChild(video);
      videoContainer.appendChild(playOverlay);
      slide.appendChild(videoContainer);
    } else {
      const img = document.createElement("img");
      img.src = slideData.src;
      img.alt = slideData.title;
      img.style.width = "100%";
      img.style.height = "100%";
      img.style.objectFit = "cover";
      img.style.objectPosition = "center";
      img.style.display = "block";
      slide.appendChild(img);
    }

    // Create overlay but without the dark background
    const overlay = document.createElement("div");
    overlay.style.position = "absolute";
    overlay.style.top = "0";
    overlay.style.left = "0";
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.zIndex = "1";
    overlay.style.background = "transparent"; // Make overlay transparent to prevent blur
    overlay.style.backdropFilter = "none"; // Ensure no backdrop filter
    overlay.style.webkitBackdropFilter = "none"; // Ensure no backdrop filter
    overlay.style.filter = "none"; // Ensure no filter
    slide.appendChild(overlay);

    heroSlider.appendChild(slide);

    const dot = document.createElement("div");
    dot.className = `hero-slider-dot ${index === 0 ? "active" : ""}`;
    dot.addEventListener("click", () => goToHeroSlide(index));
    heroSliderNav.appendChild(dot);
  });

  const heroSlides = document.querySelectorAll(".hero-slide");
  const heroDots = document.querySelectorAll(".hero-slider-dot");
  const heroPrevBtn = document.querySelector(".hero-slider-arrow.prev");
  const heroNextBtn = document.querySelector(".hero-slider-arrow.next");

  let currentHeroSlide = 0;
  let heroSlideInterval;
  const heroSlideCount = heroSlides.length;

  function goToHeroSlide(slideIndex) {
    if (slideIndex < 0) slideIndex = heroSlideCount - 1;
    if (slideIndex >= heroSlideCount) slideIndex = 0;

    heroSlides.forEach((slide) => slide.classList.remove("active"));
    heroSlides[slideIndex].classList.add("active");

    heroDots.forEach((dot) => dot.classList.remove("active"));
    heroDots[slideIndex].classList.add("active");

    currentHeroSlide = slideIndex;
    resetHeroSliderTimer();
  }

  function resetHeroSliderTimer() {
    clearInterval(heroSlideInterval);
    heroSlideInterval = setInterval(() => {
      goToHeroSlide(currentHeroSlide + 1);
    }, 5000);
  }

  heroPrevBtn?.addEventListener("click", () =>
    goToHeroSlide(currentHeroSlide - 1)
  );
  heroNextBtn?.addEventListener("click", () =>
    goToHeroSlide(currentHeroSlide + 1)
  );

  resetHeroSliderTimer();

  heroSlider.addEventListener("mouseenter", () =>
    clearInterval(heroSlideInterval)
  );
  heroSlider.addEventListener("mouseleave", () => resetHeroSliderTimer());

  const videoElement = heroSlider.querySelector("video");
  if (videoElement) {
    videoElement.addEventListener("loadeddata", function () {
      this.style.width = "100%";
      this.style.height = "100%";
      this.style.objectFit = "cover";
    });

    videoElement.addEventListener("error", () => {
      console.error("Error loading video");
    });

    videoElement.addEventListener("canplay", function () {
      this.style.width = "100%";
      this.style.height = "100%";
    });
  }

  const heroSection = document.querySelector(".hero");
  if (heroSection) {
    heroSection.style.minHeight = "100vh";
    heroSection.style.height = "100vh";
  }
}

// =============================================
// PRODUCT SLIDER
// =============================================

function initializeProductSlider() {
  const slider = document.querySelector(".product-slider");
  const slides = document.querySelectorAll(".product-slide");
  const dots = document.querySelectorAll(".slider-dot");
  const prevBtn = document.querySelector(".slider-arrow.prev");
  const nextBtn = document.querySelector(".slider-arrow.next");

  if (!slider || slides.length === 0) return;

  let currentSlide = 0;
  const slideCount = slides.length;

  function goToSlide(slideIndex) {
    if (slideIndex < 0) slideIndex = slideCount - 1;
    if (slideIndex >= slideCount) slideIndex = 0;

    slider.style.transform = `translateX(-${slideIndex * 100}%)`;

    dots.forEach((dot) => dot.classList.remove("active"));
    dots[slideIndex]?.classList.add("active");

    currentSlide = slideIndex;
  }

  prevBtn?.addEventListener("click", () => goToSlide(currentSlide - 1));
  nextBtn?.addEventListener("click", () => goToSlide(currentSlide + 1));

  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => goToSlide(index));
  });
}

// =============================================
// PRODUCT SPOTLIGHT SLIDER
// =============================================

function initializeProductSpotlightSlider() {
  const slider = document.querySelector(".product-spotlight .spotlight-slider");
  const slides = document.querySelectorAll(
    ".product-spotlight .spotlight-slide"
  );
  const prevBtn = document.querySelector(
    ".product-spotlight .spotlight-arrow.prev"
  );
  const nextBtn = document.querySelector(
    ".product-spotlight .spotlight-arrow.next"
  );
  const dotsContainer = document.querySelector(
    ".product-spotlight .spotlight-dots"
  );

  if (!slider || slides.length === 0) return;

  let currentSlide = 0;
  const slideCount = slides.length;
  let cardsPerView = 4;
  let isTransitioning = false;
  let resizeTimeout;

  function cloneSlides() {
    // If there are not enough slides to require cloning (e.g., 1 slide),
    // avoid cloning to prevent duplicate visible cards. Use slideCount as cardsPerView.
    if (slideCount <= cardsPerView) {
      const allSlides = document.querySelectorAll(
        ".product-spotlight .spotlight-slide"
      );
      // Ensure slides fill container correctly
      const slideWidth = 100 / Math.max(1, slideCount);
      allSlides.forEach((slide) => {
        slide.style.flex = `0 0 ${slideWidth}%`;
        slide.style.minWidth = `${slideWidth}%`;
      });
      currentSlide = 0;
      slider.style.transform = `translateX(0%)`;
      return allSlides;
    }

    for (let i = 0; i < cardsPerView; i++) {
      const clone = slides[i].cloneNode(true);
      slider.appendChild(clone);
    }

    for (let i = slideCount - cardsPerView; i < slideCount; i++) {
      const clone = slides[i].cloneNode(true);
      slider.insertBefore(clone, slider.firstChild);
    }

    const allSlides = document.querySelectorAll(
      ".product-spotlight .spotlight-slide"
    );
    currentSlide = cardsPerView;
    slider.style.transform = `translateX(-${
      currentSlide * (100 / cardsPerView)
    }%)`;

    return allSlides;
  }

  function updateCardsPerView() {
    if (window.innerWidth <= 768) {
      cardsPerView = 1;
    } else if (window.innerWidth <= 900) {
      cardsPerView = 2;
    } else if (window.innerWidth <= 1200) {
      cardsPerView = 3;
    } else {
      cardsPerView = 4;
    }

    const slideWidth = 100 / cardsPerView;
    const allSlides = document.querySelectorAll(
      ".product-spotlight .spotlight-slide"
    );
    allSlides.forEach((slide) => {
      slide.style.flex = `0 0 ${slideWidth}%`;
      slide.style.minWidth = `${slideWidth}%`;
    });

    return allSlides;
  }

  function createDots() {
    dotsContainer.innerHTML = "";
    const dotCount = slideCount;

    for (let i = 0; i < dotCount; i++) {
      const dot = document.createElement("div");
      dot.className = `spotlight-dot ${i === 0 ? "active" : ""}`;
      dot.addEventListener("click", () => goToSlide(i + cardsPerView, true));
      dotsContainer.appendChild(dot);
    }
  }

  function goToSlide(slideIndex, fromDot = false) {
    if (isTransitioning) return;

    isTransitioning = true;

    const allSlides = document.querySelectorAll(
      ".product-spotlight .spotlight-slide"
    );
    const totalSlides = allSlides.length;

    let targetIndex = slideIndex;

    if (slideIndex < cardsPerView) {
      targetIndex = totalSlides - 2 * cardsPerView + slideIndex;
    } else if (slideIndex >= totalSlides - cardsPerView) {
      targetIndex = cardsPerView + (slideIndex - (totalSlides - cardsPerView));
    }

    slider.style.transition = "transform 0.5s ease";
    slider.style.transform = `translateX(-${
      slideIndex * (100 / cardsPerView)
    }%)`;

    if (!fromDot) {
      const dots = document.querySelectorAll(
        ".product-spotlight .spotlight-dot"
      );
      dots.forEach((dot) => dot.classList.remove("active"));

      let dotIndex = slideIndex - cardsPerView;
      if (dotIndex < 0) dotIndex = slideCount - 1;
      if (dotIndex >= slideCount) dotIndex = 0;

      if (dots[dotIndex]) {
        dots[dotIndex].classList.add("active");
      }
    }

    for (let i = slideIndex; i < slideIndex + cardsPerView; i++) {
      if (allSlides[i]) {
        const card = allSlides[i].querySelector(".spotlight-card");
        if (card) {
          card.style.animationDelay = `${(i - slideIndex) * 0.1}s`;
          card.style.animation = "cardSlideIn 0.6s forwards";
        }
      }
    }

    currentSlide = slideIndex;

    setTimeout(() => {
      isTransitioning = false;

      if (currentSlide < cardsPerView) {
        slider.style.transition = "none";
        currentSlide = totalSlides - 2 * cardsPerView;
        slider.style.transform = `translateX(-${
          currentSlide * (100 / cardsPerView)
        }%)`;
      } else if (currentSlide >= totalSlides - cardsPerView) {
        slider.style.transition = "none";
        currentSlide = cardsPerView;
        slider.style.transform = `translateX(-${
          currentSlide * (100 / cardsPerView)
        }%)`;
      }
    }, 500);
  }

  prevBtn?.addEventListener("click", () => {
    if (!isTransitioning) {
      goToSlide(currentSlide - 1);
    }
  });

  nextBtn?.addEventListener("click", () => {
    if (!isTransitioning) {
      goToSlide(currentSlide + 1);
    }
  });

  // Only enable autoplay when there are more slides than visible cards
  let slideInterval;
  if (slideCount > cardsPerView) {
    slideInterval = setInterval(() => {
      if (!isTransitioning) {
        goToSlide(currentSlide + 1);
      }
    }, 5000);
  }

  slider.addEventListener("mouseenter", () => {
    clearInterval(slideInterval);
  });

  slider.addEventListener("mouseleave", () => {
    slideInterval = setInterval(() => {
      if (!isTransitioning) {
        goToSlide(currentSlide + 1);
      }
    }, 5000);
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft" && !isTransitioning) {
      goToSlide(currentSlide - 1);
    } else if (e.key === "ArrowRight" && !isTransitioning) {
      goToSlide(currentSlide + 1);
    }
  });

  function handleResize() {
    const allSlides = document.querySelectorAll(
      ".product-spotlight .spotlight-slide"
    );
    for (let i = slideCount; i < allSlides.length; i++) {
      if (allSlides[i]) {
        allSlides[i].remove();
      }
    }

    currentSlide = 0;
    updateCardsPerView();
    const newSlides = cloneSlides();
    createDots();
    goToSlide(cardsPerView);
  }

  const allSlides = updateCardsPerView();
  cloneSlides();
  createDots();

  setTimeout(() => {
    goToSlide(cardsPerView);
  }, 100);

  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(handleResize, 250);
  });
}

// =============================================
// VIDEO SPOTLIGHT SLIDER (FIXED)
// =============================================

function initializeVideoSpotlightSlider() {
  const slider = document.querySelector(".video-spotlight .spotlight-slider");
  const slides = document.querySelectorAll(".video-spotlight .spotlight-slide");
  const prevBtn = document.querySelector(
    ".video-spotlight .spotlight-arrow.prev"
  );
  const nextBtn = document.querySelector(
    ".video-spotlight .spotlight-arrow.next"
  );
  const dotsContainer = document.querySelector(
    ".video-spotlight .spotlight-dots"
  );

  if (!slider || slides.length === 0) return;

  let currentSlide = 0;
  const slideCount = slides.length;
  let cardsPerView = 3; // Default number of videos visible
  let isTransitioning = false; // Flag to prevent rapid clicking
  let resizeTimeout;
  let slideInterval;

  // Clone slides for infinite effect
  function cloneSlides() {
    // Clone first few slides and append to end
    for (let i = 0; i < cardsPerView; i++) {
      const clone = slides[i].cloneNode(true);
      slider.appendChild(clone);
    }

    // Clone last few slides and prepend to beginning
    for (let i = slideCount - cardsPerView; i < slideCount; i++) {
      const clone = slides[i].cloneNode(true);
      slider.insertBefore(clone, slider.firstChild);
    }

    // Update slides reference to include clones
    const allSlides = document.querySelectorAll(
      ".video-spotlight .spotlight-slide"
    );

    // Set initial position to show the first original slide
    currentSlide = cardsPerView;
    slider.style.transform = `translateX(-${
      currentSlide * (100 / cardsPerView)
    }%)`;

    return allSlides;
  }

  // Function to update cards per view based on screen size
  function updateCardsPerView() {
    if (window.innerWidth <= 768) {
      cardsPerView = 1;
    } else if (window.innerWidth <= 1024) {
      cardsPerView = 2;
    } else {
      cardsPerView = 3;
    }

    // Update slide width based on cards per view
    const slideWidth = 100 / cardsPerView;
    const allSlides = document.querySelectorAll(
      ".video-spotlight .spotlight-slide"
    );
    allSlides.forEach((slide) => {
      slide.style.flex = `0 0 ${slideWidth}%`;
      slide.style.minWidth = `${slideWidth}%`;
    });

    return allSlides;
  }

  // Create dots
  function createDots() {
    dotsContainer.innerHTML = "";
    const dotCount = slideCount;

    for (let i = 0; i < dotCount; i++) {
      const dot = document.createElement("div");
      dot.className = `spotlight-dot ${i === 0 ? "active" : ""}`;
      dot.addEventListener("click", () => goToSlide(i + cardsPerView, true));
      dotsContainer.appendChild(dot);
    }
  }

  function goToSlide(slideIndex, fromDot = false) {
    if (isTransitioning) return;

    isTransitioning = true;

    const allSlides = document.querySelectorAll(
      ".video-spotlight .spotlight-slide"
    );
    const totalSlides = allSlides.length;

    // Calculate the actual slide index considering clones
    let targetIndex = slideIndex;

    // If we're at the beginning (clones) and going backward
    if (slideIndex < cardsPerView) {
      targetIndex = totalSlides - 2 * cardsPerView + slideIndex;
    }
    // If we're at the end (clones) and going forward
    else if (slideIndex >= totalSlides - cardsPerView) {
      targetIndex = cardsPerView + (slideIndex - (totalSlides - cardsPerView));
    }

    // Update slider position
    slider.style.transition = "transform 0.5s ease";
    slider.style.transform = `translateX(-${
      slideIndex * (100 / cardsPerView)
    }%)`;

    // Update active dot (only if not from dot click to avoid loop)
    if (!fromDot) {
      const dots = document.querySelectorAll(".video-spotlight .spotlight-dot");
      dots.forEach((dot) => dot.classList.remove("active"));

      let dotIndex = slideIndex - cardsPerView;
      if (dotIndex < 0) dotIndex = slideCount - 1;
      if (dotIndex >= slideCount) dotIndex = 0;

      if (dots[dotIndex]) {
        dots[dotIndex].classList.add("active");
      }
    }

    // Animate cards on slide change
    for (let i = slideIndex; i < slideIndex + cardsPerView; i++) {
      if (allSlides[i]) {
        const card = allSlides[i].querySelector(".spotlight-card");
        if (card) {
          card.style.animationDelay = `${(i - slideIndex) * 0.1}s`;
          card.style.animation = "cardSlideIn 0.6s forwards";
        }
      }
    }

    currentSlide = slideIndex;

    // Reset transition flag after animation completes
    setTimeout(() => {
      isTransitioning = false;

      // Check if we need to jump to the other end for infinite effect
      if (currentSlide < cardsPerView) {
        // We're at the beginning clones, jump to the end
        slider.style.transition = "none";
        currentSlide = totalSlides - 2 * cardsPerView;
        slider.style.transform = `translateX(-${
          currentSlide * (100 / cardsPerView)
        }%)`;
      } else if (currentSlide >= totalSlides - cardsPerView) {
        // We're at the end clones, jump to the beginning
        slider.style.transition = "none";
        currentSlide = cardsPerView;
        slider.style.transform = `translateX(-${
          currentSlide * (100 / cardsPerView)
        }%)`;
      }
    }, 500);
  }

  // Event listeners for arrows
  prevBtn?.addEventListener("click", () => {
    if (!isTransitioning) {
      goToSlide(currentSlide - 1);
    }
  });

  nextBtn?.addEventListener("click", () => {
    if (!isTransitioning) {
      goToSlide(currentSlide + 1);
    }
  });

  // Auto-slide functionality
  function startAutoSlide() {
    slideInterval = setInterval(() => {
      if (!isTransitioning) {
        goToSlide(currentSlide + 1);
      }
    }, 5000);
  }

  // Pause auto-slide on hover
  const sliderContainer = document.querySelector(
    ".video-spotlight .spotlight-slider-container"
  );
  if (sliderContainer) {
    sliderContainer.addEventListener("mouseenter", () => {
      clearInterval(slideInterval);
    });

    sliderContainer.addEventListener("mouseleave", () => {
      startAutoSlide();
    });
  }

  // Keyboard navigation
  document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft" && !isTransitioning) {
      goToSlide(currentSlide - 1);
    } else if (e.key === "ArrowRight" && !isTransitioning) {
      goToSlide(currentSlide + 1);
    }
  });

  // Window resize handler
  function handleResize() {
    // Remove all cloned slides
    const allSlides = document.querySelectorAll(
      ".video-spotlight .spotlight-slide"
    );
    for (let i = slideCount; i < allSlides.length; i++) {
      if (allSlides[i]) {
        allSlides[i].remove();
      }
    }

    // Reset to first slide
    currentSlide = 0;

    // Update cards per view and reclone slides
    updateCardsPerView();
    const newSlides = cloneSlides();
    createDots();

    // Reset position
    goToSlide(cardsPerView);
  }

  // Initialize the slider
  const allSlides = updateCardsPerView();
  cloneSlides();
  createDots();

  // Use a slight delay to ensure DOM is fully updated
  setTimeout(() => {
    goToSlide(cardsPerView);
  }, 100);

  // Start auto-slide
  startAutoSlide();

  // Throttled resize handler
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(handleResize, 250);
  });
}

// =============================================
// ANIMATIONS
// =============================================

// =============================================
// COUNTER ANIMATIONS (FIXED FOR ALL PAGES)
// =============================================

function initializeCounterAnimation() {
  // Home page counters
  const homeStatNumbers = document.querySelectorAll(".stat-number");
  const homeStatsSection = document.querySelector(".about-stats");

  // About page counters
  const aboutStatNumbers = document.querySelectorAll(
    ".about-page-stat__number"
  );
  const aboutStatsSection = document.querySelector(".about-page-stats");

  function animateCounter(el, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        el.textContent = target.toLocaleString() + "+";
        clearInterval(timer);
      } else {
        el.textContent = Math.floor(current).toLocaleString() + "+";
      }
    }, 16);
  }

  // Home page counter observer
  if (homeStatNumbers.length > 0 && homeStatsSection) {
    const homeObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            homeStatNumbers.forEach((stat, index) => {
              const target = parseInt(stat.getAttribute("data-target"));
              setTimeout(() => {
                animateCounter(stat, target);
              }, index * 300);
            });
            homeObserver.disconnect();
          }
        });
      },
      {
        threshold: 0.3,
        rootMargin: "0px 0px -100px 0px",
      }
    );

    homeObserver.observe(homeStatsSection);
  }

  // About page counter observer
  if (aboutStatNumbers.length > 0 && aboutStatsSection) {
    const aboutObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            aboutStatNumbers.forEach((stat, index) => {
              const target = parseInt(stat.getAttribute("data-target"));
              setTimeout(() => {
                animateCounter(stat, target);
              }, index * 300);
            });
            aboutObserver.disconnect();
          }
        });
      },
      {
        threshold: 0.3,
        rootMargin: "0px 0px -100px 0px",
      }
    );

    aboutObserver.observe(aboutStatsSection);
  }

  // Fallback: if no intersection observer works, animate after delay
  if (homeStatNumbers.length > 0 && !homeStatsSection) {
    setTimeout(() => {
      homeStatNumbers.forEach((stat, index) => {
        const target = parseInt(stat.getAttribute("data-target"));
        setTimeout(() => {
          animateCounter(stat, target);
        }, index * 300);
      });
    }, 1000);
  }

  if (aboutStatNumbers.length > 0 && !aboutStatsSection) {
    setTimeout(() => {
      aboutStatNumbers.forEach((stat, index) => {
        const target = parseInt(stat.getAttribute("data-target"));
        setTimeout(() => {
          animateCounter(stat, target);
        }, index * 300);
      });
    }, 1000);
  }
}

function initializeHeroAnimation() {
  const heroTitle = document.querySelector(".hero-title");
  const heroSubtitle = document.querySelector(".hero-subtitle");
  const heroBtn = document.querySelector(".hero .btn");

  if (!heroTitle) return;
  [heroTitle, heroSubtitle, heroBtn].forEach((el) => {
    if (el) {
      el.style.opacity = "0";
      el.style.transform = "translateY(30px)";
      el.style.transition = "opacity 0.6s ease, transform 0.6s ease";
    }
  });

  heroTitle.style.opacity = "1";
  heroTitle.style.transform = "translateY(0)";

  setTimeout(() => {
    if (heroSubtitle) {
      heroSubtitle.style.opacity = "1";
      heroSubtitle.style.transform = "translateY(0)";
    }
  }, 300);

  setTimeout(() => {
    if (heroBtn) {
      heroBtn.style.opacity = "1";
      heroBtn.style.transform = "translateY(0)";
    }
  }, 600);
}

function animateOnScroll() {
  const cards = document.querySelectorAll(
    ".products-page-category-product-card"
  );

  cards.forEach((card) => {
    const cardTop = card.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;

    if (cardTop < windowHeight - 100) {
      card.classList.add("animated");
    }
  });
}

// =============================================
// ERROR HANDLING
// =============================================

function initializeErrorHandling() {
  // For media load errors, attempt a few alternative URL patterns before hiding
  window.addEventListener(
    "error",
    (e) => {
      const target = e.target;
      if (target && (target.tagName === "IMG" || target.tagName === "VIDEO")) {
        const src = target.currentSrc || target.src || target.getAttribute('src');
        console.warn("Failed to load media:", src);

        // Only handle VIDEO elements here; images can be hidden immediately
        if (target.tagName === "VIDEO") {
          // Try alternative candidate URLs (only once per element)
          if (!target._altTries) target._altTries = 0;

          const filename = (src || '').split('/').pop() || '';
          const candidates = [];

          // If src already contains /storage/ try /videos/ and vice versa
          if (src && src.indexOf('/storage/') !== -1) {
            candidates.push('/videos/' + filename);
            candidates.push('/uploads/videos/' + filename);
          } else if (src && src.indexOf('/videos/') !== -1) {
            candidates.push('/storage/videos/' + filename);
            candidates.push('/uploads/videos/' + filename);
          } else {
            // generic attempts
            candidates.push('/storage/videos/' + filename);
            candidates.push('/videos/' + filename);
            candidates.push('/uploads/videos/' + filename);
          }

          // Also try without domain if full URL provided
          if (src && src.match(/^https?:\/\//)) {
            const short = '/' + filename;
            candidates.push(short);
          }

          // Pick the next untried candidate
          const next = candidates[target._altTries];
          if (next) {
            console.log('Attempting alternate video src:', next);
            target._altTries++;
            // If element is <video> with <source> child, update source tag(s)
            const sourceEl = target.querySelector('source');
            if (sourceEl) {
              sourceEl.src = next;
              // reset source to force reload
              target.load();
            } else {
              target.src = next;
            }
            return; // don't hide yet
          }

          // All alternatives exhausted — hide element and log
          console.warn('All alternate sources failed for video:', src);
          try { target.style.display = 'none'; } catch (err) {}
        } else {
          // For images just hide
          try { target.style.display = 'none'; } catch (err) {}
        }
      }
    },
    true
  );
}

// =============================================
// WINDOW EVENT LISTENERS
// =============================================

window.addEventListener("load", () => {
  document.body.classList.add("loaded");
  animateOnScroll();
});

window.addEventListener("scroll", animateOnScroll);

// =============================================
// VIDEO MODAL FUNCTIONALITY (FIXED)
// =============================================

function initializeVideoModal() {
  const videoModal = document.getElementById("videoModal");
  const modalVideo = document.getElementById("modalVideo");
  const modalVideoTitle = document.getElementById("modalVideoTitle");
  const closeVideoModal = document.getElementById("closeVideoModal");

  // Check if required elements exist
  if (!videoModal || !modalVideo || !modalVideoTitle || !closeVideoModal) {
    console.warn("Video modal elements not found, skipping initialization");
    return;
  }

  // Function to open video modal
  function openVideoModal(videoSrc, videoTitle) {
    if (!videoModal || !modalVideo || !modalVideoTitle) return;

    modalVideo.src = videoSrc;
    modalVideoTitle.textContent = videoTitle || "Video";
    videoModal.classList.add("active");
    document.body.style.overflow = "hidden"; // Prevent scrolling

    // Play the video
    modalVideo.play().catch((error) => {
      console.log("Autoplay prevented:", error);
    });
  }

  // Function to close video modal
  function closeModal() {
    if (!videoModal || !modalVideo) return;

    videoModal.classList.remove("active");
    modalVideo.pause();
    modalVideo.currentTime = 0;
    document.body.style.overflow = ""; // Re-enable scrolling
  }

  // Add event listeners to all "Watch Now" buttons
  document.querySelectorAll(".watch-video").forEach((button) => {
    button.addEventListener("click", function () {
      const videoSrc = this.getAttribute("data-video");
      const videoTitle = this.getAttribute("data-title");
      openVideoModal(videoSrc, videoTitle);
    });
  });

  // Add event listeners to all video play buttons
  document.querySelectorAll(".video-play-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const videoCard = this.closest(".spotlight-card");
      if (!videoCard) return;

      const watchBtn = videoCard.querySelector(".watch-video");
      if (!watchBtn) return;

      const videoSrc = watchBtn.getAttribute("data-video");
      const videoTitle = watchBtn.getAttribute("data-title");
      openVideoModal(videoSrc, videoTitle);
    });
  });

  // Close modal when clicking the X button
  closeVideoModal.addEventListener("click", closeModal);

  // Close modal when clicking outside the video
  videoModal.addEventListener("click", function (e) {
    if (e.target === videoModal) {
      closeModal();
    }
  });

  // Close modal with Escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && videoModal.classList.contains("active")) {
      closeModal();
    }
  });

  // Pause video when modal is closed
  videoModal.addEventListener("transitionend", function () {
    if (!videoModal.classList.contains("active")) {
      modalVideo.pause();
      modalVideo.currentTime = 0;
    }
  });

  // Make functions globally available
  window.openVideoModal = openVideoModal;
  window.closeVideoModal = closeModal;
}

// Handle contact form submission
document.getElementById("contactForm").addEventListener("submit", function (e) {
  e.preventDefault();

  // Get form values
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const message = document.getElementById("message").value;

  // Simple validation
  if (name && email && message) {
    // In a real application, you would send this data to a server
    alert(
      "Thank you for your message, " + name + "! We will contact you soon."
    );

    // Reset form
    this.reset();
  } else {
    alert("Please fill in all required fields.");
  }
});
