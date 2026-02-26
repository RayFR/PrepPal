// PrepPal Currency + Country/Flag selector (SVG images)
// Base prices are stored in GBP. We convert display + totals on the fly.
// Storage key: preppalCurrency

(function () {
  const KEY = 'preppalCurrency';
  const BASE = 'GBP';

  // Static demo rates vs GBP. (target = gbp * rate)
  const RATES = {
    GBP: 1,
    EUR: 1.17,
    USD: 1.26,
    CAD: 1.70,
    AUD: 1.95,
    INR: 105.0,
    AED: 4.62,
    SAR: 4.73
  };

  // Small inline SVG flags (no extra files needed).
  // These are simplified but look clean in the navbar.
  const FLAGS = {
    GBP: svgUK(),
    EUR: svgEU(),
    USD: svgUS(),
    CAD: svgCA(),
    AUD: svgAU(),
    INR: svgIN(),
    AED: svgAE(),
    SAR: svgSA()
  };

  const META = {
    GBP: { symbol: '£', label: 'United Kingdom' },
    EUR: { symbol: '€', label: 'Eurozone' },
    USD: { symbol: '$', label: 'United States' },
    CAD: { symbol: '$', label: 'Canada' },
    AUD: { symbol: '$', label: 'Australia' },
    INR: { symbol: '₹', label: 'India' },
    AED: { symbol: 'د.إ', label: 'UAE' },
    SAR: { symbol: '﷼', label: 'Saudi Arabia' }
  };

  function safeCurrency(code) {
    const c = String(code || '').toUpperCase();
    return RATES[c] ? c : BASE;
  }

  function get() {
    return safeCurrency(localStorage.getItem(KEY) || BASE);
  }

  function set(code) {
    const c = safeCurrency(code);
    localStorage.setItem(KEY, c);
    broadcast();
    return c;
  }

  function rate(code) {
    return RATES[safeCurrency(code)];
  }

  function convertFromBase(amountGBP, code) {
    const n = Number(amountGBP) || 0;
    return n * rate(code);
  }

  function convertToBase(amount, code) {
    const n = Number(amount) || 0;
    return n / rate(code);
  }

  function format(amountGBP, code) {
    const c = safeCurrency(code || get());
    const value = convertFromBase(amountGBP, c);

    try {
      return new Intl.NumberFormat(undefined, {
        style: 'currency',
        currency: c,
        maximumFractionDigits: 2
      }).format(value);
    } catch {
      const sym = (META[c] && META[c].symbol) || '';
      return `${sym}${value.toFixed(2)}`;
    }
  }

  function meta(code) {
    const c = safeCurrency(code || get());
    return META[c] || META[BASE];
  }

  function flagSvg(code) {
    const c = safeCurrency(code || get());
    return FLAGS[c] || FLAGS[BASE];
  }

  function refreshMoneyNodes(root) {
    const scope = root || document;
    const nodes = scope.querySelectorAll('[data-money-gbp]');
    const c = get();

    nodes.forEach((el) => {
      const gbp = Number(el.getAttribute('data-money-gbp')) || 0;
      const suffix = el.getAttribute('data-money-suffix') || '';
      el.textContent = `${format(gbp, c)}${suffix}`;
    });
  }

  function broadcast() {
    try {
      window.dispatchEvent(new CustomEvent('pp:currencyChanged', { detail: { currency: get() } }));
    } catch {}
    refreshMoneyNodes();
    updatePickerUI();
  }

  // Convert Store filter inputs back to GBP on submit so server-side filters still work.
  function bindStoreFilters() {
    const form = document.getElementById('storeFiltersForm');
    if (!form) return;

    form.addEventListener('submit', () => {
      const c = get();
      if (c === BASE) return;

      const minEl = document.getElementById('min_price');
      const maxEl = document.getElementById('max_price');

      if (minEl && minEl.value && isFinite(Number(minEl.value))) {
        minEl.value = convertToBase(minEl.value, c).toFixed(2);
      }
      if (maxEl && maxEl.value && isFinite(Number(maxEl.value))) {
        maxEl.value = convertToBase(maxEl.value, c).toFixed(2);
      }
    });
  }

  // ---------- Custom dropdown (images) ----------
  const CURRENCIES = ['GBP', 'EUR', 'USD', 'CAD', 'AUD', 'INR', 'AED', 'SAR'];

  function buildMenu() {
    const menu = document.getElementById('ppCurrencyMenu');
    if (!menu) return;

    menu.innerHTML = '';

    CURRENCIES.forEach((code) => {
      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'pp-currency-item';
      item.setAttribute('role', 'option');
      item.dataset.value = code;

      const m = meta(code);

      item.innerHTML = `
        <span class="pp-currency-item-flag" aria-hidden="true">${flagSvg(code)}</span>
        <span class="pp-currency-item-main">
          <span class="pp-currency-item-code">${code}</span>
          <span class="pp-currency-item-label">${m.label}</span>
        </span>
      `;

      item.addEventListener('click', () => {
        set(code);
        closeMenu();
      });

      menu.appendChild(item);
    });
  }

  function updatePickerUI() {
    const btn = document.getElementById('ppCurrencyBtn');
    const flag = document.getElementById('ppCurrencyFlag');
    const codeEl = document.getElementById('ppCurrencyCode');
    const menu = document.getElementById('ppCurrencyMenu');

    if (!btn || !flag || !codeEl || !menu) return;

    const c = get();
    codeEl.textContent = c;
    flag.innerHTML = flagSvg(c);

    // mark selected
    const items = menu.querySelectorAll('.pp-currency-item');
    items.forEach((it) => it.classList.toggle('is-selected', it.dataset.value === c));
  }

  function openMenu() {
    const btn = document.getElementById('ppCurrencyBtn');
    const menu = document.getElementById('ppCurrencyMenu');
    if (!btn || !menu) return;

    menu.classList.add('open');
    btn.setAttribute('aria-expanded', 'true');
    menu.focus();
  }

  function closeMenu() {
    const btn = document.getElementById('ppCurrencyBtn');
    const menu = document.getElementById('ppCurrencyMenu');
    if (!btn || !menu) return;

    menu.classList.remove('open');
    btn.setAttribute('aria-expanded', 'false');
  }

  function toggleMenu() {
    const menu = document.getElementById('ppCurrencyMenu');
    if (!menu) return;
    menu.classList.contains('open') ? closeMenu() : openMenu();
  }

  function bindPicker() {
    const wrap = document.getElementById('ppCurrency');
    const btn = document.getElementById('ppCurrencyBtn');
    const menu = document.getElementById('ppCurrencyMenu');
    if (!wrap || !btn || !menu) return;

    buildMenu();
    updatePickerUI();

    btn.addEventListener('click', (e) => {
      e.preventDefault();
      toggleMenu();
    });

    // close on outside click
    document.addEventListener('click', (e) => {
      if (!wrap.contains(e.target)) closeMenu();
    });

    // keyboard close
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu();
    });
  }

  // ---------- Expose API ----------
  window.PPCurrency = {
    BASE,
    get,
    set,
    rate,
    meta,
    format, // expects GBP
    convertFromBase,
    convertToBase,
    refreshMoneyNodes
  };

  document.addEventListener('DOMContentLoaded', () => {
    bindPicker();
    bindStoreFilters();
    refreshMoneyNodes();
  });

  // ---------------- SVG helpers ----------------
  function svgWrap(inner) {
    return `
      <svg class="pp-flag" viewBox="0 0 24 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <rect width="24" height="16" rx="2" fill="#fff"/>
        ${inner}
        <rect width="24" height="16" rx="2" fill="none" stroke="rgba(255,255,255,.18)"/>
      </svg>
    `.trim();
  }

  function svgUK() {
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#012169"/>
      <path d="M0 0 L24 16 M24 0 L0 16" stroke="#FFF" stroke-width="3"/>
      <path d="M0 0 L24 16 M24 0 L0 16" stroke="#C8102E" stroke-width="1.6"/>
      <path d="M12 0 V16 M0 8 H24" stroke="#FFF" stroke-width="5"/>
      <path d="M12 0 V16 M0 8 H24" stroke="#C8102E" stroke-width="3"/>
    `);
  }

  function svgEU() {
    // EU-like: blue + circle of dots
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#1A47B8"/>
      <circle cx="12" cy="8" r="4.2" fill="none" stroke="#FFCC00" stroke-width="1.2" stroke-dasharray="0.2 1.6"/>
      <circle cx="12" cy="8" r="0.9" fill="#FFCC00"/>
    `);
  }

  function svgUS() {
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#B22234"/>
      ${Array.from({ length: 7 }, (_, i) => `<rect x="0" y="${i * 2.2857}" width="24" height="1.1428" fill="#fff" opacity="0.95"/>`).join('')}
      <rect x="0" y="0" width="10.5" height="8" fill="#3C3B6E"/>
      <circle cx="2.2" cy="1.6" r="0.45" fill="#fff"/><circle cx="4.2" cy="1.6" r="0.45" fill="#fff"/><circle cx="6.2" cy="1.6" r="0.45" fill="#fff"/><circle cx="8.2" cy="1.6" r="0.45" fill="#fff"/>
      <circle cx="3.2" cy="3.2" r="0.45" fill="#fff"/><circle cx="5.2" cy="3.2" r="0.45" fill="#fff"/><circle cx="7.2" cy="3.2" r="0.45" fill="#fff"/>
      <circle cx="2.2" cy="4.8" r="0.45" fill="#fff"/><circle cx="4.2" cy="4.8" r="0.45" fill="#fff"/><circle cx="6.2" cy="4.8" r="0.45" fill="#fff"/><circle cx="8.2" cy="4.8" r="0.45" fill="#fff"/>
      <circle cx="3.2" cy="6.4" r="0.45" fill="#fff"/><circle cx="5.2" cy="6.4" r="0.45" fill="#fff"/><circle cx="7.2" cy="6.4" r="0.45" fill="#fff"/>
    `);
  }

  function svgCA() {
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#fff"/>
      <rect x="0" y="0" width="5" height="16" fill="#D80621"/>
      <rect x="19" y="0" width="5" height="16" fill="#D80621"/>
      <path d="M12 3.1 l1 2.1 2-.7-1.2 1.9 1.9.4-1.7 1.2.9 1.8-1.9-.8-.5 2.1-.5-2.1-1.9.8.9-1.8-1.7-1.2 1.9-.4-1.2-1.9 2 .7z"
            fill="#D80621"/>
    `);
  }

  function svgAU() {
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#012169"/>
      <circle cx="17.8" cy="9" r="1.1" fill="#fff"/>
      <circle cx="20.3" cy="5.4" r="0.8" fill="#fff"/>
      <circle cx="15.4" cy="5.6" r="0.7" fill="#fff"/>
      <circle cx="19.0" cy="12.3" r="0.7" fill="#fff"/>
      <rect x="0" y="0" width="10.2" height="7.2" fill="#012169"/>
      <path d="M0 0 L10.2 7.2 M10.2 0 L0 7.2" stroke="#FFF" stroke-width="1.6"/>
      <path d="M0 0 L10.2 7.2 M10.2 0 L0 7.2" stroke="#C8102E" stroke-width="0.9"/>
      <path d="M5.1 0 V7.2 M0 3.6 H10.2" stroke="#FFF" stroke-width="2.5"/>
      <path d="M5.1 0 V7.2 M0 3.6 H10.2" stroke="#C8102E" stroke-width="1.5"/>
    `);
  }

  function svgIN() {
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#fff"/>
      <rect x="0" y="0" width="24" height="5.33" fill="#FF9933"/>
      <rect x="0" y="10.67" width="24" height="5.33" fill="#138808"/>
      <circle cx="12" cy="8" r="2" fill="none" stroke="#000080" stroke-width="0.8"/>
      <circle cx="12" cy="8" r="0.6" fill="#000080"/>
    `);
  }

  function svgAE() {
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#fff"/>
      <rect x="0" y="0" width="6" height="16" fill="#FF0000"/>
      <rect x="6" y="0" width="18" height="5.33" fill="#00732F"/>
      <rect x="6" y="5.33" width="18" height="5.34" fill="#fff"/>
      <rect x="6" y="10.67" width="18" height="5.33" fill="#000"/>
    `);
  }

  function svgSA() {
    return svgWrap(`
      <rect width="24" height="16" rx="2" fill="#006C35"/>
      <rect x="5.2" y="11.3" width="13.6" height="0.9" fill="#fff" opacity="0.95"/>
      <circle cx="12" cy="7.5" r="1.6" fill="rgba(255,255,255,.22)"/>
      <circle cx="12" cy="7.5" r="0.8" fill="rgba(255,255,255,.35)"/>
    `);
  }
})();
