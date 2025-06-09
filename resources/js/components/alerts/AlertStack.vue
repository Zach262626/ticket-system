<template>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div v-for="alert in store.alerts" :key="alert.id" class="toast show text-white" :class="bgClass(alert.type)"
            role="alert">
            <div class="toast-header">
                <img src="https://picsum.photos/200/300" class="rounded me-2" alt="..."
                    style="width: 32px; height: 32px; object-fit: cover;">
                <strong v-if="typeof alert.message === 'string'" class="me-auto">{{ alert.message }}</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" @click="store.removeAlert(alert.id)"></button>
            </div>
            <div class="toast-body">
                <div v-if="alert.body" v-html="alert.body"></div>
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
