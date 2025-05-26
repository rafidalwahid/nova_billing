<template>
  <div>
    <Heading class="mb-6">My Orders</Heading>

    <Card>
      <div class="p-6">
        <div class="text-center py-12">
          <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Orders Management</h3>
          <p class="text-gray-600 mb-6">Complete order management system coming soon...</p>
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-md mx-auto">
            <p class="text-blue-800 text-sm">This feature will include order tracking, history, and detailed order information.</p>
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import { CustomerPortalAPI } from '../utils/helpers.js'

export default {
  name: 'Orders',
  data() {
    return {
      orders: [],
      loading: false
    }
  },
  mounted() {
    this.loadOrders()
  },
  methods: {
    async loadOrders() {
      try {
        this.loading = true
        const data = await CustomerPortalAPI.getOrders()
        this.orders = data.orders
      } catch (error) {
        console.error('Error loading orders:', error)
        this.$toasted.error('Failed to load orders')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
