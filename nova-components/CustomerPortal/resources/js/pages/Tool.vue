<template>
  <div>
    <Head title="Customer Portal" />

    <!-- Dashboard View -->
    <div v-if="currentView === 'dashboard'">
      <Heading class="mb-6">Customer Dashboard</Heading>

      <!-- Customer Info Card -->
      <Card class="mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-xl font-semibold mb-2">Welcome back, {{ dashboardData.customer?.name }}!</h2>
            <p class="text-gray-600">{{ dashboardData.customer?.company || 'Individual Customer' }}</p>
            <p class="text-sm text-gray-500">Member since {{ dashboardData.customer?.member_since }}</p>
          </div>
          <div class="text-right">
            <span :class="statusClass" class="px-3 py-1 rounded-full text-sm font-medium">
              {{ dashboardData.customer?.status }}
            </span>
          </div>
        </div>
      </Card>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <Card class="p-6">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
              </svg>
            </div>
            <div>
              <p class="text-2xl font-semibold">{{ dashboardData.stats?.total_orders || 0 }}</p>
              <p class="text-gray-600">Total Orders</p>
            </div>
          </div>
        </Card>

        <Card class="p-6">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div>
              <p class="text-2xl font-semibold">{{ dashboardData.stats?.active_subscriptions || 0 }}</p>
              <p class="text-gray-600">Active Services</p>
            </div>
          </div>
        </Card>

        <Card class="p-6">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div>
              <p class="text-2xl font-semibold">${{ formatMoney(dashboardData.stats?.total_spent) }}</p>
              <p class="text-gray-600">Total Spent</p>
            </div>
          </div>
        </Card>

        <Card class="p-6">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div>
              <p class="text-2xl font-semibold">${{ formatMoney(dashboardData.stats?.outstanding_balance) }}</p>
              <p class="text-gray-600">Outstanding</p>
            </div>
          </div>
        </Card>
      </div>

      <!-- Recent Activity -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <Card>
          <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Recent Orders</h3>
          </div>
          <div class="p-6">
            <div v-if="dashboardData.recent_orders?.length" class="space-y-4">
              <div v-for="order in dashboardData.recent_orders" :key="order.id" class="flex justify-between items-center">
                <div>
                  <p class="font-medium">Order #{{ order.order_number }}</p>
                  <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
                </div>
                <div class="text-right">
                  <p class="font-medium">${{ formatMoney(order.total) }}</p>
                  <span :class="getOrderStatusClass(order.status)" class="text-xs px-2 py-1 rounded">
                    {{ order.status }}
                  </span>
                </div>
              </div>
            </div>
            <p v-else class="text-gray-500 text-center py-4">No orders yet</p>
          </div>
        </Card>

        <!-- Recent Invoices -->
        <Card>
          <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Recent Invoices</h3>
          </div>
          <div class="p-6">
            <div v-if="dashboardData.recent_invoices?.length" class="space-y-4">
              <div v-for="invoice in dashboardData.recent_invoices" :key="invoice.id" class="flex justify-between items-center">
                <div>
                  <p class="font-medium">Invoice #{{ invoice.invoice_number }}</p>
                  <p class="text-sm text-gray-600">{{ formatDate(invoice.created_at) }}</p>
                </div>
                <div class="text-right">
                  <p class="font-medium">${{ formatMoney(invoice.total) }}</p>
                  <span :class="getInvoiceStatusClass(invoice.status)" class="text-xs px-2 py-1 rounded">
                    {{ invoice.status }}
                  </span>
                </div>
              </div>
            </div>
            <p v-else class="text-gray-500 text-center py-4">No invoices yet</p>
          </div>
        </Card>
      </div>
    </div>

    <!-- Orders View -->
    <div v-else-if="currentView === 'orders'">
      <Heading class="mb-6">My Orders</Heading>
      <Card>
        <div class="p-6">
          <p class="text-gray-600">Orders management coming soon...</p>
        </div>
      </Card>
    </div>

    <!-- Invoices View -->
    <div v-else-if="currentView === 'invoices'">
      <Heading class="mb-6">My Invoices</Heading>
      <Card>
        <div class="p-6">
          <p class="text-gray-600">Invoice management coming soon...</p>
        </div>
      </Card>
    </div>

    <!-- Tickets View -->
    <div v-else-if="currentView === 'tickets'">
      <Heading class="mb-6">Support Tickets</Heading>
      <Card>
        <div class="p-6">
          <p class="text-gray-600">Support ticket system coming soon...</p>
        </div>
      </Card>
    </div>

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
export default {
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

  computed: {
    statusClass() {
      return this.dashboardData.customer?.status === 'Active'
        ? 'bg-green-100 text-green-800'
        : 'bg-red-100 text-red-800'
    },
  },

  methods: {
    async loadDashboardData() {
      try {
        this.loading = true
        const response = await Nova.request().get('/nova-vendor/customer-portal/dashboard')
        this.dashboardData = response.data
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
      if (path.includes('/dashboard')) {
        this.currentView = 'dashboard'
      } else if (path.includes('/orders')) {
        this.currentView = 'orders'
      } else if (path.includes('/invoices')) {
        this.currentView = 'invoices'
      } else if (path.includes('/tickets')) {
        this.currentView = 'tickets'
      } else {
        this.currentView = 'dashboard'
      }
    },

    formatMoney(amount) {
      if (!amount) return '0.00'
      return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
    },

    formatDate(date) {
      if (!date) return ''
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    },

    getOrderStatusClass(status) {
      const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'processing': 'bg-blue-100 text-blue-800',
        'completed': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },

    getInvoiceStatusClass(status) {
      const classes = {
        'draft': 'bg-gray-100 text-gray-800',
        'sent': 'bg-blue-100 text-blue-800',
        'paid': 'bg-green-100 text-green-800',
        'overdue': 'bg-red-100 text-red-800',
        'cancelled': 'bg-red-100 text-red-800',
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },
  },

  watch: {
    '$route'() {
      this.setupRouteWatcher()
    }
  }
}
</script>

<style>
/* Scoped Styles */
</style>
