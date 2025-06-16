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
    channel = window.Echo
        .private(channelName)
        .listen('.ticket.updated', (e) => {
            const listHtml = Object.entries(e.changes)
                .map(([field, value]) => {
                    const oldValue = value.old ?? '';
                    const newValue = value.new;
                    const arrow = oldValue ? ' → ' : '';
                    return `<li><strong>${field}</strong>: ${oldValue}${arrow}${newValue}</li>`;
                })
                .join('')
            store.addAlert({
                message: `<div>Ticket ${e.ticket.id} Updated</div>`,
                body: `<ul class="text-dark m-0 ps-3">${listHtml}</ul>`,
                type: 'light',
                isHtml: true
            })
        })
})


onUnmounted(() => {
    if (channel) {
        window.Echo.leave(`tenant-${props.tenantId}`)
    }
})
</script>
