import { createApp } from 'vue';
import { createPinia } from 'pinia'
// Tickets
import TicketTable from './components/ticket/TicketTable.vue';
// Messages
import TicketMessage from './components/ticket/message/TicketMessage.vue';
import TicketMessagesPanel from './components/ticket/message/TicketMessagesPanel.vue';
import TicketMessageInput from './components/ticket/message/TicketMessageInput.vue';
// ALerts
import AlertStack from './components/alerts/AlertStack.vue';
import TicketMessageAlert from './components/alerts/TicketMessageAlert.vue';
import TicketCreatedAlert from './components/alerts/TicketCreatedAlert.vue';
import TicketDeletedAlert from './components/alerts/TicketDeletedAlert.vue';
import TicketUpdatedAlert from './components/alerts/TicketUpdatedAlert.vue';
// Modal
import TicketDeleteModal from './components/modal/TicketDeleteModal.vue';





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
const pinia = createPinia()
app.use(pinia)
// Tickets
app.component('ticket-table', TicketTable);

// Messages
app.component('ticket-message', TicketMessage);
app.component('ticket-messages-panel', TicketMessagesPanel);
app.component('ticket-message-input', TicketMessageInput);
// Alerts
app.component('alert-stack', AlertStack);
app.component('ticket-message-alert', TicketMessageAlert);
app.component('ticket-created-alert', TicketCreatedAlert);
app.component('ticket-deleted-alert', TicketDeletedAlert);
app.component('ticket-updated-alert', TicketUpdatedAlert);
//Modals
app.component('ticket-delete-modal', TicketDeleteModal)




app.mount('#app');

// // Alpine.js
// import Alpine from 'alpinejs'

// window.Alpine = Alpine
// Alpine.start()