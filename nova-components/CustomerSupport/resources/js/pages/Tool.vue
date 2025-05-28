<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-all duration-500">
    <Head title="My Support" />

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-4 sm:space-y-6 lg:space-y-8">
      <!-- Filters -->
      <div class="transform transition-all duration-300 hover:scale-[1.01]">
        <TicketFilters
          v-model:searchQuery="searchQuery"
          v-model:statusFilter="statusFilter"
          v-model:departmentFilter="departmentFilter"
          :totalTickets="totalTickets"
          @createTicket="openWizard"
          @update:searchQuery="handleSearch"
          @update:statusFilter="handleFilterChange"
          @update:departmentFilter="handleFilterChange"
        />
      </div>

      <!-- Ticket List -->
      <div class="transform transition-all duration-300 hover:scale-[1.005]">
        <TicketList
          :tickets="tickets"
          :loading="loading"
          :pagination="pagination"
          :totalTickets="totalTickets"
          @viewTicket="viewTicketDetails"
          @changePage="loadTickets"
          @createTicket="openWizard"
        />
      </div>

      <!-- Loading State -->
      <div v-if="loading && tickets.length === 0" class="transform transition-all duration-300">
        <LoadingSpinner
          message="Loading your support tickets"
        />
      </div>
    </div>

    <!-- Ticket Creation Wizard -->
    <TicketWizard
      :isOpen="showWizard"
      @close="closeWizard"
      @ticketCreated="onTicketCreated"
    />

    <!-- Ticket Details Modal -->
    <TicketDetailsModal
      :isOpen="showTicketDetails"
      :ticket="selectedTicket"
      @close="closeTicketDetails"
      @addResponse="onResponseAdded"
    />
  </div>
</template>

<script>
import { ref, reactive } from 'vue'
import TicketFilters from '../components/TicketFilters.vue'
import TicketList from '../components/TicketList.vue'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import TicketWizard from '../components/TicketWizard.vue'
import TicketDetailsModal from '../components/TicketDetailsModal.vue'

export default {
  name: 'CustomerSupportTool',

  components: {
    TicketFilters,
    TicketList,
    LoadingSpinner,
    TicketWizard,
    TicketDetailsModal
  },

  setup() {
    // Reactive state
    const loading = ref(false)
    const tickets = ref([])
    const pagination = reactive({
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0
    })
    const totalTickets = ref(0)
    const showWizard = ref(false)
    const showTicketDetails = ref(false)
    const selectedTicket = ref(null)
    const searchQuery = ref('')
    const statusFilter = ref('')
    const departmentFilter = ref('')
    const searchTimeout = ref(null)

    return {
      loading,
      tickets,
      pagination,
      totalTickets,
      showWizard,
      showTicketDetails,
      selectedTicket,
      searchQuery,
      statusFilter,
      departmentFilter,
      searchTimeout
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
      this.selectedTicket = ticket
      this.showTicketDetails = true
    },

    closeTicketDetails() {
      this.showTicketDetails = false
      this.selectedTicket = null
    },

    onResponseAdded() {
      // Refresh the ticket list to show updated status
      this.loadTickets(this.pagination.current_page)

      if (this.$toasted) {
        this.$toasted.success('Response added successfully!', {
          duration: 3000,
          position: 'top-right'
        })
      }
    },

    openWizard() {
      this.showWizard = true
    },

    closeWizard() {
      this.showWizard = false
    },

    onTicketCreated() {
      this.loadTickets(1)

      if (this.$toasted) {
        this.$toasted.success('Support ticket created successfully!', {
          duration: 5000,
          position: 'top-right'
        })
      }
    },

    handleSearch() {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout)
      }

      this.searchTimeout = setTimeout(() => {
        this.loadTickets(1)
      }, 500)
    },

    handleFilterChange() {
      this.loadTickets(1)
    },

    clearSearchTimeout() {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout)
        this.searchTimeout = null
      }
    }
  }
}
</script>
