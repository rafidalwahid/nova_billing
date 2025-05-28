<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-lg overflow-hidden" v-if="!loading || tickets.length > 0">

    <!-- Desktop Table -->
    <div class="hidden lg:block overflow-x-auto">
      <table class="w-full">
        <!-- Table Header -->
        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600">
          <tr>
            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide">
              <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Ticket
              </div>
            </th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide">
              <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Subject
              </div>
            </th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide">
              <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Status
              </div>
            </th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide">
              <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Department
              </div>
            </th>
            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-200 tracking-wide">
              <div class="flex items-center justify-end gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Last Updated
              </div>
            </th>
          </tr>
        </thead>

        <!-- Table Body -->
        <tbody v-if="tickets.length > 0" class="divide-y divide-gray-100 dark:divide-gray-700">
          <tr
            v-for="ticket in tickets"
            :key="ticket.id"
            @click="$emit('viewTicket', ticket)"
            class="cursor-pointer transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 group"
          >
            <!-- Ticket Number -->
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-semibold text-blue-600 group-hover:text-blue-700">
                #{{ ticket.ticket_number }}
              </div>
              <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                {{ formatDate(ticket.created_at) }}
              </div>
            </td>

            <!-- Subject -->
            <td class="px-6 py-4">
              <div class="text-sm font-medium text-gray-900 dark:text-gray-100 group-hover:text-gray-700 dark:group-hover:text-gray-200">
                {{ ticket.subject }}
              </div>
              <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">
                {{ ticket.description ? ticket.description.substring(0, 80) + '...' : '' }}
              </div>
            </td>

            <!-- Status -->
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                :class="getStatusBadgeClass(ticket.status)"
                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium uppercase tracking-wider border"
              >
                {{ formatStatus(ticket.status) }}
              </span>
            </td>

            <!-- Department -->
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                {{ getDepartmentName(ticket.category || ticket.department?.name) }}
              </div>
            </td>

            <!-- Last Updated -->
            <td class="px-6 py-4 whitespace-nowrap text-right">
              <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ formatDate(ticket.updated_at) }}
              </div>
            </td>
          </tr>
        </tbody>

        <!-- Empty State for Table -->
        <tbody v-else-if="!loading">
          <tr>
            <td colspan="5" class="px-6 py-12 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.955 8.955 0 01-2.697-.413l-2.725.725.725-2.725A8.955 8.955 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z" />
              </svg>
              <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">No support tickets found</h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                You don't have any support tickets yet. Use the "Create Ticket" button above to get started.
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Mobile Card View -->
    <div v-if="tickets.length > 0" class="lg:hidden p-4 space-y-4">
      <div
        v-for="ticket in tickets"
        :key="ticket.id"
        @click="$emit('viewTicket', ticket)"
        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl p-4 cursor-pointer transition-all duration-200 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-lg group"
      >
        <!-- Ticket Header -->
        <div class="flex justify-between items-start mb-3">
          <div>
            <div class="text-sm font-semibold text-blue-600 group-hover:text-blue-700">
              #{{ ticket.ticket_number }}
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              {{ formatDate(ticket.created_at) }}
            </div>
          </div>
          <span
            :class="getStatusBadgeClass(ticket.status)"
            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium uppercase tracking-wider border"
          >
            {{ formatStatus(ticket.status) }}
          </span>
        </div>

        <!-- Subject -->
        <div class="mb-3">
          <div class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1 group-hover:text-gray-700 dark:group-hover:text-gray-200">
            {{ ticket.subject }}
          </div>
          <div v-if="ticket.description" class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">
            {{ ticket.description.substring(0, 120) }}{{ ticket.description.length > 120 ? '...' : '' }}
          </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-between items-center">
          <div class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
            {{ getDepartmentName(ticket.category || ticket.department?.name) }}
          </div>
          <div class="text-xs text-gray-500 dark:text-gray-400">
            Updated {{ formatDate(ticket.updated_at) }}
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination.last_page > 1" class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="text-sm text-gray-700 dark:text-gray-300 text-center sm:text-left">
          Showing {{ ((pagination.current_page - 1) * pagination.per_page) + 1 }} to
          {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} of
          {{ pagination.total }} results
        </div>
        <div class="flex items-center justify-center gap-2">
          <button
            @click="$emit('changePage', pagination.current_page - 1)"
            :disabled="pagination.current_page <= 1"
            class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700 flex-1 sm:flex-none"
          >
            Previous
          </button>
          <span class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
            Page {{ pagination.current_page }} of {{ pagination.last_page }}
          </span>
          <button
            @click="$emit('changePage', pagination.current_page + 1)"
            :disabled="pagination.current_page >= pagination.last_page"
            class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700 flex-1 sm:flex-none"
          >
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
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
        'open': 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800/30',
        'in_progress': 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/30',
        'resolved': 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border-green-200 dark:border-green-800/30',
        'closed': 'bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700',
        // Legacy support for old mock data
        'waiting_customer': 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/30',
      }
      return classes[status] || 'bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700'
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
