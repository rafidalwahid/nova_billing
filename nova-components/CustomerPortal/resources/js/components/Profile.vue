<template>
  <div>
    <Heading class="mb-6">My Profile</Heading>
    
    <Card>
      <div class="p-6">
        <div class="text-center py-12">
          <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Profile Management</h3>
          <p class="text-gray-600 mb-6">Complete profile management system coming soon...</p>
          <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 max-w-md mx-auto">
            <p class="text-indigo-800 text-sm">This feature will include profile editing, password changes, and notification preferences.</p>
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  data() {
    return {
      profile: {},
      loading: false
    }
  },
  mounted() {
    this.loadProfile()
  },
  methods: {
    async loadProfile() {
      try {
        this.loading = true
        // TODO: Add API endpoint for profile
        // const response = await Nova.request().get('/nova-vendor/customer-portal/profile')
        // this.profile = response.data.profile
      } catch (error) {
        console.error('Error loading profile:', error)
        this.$toasted.error('Failed to load profile')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
