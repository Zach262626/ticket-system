// import { createApp } from 'vue';
// import TicketMessages from './components/ticket/TicketMessages.vue';
import './bootstrap';

import "bootstrap";             // Bootstrap's JS (requires Popper internally)
import "../scss/app.scss";        // Import your SASS (with Bootstrap included)

// Optional: enable Bootstrap tooltips globally
document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = Array.from(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
});

// // Vue 3
// const app = createApp({});
// app.component('ticket-messages', TicketMessages);
// app.mount('#app');

// Alpine.js
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()