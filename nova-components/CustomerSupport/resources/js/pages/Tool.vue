<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <Head title="My Support" />

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Ticket List -->
      <TicketList
        :tickets="tickets"
        :loading="loading"
        :pagination="pagination"
        :totalTickets="totalTickets"
        @viewTicket="viewTicketDetails"
        @changePage="loadTickets"
        @createTicket="openWizard"
      />

      <!-- Loading State -->
      <LoadingSpinner
        v-if="loading && tickets.length === 0"
        message="Loading tickets..."
      />
    </div>

    <!-- Ticket Creation Wizard -->
    <TicketWizard
      :isOpen="showWizard"
      @close="closeWizard"
      @ticketCreated="onTicketCreated"
    />
  </div>
</template>

<script>
import TicketList from '../components/TicketList.vue'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import TicketWizard from '../components/TicketWizard.vue'

export default {
  name: 'CustomerSupportTool',

  components: {
    TicketList,
    LoadingSpinner,
    TicketWizard
  },

  data() {
    return {
      loading: false,
      tickets: [],
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0
      },
      totalTickets: 0,
      showWizard: false,
      searchQuery: '',
      statusFilter: '',
      departmentFilter: '',
      searchTimeout: null,
    }
  },

  computed: {
    openTicketsCount() {
      return this.tickets.filter(ticket => ticket.status === 'open' || ticket.status === 'in_progress').length
    }
  },

  mounted() {
    this.loadTickets()
  },

  methods: {
    async loadTickets(page = 1) {
      try {
        this.loading = true

        // Build query parameters
        const params = { page }

        if (this.searchQuery.trim()) {
          params.search = this.searchQuery.trim()
        }

        if (this.statusFilter) {
          params.status = this.statusFilter
        }

        if (this.departmentFilter) {
          params.department = this.departmentFilter
        }

        // Make API request using Nova.request
        const response = await Nova.request().get('/nova-vendor/customer-support/tickets', {
          params
        })

        this.tickets = response.data.data || []
        this.pagination = response.data.meta || {}
        this.totalTickets = response.data.meta?.total || 0

      } catch (error) {
        console.error('Error loading tickets:', error)

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
      // TODO: Implement ticket details modal or navigation
      console.log('View ticket details:', ticket)
    },

    openWizard() {
      this.showWizard = true
    },

    closeWizard() {
      this.showWizard = false
    },

    onTicketCreated(ticketData) {
      console.log('Ticket created:', ticketData)
      // Refresh the ticket list to show the new ticket
      this.loadTickets(1)
      // Show success message
      this.$toasted?.success('Support ticket created successfully!')
    },

    handleSearch() {
      // Clear existing timeout
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout)
      }

      // Debounce search to avoid too many API calls
      this.searchTimeout = setTimeout(() => {
        this.loadTickets(1) // Reset to first page when searching
      }, 500)
    },

    handleFilterChange() {
      // Immediately apply filter changes
      this.loadTickets(1) // Reset to first page when filtering
    },
  }
}
</script>
