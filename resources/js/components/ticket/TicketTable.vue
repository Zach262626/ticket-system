<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  tickets: Array,
  can: Object,
  csrfToken: String,
  userId: Number,
  tenantId: Number,
})

const tickets = ref([])
let channel

const addTicket = (newTicket) => {
  const alreadyExists = tickets.value.some(ticket => ticket.id === newTicket.id)
  if (!alreadyExists) {
    tickets.value.push(newTicket)
  }
}

const updateTicketStatus = (ticketId, newStatusName, newStatusId = null) => {
  const index = tickets.value.findIndex(ticket => ticket.id === ticketId)
  if (index === -1) return

  const ticket = tickets.value[index]
  const currentStatus = ticket.status ?? {}

  const updatedStatus = {
    ...currentStatus,
    id: newStatusId ?? currentStatus.id,
    name: newStatusName,
  }

  tickets.value[index] = {
    ...ticket,
    status: updatedStatus,
  }
}

const replaceTicket = (updatedTicket) => {
  const index = tickets.value.findIndex(ticket => ticket.id === updatedTicket.id)
  if (index !== -1) {
    tickets.value[index] = updatedTicket
  }
}
const removeTicket = (ticketId) => {
  tickets.value = tickets.value.filter(ticket => ticket.id !== ticketId)
}

onMounted(() => {
  tickets.value = [...props.tickets]

  if (props.can.viewAll) {
    Echo.private(`tenant-${props.tenantId}.user-${props.userId}`)
      .listen('.ticket.created', (e) => {
        console.log('ticket received')
        addTicket(e.ticket)
      })
  }

  Echo.private(`tenant-${props.tenantId}`)
    .listen('.ticket.status.change', (e) => {
      updateTicketStatus(
        e.ticket.id,
        e.ticket.status?.name ?? e.changes?.new ?? 'Unknown',
        e.ticket.status_id ?? null
      )
    })
    .listen('.ticket.updated', (e) => {
      replaceTicket(e.ticket)
    })
})

onUnmounted(() => {
  Echo.leave(`tenant-${props.tenantId}`)
  if (props.can.viewAll) {
    Echo.leave(`tenant-${props.tenantId}`)
  }
})
</script>

<template>
  <div>
    <table class="table mt-2 w-100 table-fixed align-middle text-break">
      <thead>
        <tr>
          <th class="col-1" scope="col">Ticket #</th>
          <th class="col-5" scope="col">Description</th>
          <th class="col-1" scope="col">Type</th>
          <th class="col-1" scope="col">Status</th>

          <template v-if="can.edit">
            <template v-if="can.delete">
              <th class="col-1 text-center" scope="col">Assign</th>
              <th class="col-1 text-center" scope="col">Delete</th>
            </template>
            <template v-else>
              <th class="col-2 text-center" scope="col">Assigned By</th>
            </template>
            <th class="col-1 text-center" scope="col">Edit</th>
          </template>

          <th class="col-1 text-center" scope="col">View</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="ticket in tickets" :key="ticket.id">
          <td scope="row">{{ ticket.id }}</td>
          <td>{{ ticket.description }}</td>
          <td>{{ ticket.type?.name || '—' }}</td>
          <td>{{ ticket.status?.name || '—' }}</td>

          <template v-if="can.edit">
            <template v-if="can.delete">
              <td class="text-center">
                <template v-if="ticket.accepted_by">
                  {{ ticket.accepted_by.name }}
                </template>
                <template v-else>
                  <form :action="`/ticket/${ticket.id}/assign`" method="POST">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <button class="btn btn-primary w-100" type="submit">
                      <i class="bi bi-person-check"></i>
                    </button>
                  </form>
                </template>
              </td>

              <td>
                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                  :data-bs-target="`#confirmDeleteModal-${ticket.id}`">
                  <i class="bi bi-trash"></i>
                </button>
                <ticket-delete-modal :ticket="ticket" :csrf-token="csrfToken" />
              </td>
            </template>

            <template v-else>
              <td class="text-center">
                {{ ticket.accepted_by?.name || '—' }}
              </td>
            </template>

            <td>
              <a class="btn btn-primary w-100" :href="`/ticket/${ticket.id}/edit`">
                <i class="bi bi-pencil-square"></i>
              </a>
            </td>
          </template>

          <td>
            <a class="btn btn-secondary w-100" :href="`/ticket/${ticket.id}`">
              <i class="bi bi-eye"></i>
            </a>
          </td>
        </tr>

        <tr v-if="tickets.length === 0">
          <td colspan="8" class="text-center">No tickets available.</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-3">
      <slot name="pagination" />
    </div>
  </div>
</template>
