<script setup>
import { onMounted, watchEffect, ref } from 'vue'
const props = defineProps({
  ticketMessages: Object,
  ticket: Object,
  senderId: Number,
  tenantId: Number,
  csrfToken: String,
})
const messages = ref([])

onMounted(() => {
  messages.value = [...props.ticketMessages]
  Echo.private('tenant-' + props.tenantId + '.ticket-' + props.ticket.id)
    .listen('.broadcast-message', (e) => {
      const messageReceived = e.message
      const exists = messages.value.some(m => m.id === messageReceived.id)
      console.log('here')
      if (!exists) {
        messages.value.unshift(messageReceived)
      }
    });
})

</script>

<template>
  <div class="p-1 d-flex overflow-auto flex-column-reverse" style="height: 400px;" id="ticketMessages-container">
    <ticket-message v-for="message in messages" :key="message.id" :message="message" :sender-id="senderId"
      :tenant-id="tenantId" :ticket-id="ticket.id" />
  </div>

  <div>
    <ticket-message-input :sender-id="senderId" :ticket-id="ticket.id" :csrf-token="csrfToken"
      :status="ticket.status.name" />
  </div>
</template>
