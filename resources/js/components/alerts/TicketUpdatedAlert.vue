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
        .listen('.ticket.updated', (e) => {
            const listHtml = Object.entries(e.changes)     
                .map(([field, value]) =>
                    `<li><strong>${field}</strong>: ${value}</li>`
                )
                .join('')                             
            store.addAlert({
                message: `<div>Ticket Updated</div>`,
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
