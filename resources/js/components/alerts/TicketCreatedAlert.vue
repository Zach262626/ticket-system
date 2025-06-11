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
  channel = window.Echo.private(`viewall.tenant-${props.tenantId}`)
    .listen('.ticket.created', () => {
      console.log('here', window.location.pathname)
      if (!(window.location.pathname === '/ticket')) {
        store.addAlert({
          message: `<div>New Ticket Created</div>`,
          type: 'light',
        })
      }
    })
})

onUnmounted(() => {
  if (channel) {
    window.Echo.leave(`viewall.tenant-${props.tenantId}`)
  }
})
</script>
