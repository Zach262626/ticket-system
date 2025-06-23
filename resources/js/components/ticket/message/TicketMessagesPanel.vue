<script setup>
import { onMounted, ref, onUnmounted, watch, computed } from 'vue'

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
    .listen('.ticket-message-sent', (e) => {
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
  <div v-if="typing" class="d-flex flex-row justify-content-start w-100">
    <img :src="avatarUrl" alt="Avatar" class="avatar" width="45"
      style="vertical-align: middle; border-radius: 50%; height: 45px" />
    <div class="d-flex flex-column align-items-start w-100 ps-2">
      <div class="bg-body-tertiary rounded-3 p-2 mb-1 text-start" style="max-width: 75%; word-wrap: break-word;">
        <div class="spinner-grow spinner-grow-sm text-dark" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow spinner-grow-sm text-dark" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow spinner-grow-sm text-dark" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <p class="small me-3 text-muted" style="font-size:12px">
      </p>
    </div>
  </div>
  <div>
    <ticket-message-input :user-id="userId" :ticket-id="ticket.id" :csrf-token="csrfToken" :status="ticket.status.name"
      @message-sent="addMessage" :tenant-id="tenantId" />
  </div>
</template>
