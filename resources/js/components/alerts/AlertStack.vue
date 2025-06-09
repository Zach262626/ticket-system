<template>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div v-for="alert in store.alerts" :key="alert.id" class="toast show text-white" :class="bgClass(alert.type)"
            role="alert">
            <div class="d-flex">
                <div class="toast-body">{{ alert.message }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    @click="store.removeAlert(alert.id)"></button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAlertStore } from '@/stores/useAlertStore'

const store = useAlertStore()

const bgClass = (type) => ({
    success: 'bg-success',
    danger: 'bg-danger',
    warning: 'bg-warning',
    info: 'bg-info'
}[type] || 'bg-secondary')

const props = defineProps({
    tenantId: Number,
    userId: Number,
})

onMounted(() => {
    Echo.private(`tenant-${props.tenantId}.user-${props.userId}`)
        .listen('.broadcast-message-received', (e) => {
            store.addAlert(`New message: ${e.message.content}`, 'info');
        })
})
</script>
