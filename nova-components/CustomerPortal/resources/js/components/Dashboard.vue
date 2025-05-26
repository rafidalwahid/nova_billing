<template>
  <div>
    <Heading class="mb-6">Customer Dashboard</Heading>

    <!-- Customer Info Card -->
    <Card class="mb-6">
      <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white rounded-lg">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ dashboardData.customer?.name }}!</h2>
            <p class="text-blue-100">{{ dashboardData.customer?.company || 'Individual Customer' }}</p>
            <p class="text-sm text-blue-200 mt-1">Member since {{ dashboardData.customer?.member_since }}</p>
          </div>
          <div class="text-right">
            <Badge :type="statusBadgeType" class="shadow-lg">
              {{ dashboardData.customer?.status }}
            </Badge>
          </div>
        </div>
      </div>
    </Card>

    <!-- Essential Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <!-- Active Subscriptions Card -->
      <Card>
        <div class="p-6 flex items-center">
          <Icon type="check-circle" class="w-8 h-8 text-green-500 mr-4" />
          <div>
            <Heading :level="2" class="text-2xl font-semibold">{{ dashboardData.stats?.active_subscriptions || 0 }}</Heading>
            <p class="text-gray-600">Active Services</p>
          </div>
        </div>
      </Card>

      <!-- Total Orders Card -->
      <Card>
        <div class="p-6 flex items-center">
          <Icon type="shopping-bag" class="w-8 h-8 text-blue-500 mr-4" />
          <div>
            <Heading :level="2" class="text-2xl font-semibold">{{ dashboardData.stats?.total_orders || 0 }}</Heading>
            <p class="text-gray-600">Total Orders</p>
          </div>
        </div>
      </Card>

      <!-- Open Tickets Card -->
      <Card>
        <div class="p-6 flex items-center">
          <Icon type="support" class="w-8 h-8 text-orange-500 mr-4" />
          <div>
            <Heading :level="2" class="text-2xl font-semibold">{{ dashboardData.open_tickets || 0 }}</Heading>
            <p class="text-gray-600">Open Tickets</p>
          </div>
        </div>
      </Card>
    </div>

    <!-- Recent Activity -->
    <Card>
      <div class="p-6 border-b">
        <Heading :level="3">Recent Activity</Heading>
      </div>
      <div class="p-6">
        <!-- Recent Orders -->
        <div v-if="dashboardData.recent_orders?.length" class="mb-6">
          <Heading :level="4" class="mb-3">Recent Orders</Heading>
          <div class="space-y-3">
            <div v-for="order in dashboardData.recent_orders.slice(0, 3)" :key="order.id"
                 class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
              <div>
                <p class="font-medium">Order #{{ order.order_number }}</p>
                <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
              </div>
              <div class="text-right">
                <p class="font-medium">${{ formatMoney(order.total) }}</p>
                <Badge :type="getOrderBadgeType(order.status)">
                  {{ order.status }}
                </Badge>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Invoices -->
        <div v-if="dashboardData.recent_invoices?.length">
          <Heading :level="4" class="mb-3">Recent Invoices</Heading>
          <div class="space-y-3">
            <div v-for="invoice in dashboardData.recent_invoices.slice(0, 3)" :key="invoice.id"
                 class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
              <div>
                <p class="font-medium">Invoice #{{ invoice.invoice_number }}</p>
                <p class="text-sm text-gray-600">{{ formatDate(invoice.created_at) }}</p>
              </div>
              <div class="text-right">
                <p class="font-medium">${{ formatMoney(invoice.total) }}</p>
                <Badge :type="getInvoiceBadgeType(invoice.status)">
                  {{ invoice.status }}
                </Badge>
              </div>
            </div>
          </div>
        </div>

        <!-- No Activity Message -->
        <div v-if="!dashboardData.recent_orders?.length && !dashboardData.recent_invoices?.length"
             class="text-center py-8">
          <Icon type="document" class="w-12 h-12 text-gray-300 mx-auto mb-4" />
          <p class="text-gray-500">No recent activity</p>
        </div>
      </div>
    </Card>
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
