/*
  Student & ID: Agraj Khanna 240195519 ID
  Description: Simple cart counter for the Meals page.
*/

(function () {
  // Start cart count at 0
  var cartCount = 0;

  // The span in the navbar that shows "Cart (0)"
  var cartDisplay = document.getElementById('cartDisplay');

  // All "Add to cart" buttons inside cards
  var addButtons = document.querySelectorAll('.card .cta');

  // If we are on the store page (cartDisplay exists)
  if (cartDisplay && addButtons.length > 0) {
    addButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault(); // stop the "#" link jumping to top

        cartCount++;
        cartDisplay.textContent = 'Cart (' + cartCount + ')';
      });
    });
  }
})();
