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
    .listen('.ticket.deleted', (e) => {
      store.addAlert({
        message: `<div>Ticket ${e.ticketId} Deleted</div>`,
        type: 'danger',
      })
    })
})

onUnmounted(() => {
  if (channel) {
    window.Echo.leave(`tenant-${props.tenantId}`)
  }
})
</script>
