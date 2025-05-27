<template>
  <div>
    <Head title="My Support" />

    <Heading class="mb-6">My Support</Heading>

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
    }
  },



  mounted() {
    this.loadTickets()
  },

  methods: {
    async loadTickets(page = 1) {
      try {
        this.loading = true

        // Make API request using Nova.request
        const response = await Nova.request().get('/nova-vendor/customer-support/tickets', {
          params: {
            page
          }
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
  }
}
</script>
