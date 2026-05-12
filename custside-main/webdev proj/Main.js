/* =============================================
   King's Cup Coffee — main.js
   ============================================= */

(function () {
  'use strict';

  /* ------------------------------------------
     Mobile nav toggle
  ------------------------------------------ */
  const hamburger = document.getElementById('hamburger');
  const navLinks  = document.querySelector('.nav-links');

  if (hamburger && navLinks) {
    hamburger.addEventListener('click', function () {
      navLinks.classList.toggle('open');
      hamburger.setAttribute(
        'aria-expanded',
        navLinks.classList.contains('open') ? 'true' : 'false'
      );
    });

    // Close nav when a link is clicked (mobile)
    navLinks.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        navLinks.classList.remove('open');
      });
    });

    // Close nav on outside click
    document.addEventListener('click', function (e) {
      if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
        navLinks.classList.remove('open');
      }
    });
  }

  /* ------------------------------------------
     Scroll-triggered fade-in animation
  ------------------------------------------ */
  const animatables = document.querySelectorAll(
    '.menu-card, .story-section, .join-banner, .faq-section'
  );

  if ('IntersectionObserver' in window) {
    // Set initial hidden state via JS so CSS-only users still see content
    animatables.forEach(function (el) {
      el.style.opacity  = '0';
      el.style.transform = 'translateY(28px)';
      el.style.transition = 'opacity 0.55s ease, transform 0.55s ease';
    });

    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.style.opacity  = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 }
    );

    animatables.forEach(function (el) { observer.observe(el); });
  }

  /* ------------------------------------------
     Stagger cards on load
  ------------------------------------------ */
  document.querySelectorAll('.menu-card').forEach(function (card, i) {
    card.style.transitionDelay = (i * 0.1) + 's';
  });

  /* ------------------------------------------
     Navbar shrink on scroll
  ------------------------------------------ */
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 40) {
        navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.35)';
      } else {
        navbar.style.boxShadow = '0 2px 12px rgba(0,0,0,0.25)';
      }
    }, { passive: true });
  }

  /* ------------------------------------------
     Smooth active-link highlight based on hash
  ------------------------------------------ */
  const currentHash = window.location.hash;
  if (currentHash) {
    document.querySelectorAll('.nav-links a').forEach(function (link) {
      link.classList.remove('active');
      if (link.getAttribute('href') === currentHash) {
        link.classList.add('active');
      }
    });
  }
  /* ------------------------------------------
     Menu card hover enhancement
  ------------------------------------------ */
  const menuCards = document.querySelectorAll('.menu-page .menu-card');

  menuCards.forEach(function(card) {

    card.addEventListener('mouseenter', function() {
      card.style.transform = 'translateY(-6px)';
    });

    card.addEventListener('mouseleave', function() {
      card.style.transform = 'translateY(0)';
    });

  });
    /* ------------------------------------------
     Order page quantity controls
  ------------------------------------------ */

  window.changeQty = function(change) {

    const input = document.getElementById('qty-input');

    if (!input) return;

    let value = parseInt(input.value, 10) || 1;

    value += change;

    if (value < 1) value = 1;
    if (value > 20) value = 20;

    input.value = value;

    updateTotal();
  };

  /* ------------------------------------------
     Update selected size
  ------------------------------------------ */

  window.updateSize = function(radio) {

    document.querySelectorAll('.size-card').forEach(function(card) {
      card.classList.remove('size-active');
    });

    const active = radio.closest('.size-card');

    if (active) {
      active.classList.add('size-active');
    }

    updateTotal();
  };

  /* ------------------------------------------
     Update total price
  ------------------------------------------ */

  function updateTotal() {

    if (typeof SIZES === 'undefined') return;

    const qtyInput = document.getElementById('qty-input');
    const totalEl = document.getElementById('order-total-price');
    const selected = document.querySelector('input[name="size"]:checked');

    if (!qtyInput || !totalEl || !selected) return;

    const qty = parseInt(qtyInput.value, 10) || 1;
    const size = selected.value;

    const total = (SIZES[size] || 0) * qty;

    totalEl.textContent = '₱' + total;
  }

  updateTotal();
})();