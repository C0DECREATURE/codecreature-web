// redirect immediately if warnings not shown yet
if (
localStorage.getItem("showWarnings") != "false" &&
!window.location.pathname.includes("/warnings")
) {
	window.location.href = "/warnings?redirect="+window.location.href;
}

const isReducedMotion = window.matchMedia(`(prefers-reduced-motion: reduce)`) === true || window.matchMedia(`(prefers-reduced-motion: reduce)`).matches === true;

// returns true if a variable is true (boolean) or "true" (string)
// otherwise returns false
function isTrue(v) {
	if (v == "true" || v == true) { return true }
	else { return false }
}