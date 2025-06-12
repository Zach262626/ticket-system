<script setup>
import UserProfile from '@/components/UserProfile.vue'

const props = defineProps({
    ticket: Object,
})
</script>

<template>
    <div class="bg-dark px-3 py-2 rounded-1 text-light">
        Ticket #{{ ticket.id }}
    </div>
    <div class="px-4 pt-3 pb-2 bg-light">
        <div class="w-100">
            <UserProfile :user="ticket.created_by" :width="75" :subname="false" />
        </div>
        <div class="w-100">
            <strong>Description:</strong>
            <p class="ms-2">{{ ticket.description }}</p>
        </div>
        <template v-if="ticket.created_by?.phone_number">
            <div class="w-100">
                <strong>Phone Number:</strong>
                <p class="ms-2">{{ ticket.created_by.phone_number }}</p>
            </div>
        </template>
        <div class="w-100">
            <strong>Status:</strong>
            <p class="ms-2">{{ ticket.status?.name }}</p>
        </div>
        <div class="w-100">
            <strong>Type:</strong>
            <p class="ms-2">{{ ticket.type?.name }}</p>
        </div>
        <div class="w-100">
            <strong>Level:</strong>
            <p class="ms-2">{{ ticket.level?.name }}</p>
        </div>
        <div class="w-100 pb-2">
            <strong class="d-block mb-2">Accepted By:</strong>
            <template v-if="ticket.accepted_by">
                <UserProfile :user="ticket.accepted_by" :width="50" :subname="false" />
            </template>
            <template v-else>
                <div class="ms-2">Name Here</div>
            </template>
        </div>
    </div>
</template>
