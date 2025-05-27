<template>
  <div>
    <Heading class="mb-6">My Services</Heading>

    <!-- Loading State -->
    <Card v-if="loading" class="py-12">
      <div class="flex justify-center items-center">
        <Loader class="text-60" />
        <span class="ml-3 text-80">Loading services...</span>
      </div>
    </Card>

    <!-- Empty State -->
    <Card v-else-if="!loading && !hasAnyServices">
      <div class="flex flex-col items-center justify-center py-16 px-6">
        <svg class="w-16 h-16 text-60 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
        </svg>
        <h3 class="text-xl font-semibold mb-2">No Services Found</h3>
        <p class="text-80 text-center mb-6 max-w-md">
          You don't have any active services yet.
        </p>
      </div>
    </Card>

    <!-- Services Overview -->
    <div v-else class="space-y-6">
      <!-- Service Stats -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Active Subscriptions -->
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
                  {{ services.subscriptions?.length || 0 }}
                </p>
                <p class="text-sm text-80">Active Subscriptions</p>
              </div>
            </div>
          </div>
        </Card>

        <!-- Hosting Accounts -->
        <Card>
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-primary-light rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-3xl font-bold">
                  {{ services.hosting_accounts?.length || 0 }}
                </p>
                <p class="text-sm text-80">Hosting Accounts</p>
              </div>
            </div>
          </div>
        </Card>

        <!-- Domain Registrations -->
        <Card>
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-warning-light rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-3xl font-bold">
                  {{ services.domain_registrations?.length || 0 }}
                </p>
                <p class="text-sm text-80">Domain Names</p>
              </div>
            </div>
          </div>
        </Card>
      </div>

      <!-- Active Subscriptions -->
      <Card v-if="services.subscriptions?.length">
        <div class="px-6 py-4 border-b border-20">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Active Subscriptions</h3>
            <span class="text-sm text-80">{{ services.subscriptions.length }} active</span>
          </div>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div
              v-for="subscription in services.subscriptions"
              :key="subscription.id"
              class="bg-20 rounded-lg p-4 hover:bg-30 transition-colors duration-150"
            >
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-success-light rounded-lg flex items-center justify-center">
                      <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                  </div>
                  <div>
                    <p class="text-sm font-medium">
                      {{ subscription.product?.name || 'Unknown Product' }}
                    </p>
                    <p class="text-xs text-80">
                      Next billing: {{ formatDate(subscription.next_billing_date) }}
                    </p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-semibold">
                    ${{ formatMoney(subscription.amount) }}
                  </p>
                  <div class="mt-1">
                    <Badge :type="getSubscriptionBadgeType(subscription.status)">
                      {{ formatStatus(subscription.status) }}
                    </Badge>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Card>

      <!-- Hosting Accounts -->
      <Card v-if="services.hosting_accounts?.length">
        <div class="px-6 py-4 border-b border-20">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Hosting Accounts</h3>
            <span class="text-sm text-80">{{ services.hosting_accounts.length }} accounts</span>
          </div>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div
              v-for="account in services.hosting_accounts"
              :key="account.id"
              class="bg-20 rounded-lg p-4 hover:bg-30 transition-colors duration-150"
            >
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-primary-light rounded-lg flex items-center justify-center">
                      <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                      </svg>
                    </div>
                  </div>
                  <div>
                    <p class="text-sm font-medium">
                      {{ account.domain || account.username }}
                    </p>
                    <p class="text-xs text-80">
                      Server: {{ account.server?.name || 'Unknown' }}
                    </p>
                  </div>
                </div>
                <div class="text-right">
                  <div class="mt-1">
                    <Badge :type="getHostingBadgeType(account.status)">
                      {{ formatStatus(account.status) }}
                    </Badge>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Card>

      <!-- Domain Registrations -->
      <Card v-if="services.domain_registrations?.length">
        <div class="px-6 py-4 border-b border-20">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Domain Names</h3>
            <span class="text-sm text-80">{{ services.domain_registrations.length }} domains</span>
          </div>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div
              v-for="domain in services.domain_registrations"
              :key="domain.id"
              class="bg-20 rounded-lg p-4 hover:bg-30 transition-colors duration-150"
            >
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-warning-light rounded-lg flex items-center justify-center">
                      <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                      </svg>
                    </div>
                  </div>
                  <div>
                    <p class="text-sm font-medium">
                      {{ domain.domain_name }}
                    </p>
                    <p class="text-xs text-80">
                      Expires: {{ formatDate(domain.expiry_date) }}
                    </p>
                  </div>
                </div>
                <div class="text-right">
                  <div class="mt-1">
                    <Badge :type="getDomainBadgeType(domain.status)">
                      {{ formatStatus(domain.status) }}
                    </Badge>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Card>
    </div>
  </div>
</template>

<script>
import { CustomerPortalAPI } from '../utils/helpers.js'
import {
  formatMoney,
  formatDate,
  formatTime
} from '../utils/helpers.js'

export default {
  name: 'Services',
  data() {
    return {
      services: {
        subscriptions: [],
        hosting_accounts: [],
        domain_registrations: []
      },
      loading: false
    }
  },

  computed: {
    hasAnyServices() {
      return (
        (this.services.subscriptions?.length > 0) ||
        (this.services.hosting_accounts?.length > 0) ||
        (this.services.domain_registrations?.length > 0)
      )
    }
  },

  mounted() {
    this.loadServices()
  },

  methods: {
    formatMoney,
    formatDate,
    formatTime,

    async loadServices() {
      try {
        this.loading = true
        const response = await CustomerPortalAPI.getServices()
        this.services = response.data || {
          subscriptions: [],
          hosting_accounts: [],
          domain_registrations: []
        }
      } catch (error) {
        console.error('Error loading services:', error)
        console.error('Error details:', error.response?.data || error.message)

        // Show user-friendly error message
        if (error.response?.status === 401) {
          this.$toasted?.error('Authentication required. Please log in again.')
        } else if (error.response?.status === 403) {
          this.$toasted?.error('Access denied. You do not have permission to view services.')
        } else {
          this.$toasted?.error('Failed to load services. Please try again.')
        }

        // Reset data on error
        this.services = {
          subscriptions: [],
          hosting_accounts: [],
          domain_registrations: []
        }
      } finally {
        this.loading = false
      }
    },

    getSubscriptionBadgeType(status) {
      const badgeTypes = {
        'active': 'success',
        'pending': 'warning',
        'suspended': 'danger',
        'cancelled': 'danger',
        'expired': 'danger',
      }
      return badgeTypes[status] || 'info'
    },

    getHostingBadgeType(status) {
      const badgeTypes = {
        'active': 'success',
        'pending': 'warning',
        'suspended': 'danger',
        'terminated': 'danger',
      }
      return badgeTypes[status] || 'info'
    },

    getDomainBadgeType(status) {
      const badgeTypes = {
        'active': 'success',
        'pending': 'warning',
        'expired': 'danger',
        'cancelled': 'danger',
        'transferred': 'info',
      }
      return badgeTypes[status] || 'info'
    },

    formatStatus(status) {
      if (!status) return 'Unknown'
      return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ')
    },
  }
}
</script>
