"use strict";

// ============================================
// ドロワーメニュー
// ============================================
const initDrawer = () => {
  const elements = {
    hamburger: document.querySelector(".js-hamburger"),
    drawer: document.querySelector(".js-drawer"),
    drawerClose: document.querySelector(".js-drawer-close"),
  };

  if (!elements.hamburger || !elements.drawer) return;

  const drawerLinks = elements.drawer.querySelectorAll("a");

  // ドロワーを閉じる
  const closeDrawer = () => {
    elements.hamburger.classList.remove("is-active");
    elements.drawer.classList.remove("is-active");
    document.body.classList.remove("is-drawer-open");
    elements.hamburger.setAttribute("aria-expanded", "false");
  };

  // ハンバーガーボタン：開閉トグル
  elements.hamburger.addEventListener("click", () => {
    const isActive = elements.drawer.classList.toggle("is-active");
    elements.hamburger.classList.toggle("is-active", isActive);
    document.body.classList.toggle("is-drawer-open", isActive);
    elements.hamburger.setAttribute("aria-expanded", String(isActive));
  });

  // オーバーレイクリックで閉じる
  elements.drawer.addEventListener("click", (event) => {
    if (event.target === elements.drawer) {
      closeDrawer();
    }
  });

  // 閉じるボタン：閉じてページトップへ
  if (elements.drawerClose) {
    elements.drawerClose.addEventListener("click", () => {
      closeDrawer();
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // リンククリックで閉じる
  drawerLinks.forEach((link) => {
    link.addEventListener("click", closeDrawer);
  });
};

// ============================================
// ページトップボタン
// ============================================
const initPagetop = () => {
  const pagetop = document.querySelector(".js-pagetop");

  if (!pagetop) return;

  // スクロール量に応じて表示・非表示
  window.addEventListener("scroll", () => {
    pagetop.classList.toggle("is-visible", window.scrollY > 300);
  });

  // クリックでページトップへ
  pagetop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
};

document.addEventListener("DOMContentLoaded", () => {
  initDrawer();
  initPagetop();
});
