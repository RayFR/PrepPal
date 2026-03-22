/*
  File: aa_authors.js
  Description: Main JavaScript wrapper for the PrepPal frontend.
  Notes:
  - Preserves the intended load order for the split JavaScript files.
  - Requires type="module" if loaded directly as a single script.
  - If modules are not being used, keep loading the individual files separately.

  Contributors:
  - Agraj Khanna (240195519), Leader / Frontend (HTML,CSS,JS)
  - Gurpreet Singh Sidhu (230237915), UI Frontend Assistant Designer (HTML,CSS,JS)
*/

import "./admin-orders.js";
import "./admin-users.js";
import "./admin.js";
import "./app.js";
import "./calculator.js";
import "./cart.js";
import "./checkout.js";
import "./currency.js";
import "./dashboard.js";
import "./mp-gallery-data.js";
import "./mp-gallery.js";
import "./newsletter.js";
import "./store.js";