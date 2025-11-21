/*
  Student & ID: Agraj Khanna 240195519 ID
  Description: Simple cart counter + mini cart panel for the Meals page.
*/

(function () {
  // Start cart count at 0
  var cartCount = 0;

  // The span in the navbar that shows "Cart (0)"
  var cartDisplay = document.getElementById('cartDisplay');

  // Mini cart panel elements
  var cartPanel = document.getElementById('cartPanel');
  var cartSummary = document.getElementById('cartSummary');
  var cartClose = cartPanel ? cartPanel.querySelector('.cart-close') : null;

  // All "Add to cart" buttons inside cards
  var addButtons = document.querySelectorAll('.card .cta');

  // Helper to update the summary text
  function updateCartSummary() {
    if (!cartSummary) return;
    var label = cartCount === 1 ? ' item' : ' items';
    cartSummary.textContent = 'You have ' + cartCount + label + ' in your cart.';
  }

  // Helper to toggle the cart panel
  function toggleCartPanel() {
    if (!cartPanel) return;
    var isOpen = cartPanel.classList.toggle('open');
    cartPanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
  }

  // If we are on the store page (cartDisplay exists)
  if (cartDisplay && addButtons.length > 0) {
    // Make cart pill keyboard-accessible
    cartDisplay.setAttribute('role', 'button');
    cartDisplay.setAttribute('tabindex', '0');

    // Click on cart pill opens/closes panel
    cartDisplay.addEventListener('click', function () {
      toggleCartPanel();
    });

    cartDisplay.addEventListener('keyup', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        toggleCartPanel();
      }
    });

    // Close button inside the panel
    if (cartClose) {
      cartClose.addEventListener('click', function () {
        cartPanel.classList.remove('open');
        cartPanel.setAttribute('aria-hidden', 'true');
      });
    }

    // Add-to-cart buttons increment count
    addButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault(); // stop the "#" link jumping to top

        cartCount++;
        cartDisplay.textContent = 'Cart (' + cartCount + ')';
        updateCartSummary();
      });
    });

    // Initialize summary text
    updateCartSummary();
  }
})();
