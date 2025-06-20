import { createApp } from 'vue';
import { createPinia } from 'pinia'
import UserProfile from './components/UserProfile.vue';
// Tickets
import TicketTable from './components/ticket/TicketTable.vue';
import TicketCard from './components/ticket/TicketCard.vue';
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
import TicketStatusAlert from './components/alerts/TicketStatusAlert.vue';
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
app.component('user-profile', UserProfile);
// Tickets
app.component('ticket-table', TicketTable);
app.component('ticket-card', TicketCard);
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
app.component('ticket-status-alert', TicketStatusAlert);
//Modals
app.component('ticket-delete-modal', TicketDeleteModal)




app.mount('#app');

// // Alpine.js
// import Alpine from 'alpinejs'

// window.Alpine = Alpine
// Alpine.start()