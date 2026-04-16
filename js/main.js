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

// ============================================
// FAQ アコーディオン
// ============================================
const initFaq = () => {
  const items = document.querySelectorAll(".js-faq-item");

  items.forEach((item) => {
    const trigger = item.querySelector(".js-faq-trigger");
    if (!trigger) return;

    trigger.addEventListener("click", () => {
      const isOpen = item.classList.toggle("is-open");
      trigger.setAttribute("aria-expanded", String(isOpen));
    });
  });
};

// ============================================
// Feature スライダー（5秒自動・フェード・タブ連動）
// ============================================
const initFeatureSlider = () => {
  const root = document.querySelector(".js-feature-slider");
  if (!root) return;

  const tabs = root.querySelectorAll(".feature__nav-btn");
  const imagePanels = root.querySelectorAll(".feature__panel-img");
  const textPanels = root.querySelectorAll(".feature__panel-text");
  const total = textPanels.length;
  if (total === 0) return;

  const DURATION_MS = 5000;
  let current = 0;
  let timerId = null;

  const goTo = (index) => {
    current = ((index % total) + total) % total;

    imagePanels.forEach((panel, i) => {
      const on = i === current;
      panel.classList.toggle("is-active", on);
    });

    textPanels.forEach((panel, i) => {
      const on = i === current;
      panel.classList.toggle("is-active", on);
      panel.setAttribute("aria-hidden", on ? "false" : "true");
    });

    tabs.forEach((tab, i) => {
      const on = i === current;
      tab.classList.toggle("is-active", on);
      tab.setAttribute("aria-selected", String(on));
    });
  };

  const stopTimer = () => {
    if (timerId !== null) {
      window.clearInterval(timerId);
      timerId = null;
    }
  };

  const startTimer = () => {
    stopTimer();
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
      return;
    }
    timerId = window.setInterval(() => {
      goTo(current + 1);
    }, DURATION_MS);
  };

  tabs.forEach((tab, i) => {
    tab.addEventListener("click", () => {
      goTo(i);
      startTimer();
    });
  });

  document.addEventListener("visibilitychange", () => {
    if (document.hidden) {
      stopTimer();
    } else {
      startTimer();
    }
  });

  goTo(0);
  startTimer();
};

document.addEventListener("DOMContentLoaded", () => {
  initDrawer();
  initPagetop();
  initFaq();
  initFeatureSlider();
});
