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
  const channelName = `tenant-${props.tenantId}.user-${props.userId}`

  channel = window.Echo.private(channelName)
    .listen('.ticket.created', (e) => {
      console.log('Ticket Created Event:', e)
      store.addAlert({
        message: `<div>New Ticket Created: 
                    <a href="/ticket/${e.ticket.id}" 
                      class="btn btn-link p-0 align-baseline">
                      Ticket #${e.ticket.id}
                    </a>
                  </div>`,
        type: 'success',
        isHtml: true,
      })
    })
})

onUnmounted(() => {
  if (channel) {
    Echo.leave(`tenant-${props.tenantId}.user-${props.userId}`)
  }
})
</script>
