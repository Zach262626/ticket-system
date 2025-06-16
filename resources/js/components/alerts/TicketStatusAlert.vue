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
  channel = window.Echo
    .private(`tenant-${props.tenantId}`)
    .listen('.ticket.status.change', (e) => {
      const ticketId = e.ticket?.id ?? 'Unknown'
      const newStatus = e.changes?.new ?? 'Unknown'

      store.addAlert({
        message: `<div>Ticket #${ticketId} status changed to <strong>${newStatus}</strong></div>`,
        type: 'warning',
        isHtml: true,
      })
    })
})

onUnmounted(() => {
  if (channel) {
    window.Echo.leave(`tenant-${props.tenantId}`)
  }
})
</script>
