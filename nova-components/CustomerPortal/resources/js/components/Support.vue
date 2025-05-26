<template>
  <div>
    <Heading class="mb-6">Support Tickets</Heading>

    <Card>
      <div class="p-6">
        <div class="text-center py-12">
          <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Support System</h3>
          <p class="text-gray-600 mb-6">Complete support ticket system coming soon...</p>
          <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 max-w-md mx-auto">
            <p class="text-orange-800 text-sm">This feature will include ticket creation, tracking, and communication with support staff.</p>
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import { CustomerPortalAPI } from '../utils/helpers.js'

export default {
  name: 'Support',
  data() {
    return {
      tickets: [],
      loading: false
    }
  },
  mounted() {
    this.loadTickets()
  },
  methods: {
    async loadTickets() {
      try {
        this.loading = true
        const data = await CustomerPortalAPI.getTickets()
        this.tickets = data.tickets
      } catch (error) {
        console.error('Error loading tickets:', error)
        this.$toasted.error('Failed to load tickets')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
