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
    channel = window.Echo.private(`tenant-${props.tenantId}`)
        .listen('.ticket.updated', (e) => {
            store.addAlert({
                message: `<div>${e.changes}</div>`,
                type: 'light',
            })
        })
})

onUnmounted(() => {
    if (channel) {
        window.Echo.leave(`tenant-${props.tenantId}`)
    }
})
</script>
