window.Cart = (function () {
  const STORAGE_KEY = 'preppalCart';
  let items = [];

  function load() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      const parsed = raw ? JSON.parse(raw) : [];
      items = Array.isArray(parsed) ? parsed : [];
    } catch {
      items = [];
    }
  }

  function save() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
  }

  function addItem(id, name, price, image) {
    const sid = String(id);
    const p = Number(price) || 0;

    const found = items.find(i => String(i.id) === sid);
    if (found) {
      found.qty = (Number(found.qty) || 0) + 1;
    } else {
      items.push({
        id: sid,
        name: name || 'Item',
        price: p,
        image: image || '',
        qty: 1
      });
    }
    save();
  }

  function removeItem(id) {
    const sid = String(id);
    items = items.filter(i => String(i.id) !== sid);
    save();
  }

  function clear() {
    items = [];
    save();
  }

  function getItems() {
    return items.map(i => ({ ...i }));
  }

  function getCount() {
    return items.reduce((s, i) => s + (Number(i.qty) || 0), 0);
  }

  function getTotal() {
    return items.reduce((s, i) => s + (Number(i.price) || 0) * (Number(i.qty) || 0), 0);
  }

  // allows other scripts to update if they want to
  function reload() {
    load();
  }

  load();

  return { addItem, removeItem, clear, getItems, getCount, getTotal, reload };
})();