<template>
  <div>
    <Heading class="mb-6">Dashboard</Heading>

    <!-- Account Overview -->
    <Card class="mb-6">
      <div class="p-6">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-medium">
              {{ dashboardData.customer?.name }}
            </h3>
            <p class="text-sm text-80 mt-1">
              {{ dashboardData.customer?.company || 'Individual Customer' }}
            </p>
          </div>
          <div class="flex items-center space-x-6">
            <div class="text-right">
              <p class="text-xs text-80 uppercase tracking-wide">Status</p>
              <div class="mt-1">
                <Badge :type="statusBadgeType">
                  {{ dashboardData.customer?.status }}
                </Badge>
              </div>
            </div>
            <div class="text-right">
              <p class="text-xs text-80 uppercase tracking-wide">Member Since</p>
              <p class="text-sm font-medium mt-1">
                {{ dashboardData.customer?.member_since }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </Card>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <!-- Active Services Card -->
      <Card>
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-success-light rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-3xl font-bold">
                {{ dashboardData.stats?.active_subscriptions || 0 }}
              </p>
              <p class="text-sm text-80">Active Services</p>
            </div>
          </div>
        </div>
      </Card>

      <!-- Total Orders Card -->
      <Card>
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-primary-light rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-3xl font-bold">
                {{ dashboardData.stats?.total_orders || 0 }}
              </p>
              <p class="text-sm text-80">Total Orders</p>
            </div>
          </div>
        </div>
      </Card>

      <!-- Support Tickets Card -->
      <Card>
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-warning-light rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-3xl font-bold">
                {{ dashboardData.open_tickets || 0 }}
              </p>
              <p class="text-sm text-80">Open Tickets</p>
            </div>
          </div>
        </div>
      </Card>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Recent Orders -->
      <Card>
        <div class="px-6 py-4 border-b border-20">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Recent Orders</h3>
            <span class="text-sm text-80">Last 3 orders</span>
          </div>
        </div>
        <div class="p-6">
          <div v-if="dashboardData.recent_orders?.length" class="space-y-3">
            <div v-for="order in dashboardData.recent_orders.slice(0, 3)" :key="order.id"
                 class="flex items-center justify-between p-4 bg-20 rounded-lg hover:bg-30 transition-colors duration-150">
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-primary-light rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                  </div>
                </div>
                <div>
                  <p class="text-sm font-medium">
                    Order #{{ order.order_number }}
                  </p>
                  <p class="text-xs text-80">
                    {{ formatDate(order.created_at) }}
                  </p>
                </div>
              </div>
              <div class="text-right">
                <p class="text-sm font-semibold">
                  ${{ formatMoney(order.total) }}
                </p>
                <div class="mt-1">
                  <Badge :type="getOrderBadgeType(order.status)">
                    {{ order.status }}
                  </Badge>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-8">
            <div class="w-12 h-12 bg-20 rounded-lg flex items-center justify-center mx-auto mb-3">
              <svg class="w-6 h-6 text-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
              </svg>
            </div>
            <p class="text-sm text-80">No recent orders</p>
          </div>
        </div>
      </Card>

      <!-- Recent Invoices -->
      <Card>
        <div class="px-6 py-4 border-b border-20">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Recent Invoices</h3>
            <span class="text-sm text-80">Last 3 invoices</span>
          </div>
        </div>
        <div class="p-6">
          <div v-if="dashboardData.recent_invoices?.length" class="space-y-3">
            <div v-for="invoice in dashboardData.recent_invoices.slice(0, 3)" :key="invoice.id"
                 class="flex items-center justify-between p-4 bg-20 rounded-lg hover:bg-30 transition-colors duration-150">
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-success-light rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </div>
                </div>
                <div>
                  <p class="text-sm font-medium">
                    Invoice #{{ invoice.invoice_number }}
                  </p>
                  <p class="text-xs text-80">
                    {{ formatDate(invoice.created_at) }}
                  </p>
                </div>
              </div>
              <div class="text-right">
                <p class="text-sm font-semibold">
                  ${{ formatMoney(invoice.total) }}
                </p>
                <div class="mt-1">
                  <Badge :type="getInvoiceBadgeType(invoice.status)">
                    {{ invoice.status }}
                  </Badge>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-8">
            <div class="w-12 h-12 bg-20 rounded-lg flex items-center justify-center mx-auto mb-3">
              <svg class="w-6 h-6 text-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <p class="text-sm text-80">No recent invoices</p>
          </div>
        </div>
      </Card>
    </div>
  </div>
</template>

<script>
import {
  formatMoney,
  formatDate,
  getOrderStatusClass,
  getInvoiceStatusClass,
  getCustomerStatusClass
} from '../utils/helpers.js'

export default {
  name: 'Dashboard',
  props: {
    dashboardData: {
      type: Object,
      required: true
    }
  },
  computed: {
    statusBadgeType() {
      const status = this.dashboardData.customer?.status;
      switch(status) {
        case 'Active':
          return 'success';
        case 'Inactive':
          return 'danger';
        case 'Suspended':
          return 'warning';
        default:
          return 'info';
      }
    },
  },
  methods: {
    formatMoney,
    formatDate,
    getOrderStatusClass,
    getInvoiceStatusClass,

    getOrderBadgeType(status) {
      const badgeTypes = {
        'pending': 'warning',
        'processing': 'info',
        'completed': 'success',
        'active': 'success',
        'cancelled': 'danger',
        'shipped': 'info',
      }
      return badgeTypes[status] || 'info'
    },

    getInvoiceBadgeType(status) {
      const badgeTypes = {
        'draft': 'info',
        'sent': 'info',
        'paid': 'success',
        'overdue': 'danger',
        'cancelled': 'danger',
        'partial': 'warning',
      }
      return badgeTypes[status] || 'info'
    },
  }
}
</script>
