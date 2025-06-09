<template>
    <div class="modal fade" :id="`confirmDeleteModal-${ticket.id}`" tabindex="-1" role="dialog"
        :aria-labelledby="`confirmDeleteModalLabel-${ticket.id}`" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" :id="`confirmDeleteModalLabel-${ticket.id}`">
                        Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" />
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this ticket?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger" @click="deleteTicket" :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm me-1" role="status"
                            aria-hidden="true"></span>
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'

const props = defineProps({
    ticket: {
        type: Object,
        required: true,
    },
    csrfToken: {
        type: String,
        required: true,
    },
})

const loading = ref(false)

const deleteTicket = async () => {
    loading.value = true
    try {
        await axios.post(`/ticket/${ticket.id}/delete`, null, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        })

        bootstrap.Modal.getInstance(
            document.getElementById(`confirmDeleteModal-${props.ticket.id}`)
        )?.hide()

        window.location.reload()

    } catch (error) {
        loading.value = false

        const msg =
            error.response?.data?.message || 'Something went wrong while deleting.'
        alert(`Delete failed: ${msg}`)
        console.error('Delete failed', error)
    }
}
</script>
