<script setup>
import { computed } from 'vue'

const props = defineProps({
    user: Object,
    width: {
        type: Number,
        default: 75,
    },
    showName: {
        type: Boolean,
        default: true,
    },
    showSubname: {
        type: Boolean,
        default: false,
    },
    subname: {
        type: String,
        default: '',
    },
})

const avatarUrl = computed(() =>
    props.user.profile_picture
        ? `/storage/${props.user.profile_picture}`
        : `https://ui-avatars.com/api/?name=${encodeURIComponent(props.user.name)}&background=random&color=fff`
)

const nameSize = computed(() => `clamp(16px, ${30 * (props.width / 100)}px, 6vw)`)
</script>

<template>
    <div class="d-flex align-items-center">
        <div class="me-2">
            <img :src="avatarUrl" alt="Avatar" :width="width"
                style="border-radius: 50%; max-width: 100%; object-fit: cover;" />
        </div>
        <div>
            <div v-if="showName" class="" :style="{ fontSize: nameSize }">
                {{ user.name }}
            </div>
            <div v-if="showSubname" class="text-muted small">
                {{ subname }}
            </div>
        </div>
    </div>
</template>