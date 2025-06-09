import { createApp } from 'vue';
import TicketMessage from './components/ticket/TicketMessage.vue';
import TicketMessagesPanel from './components/ticket/TicketMessagesPanel.vue';
import TicketMessageInput from './components/ticket/TicketMessageInput.vue';

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

// Vue 3
const app = createApp({});
app.component('ticket-message', TicketMessage);
app.component('ticket-messages-panel', TicketMessagesPanel);
app.component('ticket-message-input', TicketMessageInput);

app.mount('#app');

// // Alpine.js
// import Alpine from 'alpinejs'

// window.Alpine = Alpine
// Alpine.start()