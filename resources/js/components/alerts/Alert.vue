<template>
  <div class="toast show text-white" :class="bgClass" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        {{ message }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="$emit('dismiss')" />
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  message: String,
  type: {
    type: String,
    default: 'info' // info, success, danger, warning
  }
})

const bgClass = {
  info: 'bg-info',
  success: 'bg-success',
  warning: 'bg-warning',
  danger: 'bg-danger',
}[props.type] || 'bg-secondary'
</script>
