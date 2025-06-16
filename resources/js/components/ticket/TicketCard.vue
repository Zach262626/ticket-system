<!-- TicketCard.vue -->
<script setup>
import { reactive, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({ ticket: Object, tenantId: Number, userId: Number })
const t = reactive({ ...props.ticket })

const merge = (src) => {
    for (const k in src) {
        const incoming = src[k]
        if (incoming !== undefined &&
            (typeof incoming === 'object' || incoming === null)) {
            t[k] = incoming
        }
    }
}

watch(() => props.ticket, merge)

let channel
onMounted(() => {
    channel = window.Echo.private(`tenant-${props.tenantId}.user-${props.userId}`)

    channel.listen('.ticket.updated', (e) => {
        if (e.ticket.id === t.id) {
            merge(e.ticket)
        }
    })

    channel.listen('.ticket.status.change', (e) => {
        if (e.ticket.id === t.id) {
            merge(e.ticket)
        }
    })
})

onUnmounted(() => channel && window.Echo.leave(`tenant-${props.tenantId}`))
</script>


<template>
    <div>
        <div class="bg-dark px-3 py-2 rounded-1 text-light">
            Ticket #{{ t.id }}
        </div>

        <div class="px-4 pt-3 pb-2 bg-light">
            <div class="w-100">
                <user-profile :user="t.created_by" :width="75" :subname="false" />
            </div>

            <div class="w-100">
                <strong>Description:</strong>
                <p class="ms-2">{{ t.description }}</p>
            </div>
            <template v-if="t.created_by?.phone_number">
                <div class="w-100">
                    <strong>Phone Number:</strong>
                    <p class="ms-2">{{ t.created_by.phone_number }}</p>
                </div>
            </template>

            <div class="w-100">
                <strong>Status:</strong>
                <p class="ms-2">{{ t.status?.name }}</p>
            </div>

            <div class="w-100">
                <strong>Type:</strong>
                <p class="ms-2">{{ t.type?.name }}</p>
            </div>

            <div class="w-100">
                <strong>Level:</strong>
                <p class="ms-2">{{ t.level?.name }}</p>
            </div>

            <div class="w-100 pb-2">
                <strong class="d-block mb-2">Accepted By:</strong>

                <template v-if="t.accepted_by">
                    <user-profile :user="t.accepted_by" :width="50" :subname="false" />
                </template>
                <template v-else>
                    <div class="ms-2">Name Here</div>
                </template>
            </div>
        </div>
    </div>
</template>
