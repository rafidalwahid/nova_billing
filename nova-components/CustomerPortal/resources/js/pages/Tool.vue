<template>
  <div class="customer-portal">
    <Head title="Customer Portal" />

    <!-- Dashboard View -->
    <Dashboard
      v-if="currentView === 'dashboard'"
      :dashboard-data="dashboardData"
    />

    <!-- Orders View -->
    <Orders v-else-if="currentView === 'orders'" />

    <!-- Invoices View -->
    <Invoices v-else-if="currentView === 'invoices'" />

    <!-- Services View -->
    <Services v-else-if="currentView === 'services'" />

    <!-- Support Tickets View -->
    <Support v-else-if="currentView === 'tickets'" />

    <!-- Profile View -->
    <Profile v-else-if="currentView === 'profile'" />

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-12">
      <svg class="animate-spin h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    </div>
  </div>
</template>

<script>
// Import components
import Dashboard from '../components/Dashboard.vue'
import Orders from '../components/Orders.vue'
import Invoices from '../components/Invoices.vue'
import Services from '../components/Services.vue'
import Support from '../components/Support.vue'
import Profile from '../components/Profile.vue'

// Import utilities
import { CustomerPortalAPI } from '../utils/helpers.js'

export default {
  name: 'CustomerPortalTool',

  components: {
    Dashboard,
    Orders,
    Invoices,
    Services,
    Support,
    Profile,
  },

  data() {
    return {
      loading: true,
      currentView: 'dashboard',
      dashboardData: {
        customer: null,
        stats: null,
        recent_orders: [],
        recent_invoices: [],
        open_tickets: 0,
      },
    }
  },

  mounted() {
    this.loadDashboardData()
    this.setupRouteWatcher()
  },

  methods: {
    async loadDashboardData() {
      try {
        this.loading = true
        this.dashboardData = await CustomerPortalAPI.getDashboardData()
      } catch (error) {
        console.error('Error loading dashboard data:', error)
        this.$toasted.error('Failed to load dashboard data')
      } finally {
        this.loading = false
      }
    },

    setupRouteWatcher() {
      // Watch for route changes to switch views
      const path = this.$route.path
      if (path.includes('/orders')) {
        this.currentView = 'orders'
      } else if (path.includes('/invoices')) {
        this.currentView = 'invoices'
      } else if (path.includes('/services')) {
        this.currentView = 'services'
      } else if (path.includes('/tickets')) {
        this.currentView = 'tickets'
      } else if (path.includes('/profile')) {
        this.currentView = 'profile'
      } else {
        this.currentView = 'dashboard'
      }
    },
  },

  watch: {
    '$route'() {
      this.setupRouteWatcher()
    }
  }
}
</script>

<style scoped>
/* Minimal custom styles for the customer portal */
</style>
