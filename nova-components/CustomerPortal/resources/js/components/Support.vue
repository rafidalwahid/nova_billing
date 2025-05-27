<template>
  <div>
    <Heading class="mb-6">Support Tickets</Heading>

    <!-- Action Bar -->
    <Card class="mb-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6">
        <div class="flex flex-col sm:flex-row gap-4">
          <!-- Search Input -->
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search tickets..."
              class="form-control form-input form-input-bordered w-full sm:w-64"
              @input="debouncedSearch"
            />
          </div>

          <!-- Status Filter -->
          <select
            v-model="statusFilter"
            @change="loadTickets(1)"
            class="form-control form-select form-select-bordered w-full sm:w-48"
          >
            <option value="">All Statuses</option>
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="waiting_customer">Waiting for Customer</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
          </select>

          <!-- Priority Filter -->
          <select
            v-model="priorityFilter"
            @change="loadTickets(1)"
            class="form-control form-select form-select-bordered w-full sm:w-48"
          >
            <option value="">All Priorities</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
            <option value="urgent">Urgent</option>
          </select>
        </div>

        <div class="flex items-center gap-4">
          <div class="text-sm text-80">
            {{ totalTickets }} {{ totalTickets === 1 ? 'ticket' : 'tickets' }} total
          </div>
          <DefaultButton
            @click="showCreateTicketModal = true"
            variant="primary"
            size="sm"
          >
            Create Ticket
          </DefaultButton>
        </div>
      </div>
    </Card>

    <!-- Loading State -->
    <Card v-if="loading && tickets.length === 0" class="py-12">
      <div class="flex justify-center items-center">
        <Loader class="text-60" />
        <span class="ml-3 text-80">Loading tickets...</span>
      </div>
    </Card>

    <!-- Empty State -->
    <Card v-else-if="!loading && tickets.length === 0">
      <div class="flex flex-col items-center justify-center py-16 px-6">
        <svg class="w-16 h-16 text-60 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <h3 class="text-xl font-semibold mb-2">No Support Tickets Found</h3>
        <p class="text-80 text-center mb-6 max-w-md">
          {{ searchQuery || statusFilter || priorityFilter ? 'No tickets match your current filters.' : 'You don\'t have any support tickets yet.' }}
        </p>
        <div class="flex gap-3">
          <DefaultButton
            v-if="searchQuery || statusFilter || priorityFilter"
            @click="clearFilters"
            type="button"
          >
            Clear Filters
          </DefaultButton>
          <DefaultButton
            v-if="!searchQuery && !statusFilter && !priorityFilter"
            @click="showCreateTicketModal = true"
            variant="primary"
          >
            Create Your First Ticket
          </DefaultButton>
        </div>
      </div>
    </Card>

    <!-- Tickets Table -->
    <Card v-else class="overflow-hidden">
      <!-- Table Header -->
      <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-b border-20">
        <div class="grid grid-cols-7 gap-4 text-sm font-medium text-80">
          <div class="col-span-2">Ticket</div>
          <div>Subject</div>
          <div>Status</div>
          <div>Priority</div>
          <div>Last Updated</div>
          <div class="text-right">Actions</div>
        </div>
      </div>

      <!-- Table Body -->
      <div class="divide-y divide-20">
        <div
          v-for="ticket in tickets"
          :key="ticket.id"
          class="px-6 py-4 hover:bg-20 transition-colors duration-150"
        >
          <div class="grid grid-cols-7 gap-4 items-center">
            <div class="col-span-2">
              <div class="text-sm font-medium">
                #{{ ticket.ticket_number }}
              </div>
              <div class="text-xs text-80">
                {{ formatDate(ticket.created_at) }}
              </div>
            </div>
            <div>
              <div class="text-sm font-medium">
                {{ ticket.subject }}
              </div>
              <div class="text-xs text-80">
                {{ ticket.department?.name || 'General' }}
              </div>
            </div>
            <div>
              <Badge :type="getTicketStatusBadgeType(ticket.status)">
                {{ formatStatus(ticket.status) }}
              </Badge>
            </div>
            <div>
              <Badge :type="getTicketPriorityBadgeType(ticket.priority)">
                {{ formatStatus(ticket.priority) }}
              </Badge>
            </div>
            <div>
              <div class="text-sm text-80">
                {{ formatDate(ticket.last_response_at || ticket.updated_at) }}
              </div>
            </div>
            <div class="text-right">
              <DefaultButton
                @click="viewTicketDetails(ticket)"
                size="sm"
                variant="ghost"
              >
                View
              </DefaultButton>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 border-t border-20">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div class="text-sm text-80">
            Showing {{ ((pagination.current_page - 1) * pagination.per_page) + 1 }} to
            {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} of
            {{ pagination.total }} results
          </div>
          <div class="flex items-center space-x-2">
            <DefaultButton
              @click="loadTickets(pagination.current_page - 1)"
              :disabled="pagination.current_page <= 1"
              size="sm"
              variant="ghost"
            >
              Previous
            </DefaultButton>
            <span class="px-3 py-1 text-sm text-80">
              Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </span>
            <DefaultButton
              @click="loadTickets(pagination.current_page + 1)"
              :disabled="pagination.current_page >= pagination.last_page"
              size="sm"
              variant="ghost"
            >
              Next
            </DefaultButton>
          </div>
        </div>
      </div>

      <!-- Loading overlay for pagination -->
      <div v-if="loading && tickets.length > 0" class="absolute inset-0 bg-white dark:bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="flex items-center">
          <Loader class="text-60" />
          <span class="ml-3 text-80">Loading...</span>
        </div>
      </div>
    </Card>

