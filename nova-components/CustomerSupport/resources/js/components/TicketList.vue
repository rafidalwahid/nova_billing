<template>
  <div
    v-if="!loading || tickets.length > 0"
    class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-600 shadow-lg shadow-gray-100 dark:shadow-gray-900/20 overflow-hidden transition-all duration-300"
  >
    <!-- Desktop Table (XL screens) -->
    <div class="hidden xl:block overflow-x-auto">
      <table class="w-full">
        <!-- Table Header -->
        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-600">
          <tr>
            <th class="w-12 px-4 xl:px-6 py-3 xl:py-4 text-left">
              <input
                type="checkbox"
                class="rounded-md border-gray-300 dark:border-gray-600 text-emerald-600 focus:ring-emerald-500 focus:ring-2 transition-all duration-200"
              />
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              ID
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Ticket Number
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Customer
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Subject
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Status
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Priority
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Category
            </th>
            <th class="px-4 xl:px-6 py-3 xl:py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Assigned To
            </th>
          </tr>
        </thead>

        <!-- Table Body -->
        <tbody v-if="tickets.length > 0" class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
          <tr
            v-for="ticket in tickets"
            :key="ticket.id"
            @click="$emit('viewTicket', ticket)"
            class="cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300 group"
          >
            <!-- Checkbox -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap">
              <input
                type="checkbox"
                class="rounded-md border-gray-300 dark:border-gray-600 text-emerald-600 focus:ring-emerald-500 focus:ring-2 transition-all duration-200"
                @click.stop
              />
            </td>

            <!-- ID -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap text-sm font-semibold text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 transition-colors duration-200">
              {{ ticket.id }}
            </td>

            <!-- Ticket Number -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap">
              <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                  {{ ticket.ticket_number }}
                </span>
              </div>
            </td>

            <!-- Customer -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap">
              <div class="flex items-center gap-2 xl:gap-3">
                <div class="w-6 h-6 xl:w-8 xl:h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                  {{ getCustomerInitials(getCustomerName(ticket)) }}
                </div>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                  {{ getCustomerName(ticket) }}
                </span>
              </div>
            </td>

            <!-- Subject -->
            <td class="px-4 xl:px-6 py-4 xl:py-5">
              <div class="max-w-xs xl:max-w-sm">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                  {{ ticket.subject }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                  {{ formatDate(ticket.created_at) }}
                </p>
              </div>
            </td>

            <!-- Status -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap">
              <span
                :class="getStatusBadgeClass(ticket.status)"
                class="inline-flex items-center px-2 xl:px-3 py-1 xl:py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm transition-all duration-200 hover:shadow-md"
              >
                <div class="w-1.5 h-1.5 rounded-full mr-1 xl:mr-2" :class="getStatusDotClass(ticket.status)"></div>
                {{ formatStatus(ticket.status) }}
              </span>
            </td>

            <!-- Priority -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap">
              <span
                :class="getPriorityBadgeClass(ticket.priority)"
                class="inline-flex items-center px-2 xl:px-3 py-1 xl:py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm transition-all duration-200 hover:shadow-md"
              >
                {{ formatPriority(ticket.priority) }}
              </span>
            </td>

            <!-- Category -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap">
              <span
                :class="getCategoryBadgeClass(ticket.category)"
                class="inline-flex items-center px-2 xl:px-3 py-1 xl:py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm transition-all duration-200 hover:shadow-md"
              >
                {{ formatCategory(ticket.category) }}
              </span>
            </td>

            <!-- Assigned To -->
            <td class="px-4 xl:px-6 py-4 xl:py-5 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
              <span class="font-medium">{{ getAssignedTo(ticket) }}</span>
            </td>
          </tr>
        </tbody>

        <!-- Empty State for Table -->
        <tbody v-else-if="!loading">
          <tr>
            <td colspan="9" class="px-6 py-12 text-center">
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

    <!-- Tablet View (Large screens but not XL) -->
    <div v-if="tickets.length > 0" class="hidden lg:block xl:hidden overflow-x-auto">
      <table class="w-full">
        <!-- Tablet Header -->
        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-600">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Ticket
            </th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Customer
            </th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Subject
            </th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Status
            </th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
              Priority
            </th>
          </tr>
        </thead>
        <!-- Tablet Body -->
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
          <tr
            v-for="ticket in tickets"
            :key="ticket.id"
            @click="$emit('viewTicket', ticket)"
            class="cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300 group"
          >
            <!-- Ticket Info -->
            <td class="px-4 py-4">
              <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                <div>
                  <div class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                    #{{ ticket.ticket_number }}
                  </div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                    ID: {{ ticket.id }}
                  </div>
                </div>
              </div>
            </td>

            <!-- Customer -->
            <td class="px-4 py-4">
              <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                  {{ getCustomerInitials(getCustomerName(ticket)) }}
                </div>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                  {{ getCustomerName(ticket) }}
                </span>
              </div>
            </td>

            <!-- Subject -->
            <td class="px-4 py-4">
              <div class="max-w-xs">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                  {{ ticket.subject }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                  {{ formatDate(ticket.created_at) }}
                </p>
              </div>
            </td>

            <!-- Status -->
            <td class="px-4 py-4">
              <span
                :class="getStatusBadgeClass(ticket.status)"
                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm"
              >
                <div class="w-1.5 h-1.5 rounded-full mr-1" :class="getStatusDotClass(ticket.status)"></div>
                {{ formatStatus(ticket.status) }}
              </span>
            </td>

            <!-- Priority -->
            <td class="px-4 py-4">
              <span
                :class="getPriorityBadgeClass(ticket.priority)"
                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm"
              >
                {{ formatPriority(ticket.priority) }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Mobile Card View -->
    <div v-if="tickets.length > 0" class="lg:hidden p-3 sm:p-4 md:p-6 space-y-3 sm:space-y-4">
      <div
        v-for="ticket in tickets"
        :key="ticket.id"
        @click="$emit('viewTicket', ticket)"
        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 cursor-pointer transition-all duration-300 hover:border-emerald-300 dark:hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-100 dark:hover:shadow-emerald-900/20 group transform hover:-translate-y-1"
      >
        <!-- Ticket Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 sm:gap-4 mb-4">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg sm:rounded-xl flex items-center justify-center text-white text-xs sm:text-sm font-semibold flex-shrink-0">
              {{ getCustomerInitials(getCustomerName(ticket)) }}
            </div>
            <div class="min-w-0 flex-1">
              <div class="text-sm sm:text-base font-semibold text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-700 dark:group-hover:text-emerald-300 truncate">
                #{{ ticket.ticket_number }}
              </div>
              <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                ID: {{ ticket.id }} • {{ formatDate(ticket.created_at) }}
              </div>
            </div>
          </div>
          <span
            :class="getStatusBadgeClass(ticket.status)"
            class="inline-flex items-center px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm border self-start"
          >
            <div class="w-1.5 h-1.5 rounded-full mr-1.5 sm:mr-2" :class="getStatusDotClass(ticket.status)"></div>
            <span class="hidden xs:inline">{{ formatStatus(ticket.status) }}</span>
            <span class="xs:hidden">{{ formatStatus(ticket.status).substring(0, 4) }}</span>
          </span>
        </div>

        <!-- Subject -->
        <div class="mb-4">
          <div class="text-sm sm:text-base font-semibold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-gray-700 dark:group-hover:text-gray-200 line-clamp-2">
            {{ ticket.subject }}
          </div>
          <div v-if="ticket.description" class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">
            {{ truncateText(ticket.description, 120) }}
          </div>
        </div>

        <!-- Badges Row -->
        <div class="flex flex-wrap gap-2 mb-4">
          <span
            :class="getPriorityBadgeClass(ticket.priority)"
            class="inline-flex items-center px-2 sm:px-2.5 py-1 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm border"
          >
            {{ formatPriority(ticket.priority) }}
          </span>
          <span
            :class="getCategoryBadgeClass(ticket.category)"
            class="inline-flex items-center px-2 sm:px-2.5 py-1 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm border"
          >
            {{ formatCategory(ticket.category) }}
          </span>
        </div>

        <!-- Footer -->
        <div class="flex flex-col xs:flex-row xs:justify-between xs:items-center gap-2 xs:gap-0 pt-3 border-t border-gray-100 dark:border-gray-700">
          <div class="text-xs text-gray-500 dark:text-gray-400">
            <span class="font-medium">{{ getCustomerName(ticket) }}</span>
          </div>
          <div class="text-xs text-gray-500 dark:text-gray-400">
            Updated {{ formatDate(ticket.updated_at) }}
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination.last_page > 1" class="px-3 sm:px-4 md:px-6 py-4 sm:py-5 border-t border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
        <!-- Results Info -->
        <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 text-center sm:text-left font-medium">
          <span class="hidden sm:inline">
            Showing <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ ((pagination.current_page - 1) * pagination.per_page) + 1 }}</span> to
            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }}</span> of
            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ pagination.total }}</span> results
          </span>
          <span class="sm:hidden">
            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ ((pagination.current_page - 1) * pagination.per_page) + 1 }}-{{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }}</span> of
            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ pagination.total }}</span>
          </span>
        </div>

        <!-- Navigation Controls -->
        <div class="flex items-center justify-center gap-2 sm:gap-3">
          <button
            @click="$emit('changePage', pagination.current_page - 1)"
            :disabled="pagination.current_page <= 1"
            class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-white dark:hover:bg-gray-600 hover:shadow-md transition-all duration-200 flex-1 sm:flex-none bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300"
          >
            <span class="hidden xs:inline">← Previous</span>
            <span class="xs:hidden">←</span>
          </button>

          <!-- Page Info -->
          <div class="flex items-center gap-1 sm:gap-2">
            <span class="px-2 sm:px-3 py-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap font-medium">
              <span class="hidden sm:inline">Page </span><span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ pagination.current_page }}</span><span class="hidden sm:inline"> of </span><span class="sm:hidden">/</span><span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ pagination.last_page }}</span>
            </span>
          </div>

          <button
            @click="$emit('changePage', pagination.current_page + 1)"
            :disabled="pagination.current_page >= pagination.last_page"
            class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-white dark:hover:bg-gray-600 hover:shadow-md transition-all duration-200 flex-1 sm:flex-none bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300"
          >
            <span class="hidden xs:inline">Next →</span>
            <span class="xs:hidden">→</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

