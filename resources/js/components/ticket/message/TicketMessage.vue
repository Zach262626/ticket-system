<script setup>
import { onMounted } from 'vue'
import { computed } from 'vue'
import dayjs from 'dayjs'

const props = defineProps({
  message: Object,
  userId: Number,
  tenantId: Number,
  ticketId: Number,
})

const formatDate = (dateString) => {
  return dayjs(dateString).format('MMM DD, YYYY hh:mm A')
}

const avatarUrl = computed(() => {
  return props.message.sender.profile_picture
    ? props.message.sender.profile_picture
    : `https://ui-avatars.com/api/?name=${encodeURIComponent(props.message.sender.name)}&background=random&color=fff`
})

</script>

<template>
  <div v-if="userId === message.sender_id" class="d-flex flex-row justify-content-start w-100">
    <div class="d-flex flex-column align-items-end w-100 pe-2">
      <div class="bg-primary text-white rounded-3 p-2 mb-1 text-end" style="max-width: 75%; word-wrap: break-word;">
        {{ message.content }}
      </div>
      <p class="small me-3 text-muted" style="font-size:12px">
        {{ formatDate(message.created_at) }}
      </p>
    </div>
    <img :src="avatarUrl" alt="Avatar" class="avatar" width="45"
      style="vertical-align: middle; border-radius: 50%; height: 45px" />
  </div>

  <div v-else class="d-flex flex-row justify-content-start w-100">
    <img :src="avatarUrl" alt="Avatar" class="avatar" width="45"
      style="vertical-align: middle; border-radius: 50%; height: 45px" />
    <div class="d-flex flex-column align-items-start w-100 ps-2">
      <div class="bg-body-tertiary rounded-3 p-2 mb-1 text-start" style="max-width: 75%; word-wrap: break-word;">
        {{ message.content }}
      </div>
      <p class="small me-3 text-muted" style="font-size:12px">
        {{ formatDate(message.created_at) }}
      </p>
    </div>
  </div>
</template>
