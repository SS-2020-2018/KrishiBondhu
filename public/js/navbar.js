document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector(".kb-navbar");
    const collapseElement = document.getElementById("navbarNav");
    const navLinks = document.querySelectorAll(".kb-nav-link[href]");
    const currentPath = window.location.pathname.replace(/\/+$/, "") || "/";

    if (navbar) {
        const syncNavbarState = () => {
            navbar.classList.toggle("shadow-lg", window.scrollY > 8);
        };

        syncNavbarState();
        window.addEventListener("scroll", syncNavbarState, { passive: true });
    }

    navLinks.forEach((link) => {
        try {
            const linkPath =
                new URL(link.href).pathname.replace(/\/+$/, "") || "/";
            if (linkPath === currentPath) {
                link.classList.add("active");
                link.setAttribute("aria-current", "page");
            }
        } catch {
            // Ignore malformed URLs.
        }
    });

    document.querySelectorAll(".navbar-collapse .nav-link").forEach((link) => {
        link.addEventListener("click", () => {
            if (!collapseElement || window.innerWidth >= 992) {
                return;
            }

            const bootstrapCollapse =
                window.bootstrap?.Collapse.getOrCreateInstance(collapseElement);
            bootstrapCollapse?.hide();
        });
    });
});
