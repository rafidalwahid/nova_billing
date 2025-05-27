<template>
  <Card class="mb-6">
    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div class="flex flex-col sm:flex-row gap-4">
        <!-- Search Input -->
        <div class="relative">
          <input
            :value="searchQuery"
            @input="$emit('update:searchQuery', $event.target.value)"
            type="text"
            placeholder="Search tickets..."
            class="form-control form-input form-input-bordered w-full sm:w-64"
          />
        </div>

        <!-- Status Filter -->
        <select
          :value="statusFilter"
          @change="$emit('update:statusFilter', $event.target.value)"
          class="form-control form-select form-select-bordered w-full sm:w-48"
        >
          <option value="">All Statuses</option>
          <option value="open">Open</option>
          <option value="waiting_customer">Waiting for Your Response</option>
          <option value="resolved">Resolved</option>
          <option value="closed">Closed</option>
        </select>

        <!-- Department Filter -->
        <select
          :value="departmentFilter"
          @change="$emit('update:departmentFilter', $event.target.value)"
          class="form-control form-select form-select-bordered w-full sm:w-48"
        >
          <option value="">All Departments</option>
          <option value="billing">Billing Support</option>
          <option value="technical">Technical Support</option>
          <option value="general">General Support</option>
          <option value="sales">Sales Inquiry</option>
        </select>
      </div>

      <div class="flex items-center gap-4">
        <div class="text-sm text-gray-600 dark:text-gray-400">
          {{ totalTickets }} {{ totalTickets === 1 ? 'ticket' : 'tickets' }} total
        </div>
        <button
          @click="$emit('createTicket')"
          class="btn-primary"
        >
          Create New Ticket
        </button>
      </div>
    </div>
  </Card>
</template>

<script>
export default {
  name: 'TicketFilters',
  
  props: {
    searchQuery: {
      type: String,
      default: ''
    },
    statusFilter: {
      type: String,
      default: ''
    },
    departmentFilter: {
      type: String,
      default: ''
    },
    totalTickets: {
      type: Number,
      default: 0
    }
  },

  emits: [
    'update:searchQuery',
    'update:statusFilter', 
    'update:departmentFilter',
    'createTicket'
  ]
}
</script>
