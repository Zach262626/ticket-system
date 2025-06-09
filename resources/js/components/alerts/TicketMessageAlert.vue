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
    .listen('.broadcast-message-received', (e) => {
      if (!window.location.pathname.startsWith(`/ticket/${e.ticket.id}`)) {
        store.addAlert({
          message: 'You have a new message!',
            body: `<a class="btn btn-light w-100" href="/ticket/${e.ticket.id}">View Message</a>`,
          type: 'info'
        })
      }
    })
})

onUnmounted(() => {
  if (channel) {
    Echo.leave(`tenant-${props.tenantId}.user-${props.userId}`)
  }
})
</script>
