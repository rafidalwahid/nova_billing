<template>
  <div>
    <Heading class="mb-6">My Invoices</Heading>

    <Card>
      <div class="p-6">
        <div class="text-center py-12">
          <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Invoice Management</h3>
          <p class="text-gray-600 mb-6">Complete invoice management system coming soon...</p>
          <div class="bg-green-50 border border-green-200 rounded-lg p-4 max-w-md mx-auto">
            <p class="text-green-800 text-sm">This feature will include invoice viewing, payment options, and download capabilities.</p>
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import { CustomerPortalAPI } from '../utils/helpers.js'

export default {
  name: 'Invoices',
  data() {
    return {
      invoices: [],
      loading: false
    }
  },
  mounted() {
    this.loadInvoices()
  },
  methods: {
    async loadInvoices() {
      try {
        this.loading = true
        const data = await CustomerPortalAPI.getInvoices()
        this.invoices = data.invoices
      } catch (error) {
        console.error('Error loading invoices:', error)
        this.$toasted.error('Failed to load invoices')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
