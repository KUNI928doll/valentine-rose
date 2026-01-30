document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".js-hamburger");
  const drawer = document.querySelector(".js-drawer");
  const drawerClose = document.querySelector(".js-drawer-close");

  if (!hamburger || !drawer) {
    return;
  }

  const drawerLinks = drawer.querySelectorAll("a");

  const closeDrawer = () => {
    hamburger.classList.remove("is-active");
    drawer.classList.remove("is-active");
    document.body.classList.remove("is-drawer-open");
    hamburger.setAttribute("aria-expanded", "false");
  };

  hamburger.addEventListener("click", () => {
    const isActive = drawer.classList.toggle("is-active");
    hamburger.classList.toggle("is-active", isActive);
    document.body.classList.toggle("is-drawer-open", isActive);
    hamburger.setAttribute("aria-expanded", String(isActive));
  });

  drawer.addEventListener("click", (event) => {
    if (event.target === drawer) {
      closeDrawer();
    }
  });

  if (drawerClose) {
    drawerClose.addEventListener("click", () => {
      closeDrawer();
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  drawerLinks.forEach((link) => {
    link.addEventListener("click", closeDrawer);
  });
});

