<template>
  <div>
    <Head title="My Support" />

    <!-- Error Boundary -->
    <ErrorBoundary v-if="hasError" :error="error" @retry="retryOperation" />

    <!-- Main Content Area -->
    <div v-else class="p-6 space-y-6">
      <!-- Filters -->
      <div class="transform transition-all duration-300 hover:scale-[1.01]">
        <TicketFilters
          v-model:searchQuery="filters.search"
          v-model:statusFilter="filters.status"
          v-model:departmentFilter="filters.department"
          :totalTickets="totalTickets"
          :loading="loading"
          @createTicket="openWizard"
          @search="handleSearch"
          @filterChange="handleFilterChange"
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
    </div>

    <!-- Modals -->
    <TicketWizard
      :isOpen="showWizard"
      @close="closeWizard"
      @ticketCreated="onTicketCreated"
    />

    <TicketDetailsModal
      :isOpen="showTicketDetails"
      :ticket="selectedTicket"
      @close="closeTicketDetails"
      @addResponse="onResponseAdded"
    />
  </div>
</template>

<script>
import { ref, reactive, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import { useDebounce } from '@/composables/useDebounce'
import apiService from '../services/api.js'
import TicketFilters from '../components/TicketFilters.vue'
import TicketList from '../components/TicketList.vue'
import TicketWizard from '../components/TicketWizard.vue'
import TicketDetailsModal from '../components/TicketDetailsModal.vue'
import ErrorBoundary from '../components/ErrorBoundary.vue'

export default {
  name: 'CustomerSupportTool',

  components: {
    Head,
    TicketFilters,
    TicketList,
    TicketWizard,
    TicketDetailsModal,
    ErrorBoundary
  },

  setup() {
    // State
    const loading = ref(false)
    const hasError = ref(false)
    const error = ref(null)
    const tickets = ref([])
    const totalTickets = ref(0)
    const showWizard = ref(false)
    const showTicketDetails = ref(false)
    const selectedTicket = ref(null)

    // Pagination
    const pagination = reactive({
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0
    })

    // Filters
    const filters = reactive({
      search: '',
      status: '',
      department: ''
    })

    // Debounced search
    const debouncedSearch = useDebounce(() => {
      loadTickets(1)
    }, 500)

    return {
      loading,
      hasError,
      error,
      tickets,
      totalTickets,
      showWizard,
      showTicketDetails,
      selectedTicket,
      pagination,
      filters,
      debouncedSearch
    }
  },

  mounted() {
    this.loadTickets()
  },

  methods: {
    async loadTickets(page = 1) {
      try {
        this.loading = true
        this.hasError = false

        const response = await apiService.getTickets(this.filters, page)

        this.tickets = response.data || []
        this.pagination = response.meta || {}
        this.totalTickets = response.meta?.total || 0

      } catch (error) {
        this.handleError(error, 'Failed to load tickets')
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

    async onResponseAdded() {
      try {
        await this.loadTickets(this.pagination.current_page)
        apiService.showSuccess('Response added successfully!')
      } catch (error) {
        this.handleError(error, 'Failed to refresh tickets')
      }
    },

    openWizard() {
      this.showWizard = true
    },

    closeWizard() {
      this.showWizard = false
    },

    async onTicketCreated() {
      try {
        await this.loadTickets(1)
        apiService.showSuccess('Support ticket created successfully!')
      } catch (error) {
        this.handleError(error, 'Failed to refresh tickets')
      }
    },

    handleSearch() {
      this.debouncedSearch()
    },

    handleFilterChange() {
      this.loadTickets(1)
    },

    handleError(error, defaultMessage) {
      console.error('CustomerSupport Error:', error)

      this.hasError = true
      this.error = {
        message: error.response?.data?.message || defaultMessage,
        details: error.message,
        canRetry: true
      }

      // Show toast notification
      const errorMessage = apiService.formatError(error).message
      apiService.showError(errorMessage)
    },

    retryOperation() {
      this.hasError = false
      this.error = null
      this.loadTickets(this.pagination.current_page)
    }
  }
}
</script>
