import './bootstrap';

import "bootstrap";             // Bootstrap's JS (requires Popper internally)
import "../css/app.css";        // Import your CSS (with Bootstrap included)

// Optional: enable Bootstrap tooltips globally
document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = Array.from(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
});