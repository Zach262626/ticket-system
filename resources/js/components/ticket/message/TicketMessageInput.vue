<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    status: String,
    userId: Number,
    ticketId: Number,
    tenantId: Number,
    csrfToken: String,
})
const emit = defineEmits(['message-sent'])
const message = ref('')
const localStatus = ref(props.status)
let channel


const sendMessage = async () => {
    try {
        const response = await axios.post('/ticket/message', {
            ticket_id: props.ticketId,
            sender_id: props.userId,
            content: message.value,
            _token: props.csrfToken,
        })
        if (response.data.message) {
            emit('message-sent', response.data.message)
        }
        message.value = ''
    } catch (error) {
        console.error('Error sending message:', error)
    }
}

const sendTypingEvent = () => {
    Echo.private(`tenant-${props.tenantId}.ticket-${props.ticketId}`).whisper("typing", {
        userID: props.userId,
    });
};

onMounted(() => {
    channel = Echo.private(`tenant-${props.tenantId}.user-${props.userId}`)
        .listen('.ticket.status.change', (e) => {
            localStatus.value = e.changes.new
        })
})
</script>

<template>
    <form @submit.prevent="sendMessage">
        <div class="input-group mb-3 mt-2" style="display: flex; align-items: center;">
            <div v-if="localStatus === 'in_progress'" style="display: flex; flex: 1;">
                <input v-model="message" name="content" type="text" class="form-control mx-2 rounded"
                    placeholder="Message here" style="flex: 1;" @keydown="sendTypingEvent" />
                <button type="submit" class="px-5 btn btn-primary" style="margin-left: 8px;">Send</button>
            </div>
            <div v-else style="display: flex; flex: 1;">
                <input type="text" class="form-control mx-2 rounded" placeholder="Wait for the support agent." disabled
                    style="flex: 1;" />
                <button type="button" class="px-5 btn btn-hidden" style="margin-left: 8px;">Send</button>
            </div>
        </div>
    </form>
</template>
