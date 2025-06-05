<script setup>
const props = defineProps({
  ticketMessages: Object,
  ticket: Object,
  senderId: Number,
  tenantId: Number,
  csrfToken: String,
})

// onMounted(() => {
//   Echo.private('channel-name')
//     .listen('.broadcast-test-true', (e) => {
//       console.log('here');
//     });
// });

</script>

<template>
  <div class="p-1 d-flex overflow-auto flex-column-reverse" style="height: 400px;" id="ticketMessages-container">
    <TicketMessage
      v-for="message in ticketMessages"
      :key="message.id"
      :message="message"
      :sender-id="senderId"
      :tenant-id="tenantId"
      :ticket-id="ticket.id"
    />
  </div>

  <div>
    <form action="/ticket/message" method="POST">
      <!-- Add @csrf manually via a hidden input if not using Blade to render -->
      <input type="hidden" name="_token" :value="csrfToken" />

      <div class="input-group mb-3 mt-2">
        <input type="hidden" name="ticket_id" :value="ticketId" />
        <input type="hidden" name="sender_id" :value="senderId" />

        <div v-if="ticket.status.name === 'in_progress'">
          <input
            name="content"
            type="text"
            class="form-control mx-2 rounded"
            aria-label="Sizing example input"
            aria-describedby="inputGroup-sizing-default"
            placeholder="Message here"
          />
          <span><button class="px-5 btn btn-primary">Send</button></span>
        </div>
        <div v-else>
          <input
            type="text"
            class="form-control mx-2 rounded"
            aria-label="Sizing example input"
            aria-describedby="inputGroup-sizing-default"
            placeholder="Wait for the support agent."
            disabled
          />
          <span><button type="button" class="px-5 btn btn-hidden">Send</button></span>
        </div>
      </div>
    </form>
  </div>

  <!-- <div v-if="senderId === currentUserId" class="d-flex flex-row justify-content-start w-100">
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
  </div> -->
</template>
