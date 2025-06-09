<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
    status: String,
    senderId: Number,
    ticketId: Number,
    csrfToken: String,
})
const emit = defineEmits(['message-sent'])
const message = ref('')
const sendMessage = async () => {
    try {
        const response = await axios.post('/ticket/message', {
            ticket_id: props.ticketId,
            sender_id: props.senderId,
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
</script>

<template>
    <form @submit.prevent="sendMessage">
        <div class="input-group mb-3 mt-2" style="display: flex; align-items: center;">
            <div v-if="status === 'in_progress'" style="display: flex; flex: 1;">
                <input v-model="message" name="content" type="text" class="form-control mx-2 rounded"
                    placeholder="Message here" style="flex: 1;" />
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
