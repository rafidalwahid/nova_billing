<template>
  <Card v-if="!loading || tickets.length > 0">
    <!-- Header with Create Button -->
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
      <div class="flex justify-between items-center">
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

    <!-- Table Header -->
    <div class="table-header">
      <div class="grid grid-cols-5 gap-4 text-sm font-medium text-gray-700 dark:text-gray-300">
        <div>Ticket #</div>
        <div>Subject</div>
        <div>Status</div>
        <div>Department</div>
        <div>Last Updated</div>
      </div>
    </div>

    <!-- Tickets -->
    <div v-if="tickets.length > 0">
      <div
        v-for="ticket in tickets"
        :key="ticket.id"
        @click="$emit('viewTicket', ticket)"
        class="table-row"
      >
        <div class="grid grid-cols-5 gap-4 items-center">
          <!-- Ticket Number -->
          <div>
            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
              #{{ ticket.ticket_number }}
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
              {{ formatDate(ticket.created_at) }}
            </div>
          </div>

          <!-- Subject -->
          <div>
            <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
              {{ ticket.subject }}
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
              {{ ticket.description ? ticket.description.substring(0, 60) + '...' : '' }}
            </div>
          </div>

          <!-- Status -->
          <div>
            <span
              :class="getStatusBadgeClass(ticket.status)"
              class="badge"
            >
              {{ formatStatus(ticket.status) }}
            </span>
          </div>

          <!-- Department -->
          <div class="text-sm text-gray-600 dark:text-gray-400">
            {{ getDepartmentName(ticket.category || ticket.department?.name) }}
          </div>

          <!-- Last Updated -->
          <div class="text-sm text-gray-600 dark:text-gray-400">
            {{ formatDate(ticket.updated_at) }}
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else-if="!loading" class="px-6 py-12 text-center">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.955 8.955 0 01-2.697-.413l-2.725.725.725-2.725A8.955 8.955 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No support tickets found</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        You don't have any support tickets yet. Create one if you need assistance.
      </p>
      <div class="mt-6">
        <button
          @click="$emit('createTicket')"
          class="btn-primary"
        >
          Create Your First Ticket
        </button>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination.last_page > 1" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="text-sm text-gray-700 dark:text-gray-300">
          Showing {{ ((pagination.current_page - 1) * pagination.per_page) + 1 }} to
          {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} of
          {{ pagination.total }} results
        </div>
        <div class="flex items-center gap-2">
          <button
            @click="$emit('changePage', pagination.current_page - 1)"
            :disabled="pagination.current_page <= 1"
            class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700"
          >
            Previous
          </button>
          <span class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300">
            Page {{ pagination.current_page }} of {{ pagination.last_page }}
          </span>
          <button
            @click="$emit('changePage', pagination.current_page + 1)"
            :disabled="pagination.current_page >= pagination.last_page"
            class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700"
          >
            Next
          </button>
        </div>
      </div>
    </div>
  </Card>
</template>

<script>
export default {
  name: 'TicketList',

  props: {
    tickets: {
      type: Array,
      default: () => []
    },
    loading: {
      type: Boolean,
      default: false
    },
    pagination: {
      type: Object,
      default: () => ({
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0
      })
    },
    totalTickets: {
      type: Number,
      default: 0
    }
  },

  emits: ['viewTicket', 'changePage', 'createTicket'],

  methods: {
    getStatusBadgeClass(status) {
      const classes = {
        'open': 'badge-blue',
        'in_progress': 'badge-orange',
        'resolved': 'badge-green',
        'closed': 'badge-gray',
        // Legacy support for old mock data
        'waiting_customer': 'badge-orange',
      }
      return classes[status] || 'badge-gray'
    },

    formatStatus(status) {
      const statusMap = {
        'open': 'Open',
        'in_progress': 'In Progress',
        'resolved': 'Resolved',
        'closed': 'Closed',
        // Legacy support for old mock data
        'waiting_customer': 'Waiting for Your Response'
      }
      return statusMap[status] || 'Unknown'
    },

    formatDate(date) {
      if (!date) return ''
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    },

    getDepartmentName(category) {
      const departmentNames = {
        'billing': 'Billing Support',
        'technical': 'Technical Support',
        'sales': 'Sales Inquiry',
        'general': 'General Support'
      }
      return departmentNames[category] || 'General Support'
    }
  }
}
</script>
