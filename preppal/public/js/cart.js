/*
  Students & IDs: Agraj Khanna / Gurpreet Singh Sidhu
  Description: Global cart manager
  - Tracks items (id, name, price, image, qty)
  - Persists to localStorage
  - Exposes API for other scripts
*/

const Cart = (function () {
  const STORAGE_KEY = 'preppalCart';
  let items = [];

  // --- Storage ---
  function load() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      items = raw ? JSON.parse(raw) : [];
    } catch {
      items = [];
    }
  }

  function save() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
  }

  // --- Operations ---
  function addItem(id, name, price, image) {
    const existing = items.find(item => item.id == id);
    if (existing) {
      existing.qty += 1;
    } else {
      items.push({ id, name, price, image, qty: 1 });
    }
    save();
  }

  function removeItem(id) {
    items = items.filter(item => item.id != id);
    save();
  }

  function clear() {
    items = [];
    save();
  }

  function getItems() {
    return [...items]; // return a copy
  }

  function getCount() {
    return items.reduce((sum, item) => sum + item.qty, 0);
  }

  function getTotal() {
    return items.reduce((sum, item) => sum + item.price * item.qty, 0);
  }

  // init load
  load();

  return {
    addItem,
    removeItem,
    clear,
    getItems,
    getCount,
    getTotal,
  };
})();