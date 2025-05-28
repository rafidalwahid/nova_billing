<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 shadow-lg mb-6">
    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div class="flex flex-col sm:flex-row gap-4">
        <!-- Search Input -->
        <div class="relative">
          <input
            :value="searchQuery"
            @input="$emit('update:searchQuery', $event.target.value)"
            type="text"
            placeholder="Search tickets..."
            class="w-full sm:w-64 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 focus:outline-none"
          />
        </div>

        <!-- Status Filter -->
        <select
          :value="statusFilter"
          @change="$emit('update:statusFilter', $event.target.value)"
          class="w-full sm:w-48 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 transition-all duration-200 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 focus:outline-none cursor-pointer"
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
          class="w-full sm:w-48 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 transition-all duration-200 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 focus:outline-none cursor-pointer"
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
          class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm whitespace-nowrap"
        >
          Create New Ticket
        </button>
      </div>
    </div>
  </div>
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
