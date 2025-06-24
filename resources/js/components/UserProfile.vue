<script setup>
import { computed } from 'vue'

const props = defineProps({
    user: Object,
    width: {
        type: Number,
        default: 75,
    },
    subname: {
        type: Boolean,
        default: true,
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
    <div class="container-fluid justify-content-start p-0">
        <div class="pb-3">
            <div class="d-flex align-items-center flex-wrap">
                <div class="image me-3">
                    <img :src="avatarUrl" alt="Avatar" class="avatar" :width="width"
                        style="vertical-align: middle; border-radius: 50%; max-width: 100%;" />

                </div>
                <div class="flex-grow-1">
                    <div class="text-break" :style="{ fontSize: nameSize }">
                        {{ user.name }}
                    </div>
                    <div v-if="subname" class="px-2 text-break">company name</div>
                </div>
            </div>
        </div>
    </div>
</template>
