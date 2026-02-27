(function () {
  const AUTOPLAY_MS = 4000;

  function uniq(arr) {
    const s = new Set();
    return arr.filter(x => {
      const k = String(x || '').trim();
      if (!k || s.has(k)) return false;
      s.add(k);
      return true;
    });
  }

  function normalize(src) {
    if (!src) return "";
    if (/^https?:\/\//i.test(src)) return src;
    if (src.startsWith("/")) return src;
    return "/" + src.replace(/^\/+/, "");
  }

  function filenameFromUrl(url) {
    const clean = String(url || "").split("?")[0];
    return clean.split("/").pop();
  }

  function build(root) {
    const mainSrc = root.getAttribute("data-main-src") || "";
    const mainFile = filenameFromUrl(mainSrc);

    const map = window.MP_GALLERY_BY_MAIN || {};
    const gallery = map[mainFile] || [mainSrc];
    const images = uniq((Array.isArray(gallery) ? gallery : [mainSrc]).map(normalize));

    const track = root.querySelector("[data-mp-track]");
    const thumbs = root.querySelector("[data-mp-thumbs]");
    const dotsWrap = root.querySelector("[data-mp-dots]");
    const prevBtn = root.querySelector("[data-mp-prev]");
    const nextBtn = root.querySelector("[data-mp-next]");
    const viewport = root.querySelector("[data-mp-viewport]");

    if (!track || !viewport || images.length === 0) return;

    track.innerHTML = images.map(src => (
      `<div class="mp-gallery__slide">
         <img class="mp-gallery__img" src="${src}" alt="Product image">
       </div>`
    )).join("");

    if (thumbs) {
      thumbs.innerHTML = images.map((src, i) => (
        `<button type="button" class="mp-thumb ${i===0 ? "is-active" : ""}" data-go="${i}" aria-label="View image ${i+1}">
           <img src="${src}" alt="Thumbnail ${i+1}">
         </button>`
      )).join("");
    }

    if (dotsWrap) {
      dotsWrap.innerHTML = images.map((_, i) => (
        `<span class="mp-dot ${i===0 ? "is-active" : ""}" data-dot="${i}"></span>`
      )).join("");
    }

    let index = 0;
    let timer = null;
    let paused = false;

    function setActiveUI() {
      thumbs?.querySelectorAll(".mp-thumb").forEach((b, i) => b.classList.toggle("is-active", i === index));
      dotsWrap?.querySelectorAll(".mp-dot").forEach((d, i) => d.classList.toggle("is-active", i === index));

      const single = images.length <= 1;
      if (prevBtn) prevBtn.disabled = single;
      if (nextBtn) nextBtn.disabled = single;
      if (prevBtn) prevBtn.style.display = single ? "none" : "";
      if (nextBtn) nextBtn.style.display = single ? "none" : "";
      if (dotsWrap) dotsWrap.style.display = single ? "none" : "";
    }

    function render() {
      track.style.transform = `translateX(${-index * 100}%)`;
      setActiveUI();
    }

    function go(to) {
      const max = images.length - 1;
      index = Math.max(0, Math.min(max, to));
      render();
    }

    function next() {
      go(index >= images.length - 1 ? 0 : index + 1);
    }

    function prev() {
      go(index <= 0 ? images.length - 1 : index - 1);
    }

    function startAutoplay() {
      stopAutoplay();
      if (images.length <= 1) return;
      timer = setInterval(() => {
        if (!paused) next();
      }, AUTOPLAY_MS);
    }

    function stopAutoplay() {
      if (timer) clearInterval(timer);
      timer = null;
    }

    prevBtn?.addEventListener("click", () => { paused = true; prev(); });
    nextBtn?.addEventListener("click", () => { paused = true; next(); });

    thumbs?.addEventListener("click", (e) => {
      const b = e.target.closest("[data-go]");
      if (!b) return;
      paused = true;
      go(parseInt(b.getAttribute("data-go"), 10) || 0);
    });

    root.addEventListener("mouseenter", () => { paused = true; });
    root.addEventListener("mouseleave", () => { paused = false; });

    let sx = 0, sy = 0, down = false;
    viewport.addEventListener("touchstart", (ev) => {
      const t = ev.touches[0];
      sx = t.clientX; sy = t.clientY; down = true; paused = true;
    }, { passive: true });

    viewport.addEventListener("touchend", (ev) => {
      if (!down) return;
      down = false;
      const t = ev.changedTouches[0];
      const dx = t.clientX - sx;
      const dy = t.clientY - sy;
      if (Math.abs(dy) > Math.abs(dx)) return;
      if (dx > 40) prev();
      if (dx < -40) next();
    }, { passive: true });

    render();
    startAutoplay();
  }

  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-mp-gallery]").forEach(build);
  });
})();