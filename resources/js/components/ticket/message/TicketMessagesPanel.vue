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
const isTyping = ref(false);
const isTypingTimer = ref(null);

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
  channel = Echo.private('tenant-' + props.tenantId + '.user-' + props.userId)
    .listen('.ticket-message-sent', (e) => {
      const messageReceived = e.message
      addMessage(messageReceived)
    })
    .listenForWhisper("typing", (response) => {
      isTyping.value = response.userID !== props.userId;
      if (isTypingTimer.value) {
        clearTimeout(isTypingTimer.value);
      }

      isTypingTimer.value = setTimeout(() => {
        isTyping.value = false;
      }, 1000);
    });
})

onUnmounted(() => {
  if (channel) {
    Echo.leave('tenant-' + props.tenantId + '.ticket-' + props.ticket.id)
  }
})

const avatarUrl = computed(() => {
  const { created_by, accepted_by } = props.ticket
  const otherUser = created_by?.id !== props.userId ? created_by : accepted_by

  if (!otherUser) return null

  return otherUser.profile_picture
    ? `/storage/${otherUser.profile_picture}`
    : `https://ui-avatars.com/api/?name=${encodeURIComponent(otherUser.name)}&background=random&color=fff`
})


</script>
<style>
.typing-indicator {
  display: flex;
  gap: 0.25rem;
  align-items: center;
}

.typing-indicator .spinner-grow {
  width: 0.75rem;
  height: 0.75rem;
}

.typing-indicator .spinner-grow:nth-child(1) {
  animation-delay: 0s;
}

.typing-indicator .spinner-grow:nth-child(2) {
  animation-delay: 0.2s;
}

.typing-indicator .spinner-grow:nth-child(3) {
  animation-delay: 0.4s;
}
</style>

<template>
  <div class="p-1 d-flex overflow-auto flex-column-reverse" style="height: 400px;" id="ticketMessages-container">
    <div v-if="isTyping" class="d-flex flex-row justify-content-start w-100">
      <img :src="avatarUrl" alt="Avatar" class="avatar" width="45"
        style="vertical-align: middle; border-radius: 50%; height: 45px" />
      <div class="d-flex flex-column align-items-start w-100 ps-2">
        <div class="bg-body-tertiary rounded-3 p-2 mb-1 text-start typing-indicator"
          style="max-width: 75%; word-wrap: break-word;">
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
    <ticket-message v-for="message in messages" :key="message.id" :message="message" :user-id="userId"
      :tenant-id="tenantId" :ticket-id="ticket.id" />
  </div>
  <div>
    <ticket-message-input :user-id="userId" :ticket-id="ticket.id" :csrf-token="csrfToken" :status="ticket.status.name"
      @message-sent="addMessage" :tenant-id="tenantId" />
  </div>
</template>