// Icon Components
const TicketIcon = {
  template: `
    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
    </svg>
  `
}

const MessageIcon = {
  template: `
    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
  `
}

const StatusIcon = {
  template: `
    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
  `
}

const DepartmentIcon = {
  template: `
    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
    </svg>
  `
}

const ClockIcon = {
  template: `
    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
  `
}

export default {
  name: 'TicketList',

  components: {
    TicketIcon,
    MessageIcon,
    StatusIcon,
    DepartmentIcon,
    ClockIcon
  },

  props: {
    tickets: {
      type: Array,
      default: () => [],
      validator: (tickets) => Array.isArray(tickets)
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
      }),
      validator: (pagination) => {
        return pagination &&
               typeof pagination.current_page === 'number' &&
               typeof pagination.last_page === 'number' &&
               typeof pagination.per_page === 'number' &&
               typeof pagination.total === 'number'
      }
    },
    totalTickets: {
      type: Number,
      default: 0,
      validator: (value) => value >= 0
    }
  },

  emits: {
    viewTicket: (ticket) => ticket && typeof ticket === 'object',
    changePage: (page) => typeof page === 'number' && page > 0,
    createTicket: null
  },

  setup() {
    // Status badge classes mapping - Enhanced Material Design
    const statusClasses = {
      'open': 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-700',
      'in_progress': 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-700',
      'resolved': 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700',
      'closed': 'bg-gray-100 dark:bg-gray-700/50 text-gray-800 dark:text-gray-300 border-gray-200 dark:border-gray-600',
      'waiting_customer': 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 border-orange-200 dark:border-orange-700'
    }

    // Status dot classes mapping
    const statusDotClasses = {
      'open': 'bg-blue-500',
      'in_progress': 'bg-amber-500',
      'resolved': 'bg-emerald-500',
      'closed': 'bg-gray-500',
      'waiting_customer': 'bg-orange-500'
    }

    // Priority badge classes mapping - Enhanced Material Design
    const priorityClasses = {
      'low': 'bg-slate-100 dark:bg-slate-900/30 text-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700',
      'normal': 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700',
      'high': 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-700',
      'urgent': 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-700'
    }

    // Category badge classes mapping - Enhanced Material Design
    const categoryClasses = {
      'general': 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700',
      'billing': 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700',
      'technical': 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border-purple-200 dark:border-purple-700',
      'sales': 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-700'
    }

    // Status display names mapping
    const statusNames = {
      'open': 'Open',
      'in_progress': 'In Progress',
      'resolved': 'Resolved',
      'closed': 'Closed',
      'waiting_customer': 'Waiting for Your Response'
    }

    // Priority display names mapping
    const priorityNames = {
      'low': 'Low',
      'normal': 'Normal',
      'high': 'High',
      'urgent': 'Urgent'
    }

    // Category display names mapping
    const categoryNames = {
      'general': 'General',
      'billing': 'Billing',
      'technical': 'Technical',
      'sales': 'Sales'
    }

    return {
      statusClasses,
      statusDotClasses,
      priorityClasses,
      categoryClasses,
      statusNames,
      priorityNames,
      categoryNames
    }
  },

  methods: {
    getStatusBadgeClass(status) {
      return this.statusClasses[status] || this.statusClasses.closed
    },

    getStatusDotClass(status) {
      return this.statusDotClasses[status] || this.statusDotClasses.closed
    },

    getPriorityBadgeClass(priority) {
      return this.priorityClasses[priority] || this.priorityClasses.normal
    },

    getCategoryBadgeClass(category) {
      return this.categoryClasses[category] || this.categoryClasses.general
    },

    formatStatus(status) {
      return this.statusNames[status] || 'Unknown'
    },

    formatPriority(priority) {
      return this.priorityNames[priority] || 'Normal'
    },

    formatCategory(category) {
      return this.categoryNames[category] || 'General'
    },

    getCustomerName(ticket) {
      return ticket.customer?.name || ticket.user?.name || 'John Doe'
    },

    getCustomerInitials(name) {
      if (!name) return 'JD'
      const parts = name.split(' ')
      if (parts.length >= 2) {
        return (parts[0][0] + parts[1][0]).toUpperCase()
      }
      return name.substring(0, 2).toUpperCase()
    },

    getAssignedTo(ticket) {
      return ticket.assigned_to?.name || '—'
    },

    formatDate(date) {
      if (!date) return ''

      try {
        return new Date(date).toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        })
      } catch (error) {
        console.warn('Invalid date format:', date)
        return 'Invalid Date'
      }
    },

    getDepartmentName(category) {
      return this.categoryNames[category] || 'General'
    },

    truncateText(text, maxLength = 80) {
      if (!text || text.length <= maxLength) return text
      return text.substring(0, maxLength) + '...'
    }
  }
}
</script>
