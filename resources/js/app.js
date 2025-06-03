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
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});
app.component('example-component', ExampleComponent);
app.mount('#app');