<script setup>
import { onMounted, ref, onUnmounted, watch } from 'vue'

const props = defineProps({
  ticketMessages: Object,
  ticket: Object,
  userId: Number,
  tenantId: Number,
  csrfToken: String,
})

const messages = ref([])
const status = ref('')
let channel

watch(
  () => props.ticket.status?.name,
  newName => (status.value = newName),
  { immediate: true }
)

const addMessage = (newMessage) => {
  const exists = messages.value.some((m) => m.id === newMessage.id)
  if (!exists) {
    messages.value.unshift(newMessage)
  }
}

onMounted(() => {
  messages.value = [...props.ticketMessages]
  channel = Echo.private('tenant-' + props.tenantId + '.ticket-' + props.ticket.id)
    .listen('.broadcast-message-sent', (e) => {
      const messageReceived = e.message
      addMessage(messageReceived)
    })
})

onUnmounted(() => {
  if (channel) {
    Echo.leave('tenant-' + props.tenantId + '.ticket-' + props.ticket.id)
  }
})
</script>

<template>
  <div class="p-1 d-flex overflow-auto flex-column-reverse" style="height: 400px;" id="ticketMessages-container">
    <ticket-message v-for="message in messages" :key="message.id" :message="message" :user-id="userId"
      :tenant-id="tenantId" :ticket-id="ticket.id" />
  </div>

  <div>
    <ticket-message-input :user-id="userId" :ticket-id="ticket.id" :csrf-token="csrfToken"
      :status="ticket.status.name" @message-sent="addMessage" :tenant-id="tenantId" />
  </div>
</template>
