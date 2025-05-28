// API Service for Customer Support
import { ref } from 'vue'

class CustomerSupportApiService {
  constructor() {
    this.baseUrl = '/nova-vendor/customer-support'
    this.loading = ref(false)
    this.error = ref(null)
  }

  async request(method, endpoint, data = null) {
    this.loading.value = true
    this.error.value = null

    try {
      const config = {
        method,
        url: `${this.baseUrl}${endpoint}`,
      }

      if (data) {
        if (method === 'GET') {
          config.params = data
        } else {
          config.data = data
        }
      }

      const response = await Nova.request(config)
      return response.data
    } catch (error) {
      this.error.value = this.formatError(error)
      throw error
    } finally {
      this.loading.value = false
    }
  }
  // Ticket operations
  async getTickets(filters = {}, page = 1) {
    return this.request('GET', '/tickets', { ...filters, page })
  }

  async getTicket(ticketId) {
    return this.request('GET', `/tickets/${ticketId}`)
  }

  async createTicket(ticketData) {
    return this.request('POST', '/tickets', ticketData)
  }

  async getTicketResponses(ticketId) {
    return this.request('GET', `/tickets/${ticketId}/responses`)
  }

  async addTicketResponse(ticketId, message) {
    return this.request('POST', `/tickets/${ticketId}/responses`, { message })
  }

  // Error handling
  formatError(error) {
    const status = error.response?.status
    const data = error.response?.data

    switch (status) {
      case 401:
        return { type: 'auth', message: 'Authentication required. Please log in again.' }
      case 403:
        return { type: 'permission', message: 'Access denied. You do not have permission to perform this action.' }
      case 422:
        const errors = data?.errors || {}
        const errorMessages = Object.values(errors).flat().join('\n')
        return { type: 'validation', message: errorMessages || 'Please check your input.' }
      case 429:
        return { type: 'throttle', message: 'Too many requests. Please wait a moment before trying again.' }
      case 500:
        return { type: 'server', message: data?.message || 'Internal server error occurred.' }
      default:
        return { type: 'unknown', message: data?.message || 'An unexpected error occurred.' }
    }
  }

  // Notification helpers
  showSuccess(message, duration = 3000) {
    if (window.Nova && window.Nova.$toasted) {
      window.Nova.$toasted.success(message, { duration, position: 'top-right' })
    }
  }

  showError(message, duration = 5000) {
    if (window.Nova && window.Nova.$toasted) {
      window.Nova.$toasted.error(message, { duration, position: 'top-right' })
    }
  }
}

export default new CustomerSupportApiService()
