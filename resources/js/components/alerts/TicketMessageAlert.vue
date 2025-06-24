<template>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
import { useAlertStore } from '@/stores/useAlertStore'

const props = defineProps({
  tenantId: Number,
  userId: Number,
})

const store = useAlertStore()
let channel

onMounted(() => {
  channel = window.Echo.private(`tenant-${props.tenantId}.user-${props.userId}`)
    .listen('.ticket-message-sent', (e) => {
      if (!window.location.pathname.startsWith(`/ticket/${e.message.ticket.id}`)) {
        store.addAlert({
          message: `<a class="btn btn-link w-100" href="/ticket/${e.message.ticket.id}">Ticket #${e.message.ticket.id}: New message</a>`,
          type: 'light',
        })
      }
    })

})

onUnmounted(() => {
  if (channel) {
    window.Echo.leave(`tenant-${props.tenantId}.user-${props.userId}`)
  }
})
</script>
