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
      const isCurrentlyOpen = item.classList.contains("is-open");

      if (!isCurrentlyOpen) {
        items.forEach((other) => {
          const t = other.querySelector(".js-faq-trigger");
          if (other === item) {
            other.classList.add("is-open");
            if (t) t.setAttribute("aria-expanded", "true");
          } else {
            other.classList.remove("is-open");
            if (t) t.setAttribute("aria-expanded", "false");
          }
        });
      } else {
        item.classList.remove("is-open");
        trigger.setAttribute("aria-expanded", "false");
      }
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

// ============================================
// 下層ページ KV：スクロール連動パララックス（transform）
// ============================================
const initPageHeroParallax = () => {
  const wraps = document.querySelectorAll(".js-page-hero-parallax");
  if (!wraps.length) return;

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  let ticking = false;

  const update = () => {
    wraps.forEach((wrap) => {
      const bg = wrap.querySelector(".page-hero__bg");
      if (!bg) return;
      const rect = wrap.getBoundingClientRect();
      // ビューポートに対する位置で背景を少し遅れて動かす（参考: fixed 背景系デモの代替）
      const speed = 0.35;
      const y = rect.top * speed;
      bg.style.transform = `translate3d(0, ${y}px, 0)`;
    });
    ticking = false;
  };

  const onScrollOrResize = () => {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        update();
      });
      ticking = true;
    }
  };

  window.addEventListener("scroll", onScrollOrResize, { passive: true });
  window.addEventListener("resize", onScrollOrResize);
  update();
};

// ============================================
// スクロールで要素が下からふわっと表示（セクション単位ではなく子要素ごと / 1s）
// お問い合わせ（page-reserve）のみ除外
// ============================================
const FADE_UP_SELECTORS = [
  "main > .fv picture",
  // FV キャッチは .fv__title-wrap 一括ではなく .fv__title-line ごとにふわっと表示
  "main .fv__title-line",
  "main :is(h1,h2,h3,h4,h5,h6):not(.visually-hidden)",
  // .faq__answer はアニメでボタンより上に重なりクリック不能になるため除外
  "main p:not(.visually-hidden):not(.faq__answer):not(.fv__title)",
  "main figure",
  "main table",
  "main blockquote",
  "main address",
  "main dl",
  "main nav.breadcrumb",
  "main .button",
  "main .news__link > *",
  "main .price-menu__link",
  "main .price-menu__blank",
  "main .concept__more",
  "main .reserve-cta__media",
  "main .reserve-cta__copy",
  "main .salons-sns__col",
  "main .salons-sns__vline",
  "main .salons-sns__rule",
  "main .feature__nav-item",
  "main .feature__head--overlap",
  "main .feature__panel-img",
  "main .feature__panel-text > *",
  "main .page-hero__title-strip .inner",
  "main .page-hero__parallax",
  "main .price-page-intro__breadcrumb-bar .inner",
  "main .price-page-intro__layout > *",
  "main .concept-instagram__cell",
  "main .concept-instagram__btn-wrap",
  "main .concept-instagram__head",
  "main .concept-profile__head",
  "main .price-section__title",
  "main .price-section__title-ja",
  "main .price-section__category",
  "main .price-table-wrap",
  "main .price-page-intro__copy",
  "main .salon-concept__intro-row > *",
  "main .salon-single__breadcrumb-bar .inner",
  "main .salon-single-flow__item",
  "main .salon-single-access__grid",
  "main .salons-archive-intro .inner",
  "main .salons-archive-region",
  "main .salons-archive-card",
  "main .news-archive__inner",
  "main .news-archive__item",
  "main .news-single__inner",
  "main .news-single__article",
  "footer .footer__logo",
  "footer .footer__nav",
  "footer .footer__copyright",
];

const filterToInnermostTargets = (nodes) => {
  const arr = [...nodes];
  return arr.filter((el) => !arr.some((other) => other !== el && el.contains(other)));
};

const initFadeUpScroll = () => {
  if (document.body.classList.contains("page-reserve")) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  const seen = new Set();
  FADE_UP_SELECTORS.forEach((sel) => {
    document.querySelectorAll(sel).forEach((el) => {
      if (el.closest("header")) {
        return;
      }
      seen.add(el);
    });
  });

  const targets = filterToInnermostTargets(seen);
  if (targets.length === 0) {
    return;
  }

  targets.forEach((el) => {
    el.classList.add("js-fadeup");
  });

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }
        entry.target.classList.add("is-fadeup-inview");
        io.unobserve(entry.target);
      });
    },
    {
      root: null,
      rootMargin: "0px 0px -8% 0px",
      threshold: 0,
    },
  );

  targets.forEach((el) => io.observe(el));
};

// ============================================
// ニュース一覧：カテゴリーフィルター（サイドバー）
// ============================================
const initNewsArchiveFilter = () => {
  const list = document.querySelector(".news-archive__list");
  if (!list) return;

  const items = list.querySelectorAll(".news-archive__item[data-news-category]");
  const filterLinks = document.querySelectorAll(".js-news-archive-filter[data-news-filter]");
  const emptyEl = document.getElementById("news-archive-empty");
  const pagination = document.querySelector(".news-archive__pagination");

  if (!items.length || !filterLinks.length) return;

  const applyFilter = (filter) => {
    let visibleCount = 0;

    items.forEach((li) => {
      const cat = li.getAttribute("data-news-category");
      const show = filter === "all" || cat === filter;
      li.hidden = !show;
      if (show) visibleCount += 1;
    });

    filterLinks.forEach((link) => {
      const key = link.getAttribute("data-news-filter");
      if (key === filter) {
        link.setAttribute("aria-current", "true");
      } else {
        link.removeAttribute("aria-current");
      }
    });

    if (emptyEl) {
      emptyEl.hidden = visibleCount > 0;
    }

    if (pagination) {
      pagination.hidden = filter !== "all";
    }
  };

  filterLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
      event.preventDefault();
      const filter = link.getAttribute("data-news-filter");
      if (!filter) return;
      applyFilter(filter);
      try {
        history.replaceState(null, "", `#${filter === "all" ? "news-archive" : filter}`);
      } catch {
        /* noop */
      }
    });
  });

  const hash = window.location.hash.slice(1);
  const hashMap = { news: "news", column: "column", all: "all", "news-archive": "all" };
  const initial = hashMap[hash] ?? "all";
  applyFilter(initial);
};

document.addEventListener("DOMContentLoaded", () => {
  initPageHeroParallax();
  initDrawer();
  initPagetop();
  initFaq();
  initFeatureSlider();
  initNewsArchiveFilter();
  initFadeUpScroll();
});