<script>
import { CustomerPortalAPI } from '../utils/helpers.js'
import {
  formatMoney,
  formatDate,
  formatTime
} from '../utils/helpers.js'

export default {
  name: 'Support',
  data() {
    return {
      tickets: [],
      loading: false,
      searchQuery: '',
      statusFilter: '',
      priorityFilter: '',
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0
      },
      totalTickets: 0,
      searchTimeout: null,

      // Modal states
      showCreateTicketModal: false,
      showTicketModal: false,
      selectedTicket: null,
    }
  },

  computed: {
    debouncedSearch() {
      return () => {
        clearTimeout(this.searchTimeout)
        this.searchTimeout = setTimeout(() => {
          this.loadTickets(1)
        }, 500)
      }
    }
  },

  mounted() {
    this.loadTickets()
  },

  methods: {
    formatMoney,
    formatDate,
    formatTime,

    async loadTickets(page = 1) {
      try {
        this.loading = true

        // Build filters object
        const filters = {}

        if (this.searchQuery.trim()) {
          filters.search = this.searchQuery.trim()
        }

        if (this.statusFilter) {
          filters.status = this.statusFilter
        }

        if (this.priorityFilter) {
          filters.priority = this.priorityFilter
        }

        const response = await CustomerPortalAPI.getTickets(page, filters)

        this.tickets = response.data || []
        this.pagination = response.meta || {}
        this.totalTickets = response.meta?.total || 0

      } catch (error) {
        console.error('Error loading tickets:', error)
        console.error('Error details:', error.response?.data || error.message)

        // Show user-friendly error message
        if (error.response?.status === 401) {
          this.$toasted?.error('Authentication required. Please log in again.')
        } else if (error.response?.status === 403) {
          this.$toasted?.error('Access denied. You do not have permission to view tickets.')
        } else {
          this.$toasted?.error('Failed to load tickets. Please try again.')
        }

        // Reset data on error
        this.tickets = []
        this.pagination = { current_page: 1, last_page: 1, per_page: 10, total: 0 }
        this.totalTickets = 0
      } finally {
        this.loading = false
      }
    },

    async viewTicketDetails(ticket) {
      this.selectedTicket = ticket
      this.showTicketModal = true

      // Load full ticket details if needed
      try {
        const response = await CustomerPortalAPI.getTicket(ticket.id)
        this.selectedTicket = response.data || ticket
      } catch (error) {
        console.error('Error loading ticket details:', error)
        this.$toasted?.error('Failed to load ticket details')
      }
    },

    clearFilters() {
      this.searchQuery = ''
      this.statusFilter = ''
      this.priorityFilter = ''
      this.loadTickets(1)
    },

    getTicketStatusBadgeType(status) {
      const badgeTypes = {
        'open': 'info',
        'in_progress': 'warning',
        'waiting_customer': 'warning',
        'resolved': 'success',
        'closed': 'success',
      }
      return badgeTypes[status] || 'info'
    },

    getTicketPriorityBadgeType(priority) {
      const badgeTypes = {
        'low': 'info',
        'medium': 'warning',
        'high': 'danger',
        'urgent': 'danger',
      }
      return badgeTypes[priority] || 'info'
    },

    formatStatus(status) {
      if (!status) return 'Unknown'
      return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ')
    },
  }
}
</script>
