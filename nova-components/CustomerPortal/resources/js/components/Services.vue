<template>
  <div>
    <Heading class="mb-6">My Services</Heading>
    
    <Card>
      <div class="p-6">
        <div class="text-center py-12">
          <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Service Management</h3>
          <p class="text-gray-600 mb-6">Complete service management system coming soon...</p>
          <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 max-w-md mx-auto">
            <p class="text-purple-800 text-sm">This feature will include service status, configuration options, and renewal management.</p>
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
export default {
  name: 'Services',
  data() {
    return {
      services: [],
      loading: false
    }
  },
  mounted() {
    this.loadServices()
  },
  methods: {
    async loadServices() {
      try {
        this.loading = true
        // TODO: Add API endpoint for services
        // const response = await Nova.request().get('/nova-vendor/customer-portal/services')
        // this.services = response.data.services
      } catch (error) {
        console.error('Error loading services:', error)
        this.$toasted.error('Failed to load services')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
