// Mobile menu toggle
(function () {
	document.addEventListener("click", function (e) {
		if (
			!(
				e.target &&
				e.target.classList &&
				e.target.classList.contains("ef-menu-toggle")
			)
		)
			return;
		var btn = e.target;
		var header = btn.closest(".ef-header");
		if (!header) return;
		var navs = header.querySelectorAll(
			".ef-header-nav, .ef-header-nav--left, .ef-header-nav--right"
		);
		var expanded = btn.getAttribute("aria-expanded") === "true";
		btn.setAttribute("aria-expanded", expanded ? "false" : "true");
		navs.forEach(function (nav) {
			nav.classList.toggle("is-open");
		});
	});
})();
