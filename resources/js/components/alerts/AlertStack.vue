<template>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div v-for="alert in store.alerts" :key="alert.id" class="toast show text-white" :class="[
            bgClass(alert.type),
            !alert.body ? 'rounded-bottom' : ''
        ]" role="alert">
            <div class="toast-header" :class="!alert.body ? 'rounded-bottom' : ''">
                <img v-if="alert.image" :src="alert.image" class="rounded me-2" alt="..."
                    style="width: 32px; height: 32px; object-fit: cover;">
                <strong v-if="alert.message" v-html="alert.message" class="me-auto"></strong>
                <button type="button" class="btn-close" @click="store.removeAlert(alert.id)"></button>
            </div>
            <div v-if="alert.body" class="toast-body" v-html="alert.body">
            </div>
        </div>
    </div>
</template>

<script setup>
import { useAlertStore } from '@/stores/useAlertStore'

const store = useAlertStore()

const bgClass = (type) => ({
    success: 'bg-success',
    danger: 'bg-danger',
    warning: 'bg-warning',
    info: 'bg-info'
}[type] || 'bg-secondary')
</script>
