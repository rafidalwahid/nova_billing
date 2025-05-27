/**
 * Customer Portal Helper Functions
 */

/**
 * Format money amount with commas and decimal places
 * @param {number|string} amount
 * @returns {string}
 */
export function formatMoney(amount) {
  if (!amount) return '0.00'
  return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
}

/**
 * Format date to readable format
 * @param {string} date
 * @returns {string}
 */
export function formatDate(date) {
  if (!date) return ''
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

/**
 * Format time to readable format
 * @param {string} date
 * @returns {string}
 */
export function formatTime(date) {
  if (!date) return ''
  return new Date(date).toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

/**
 * Get initials from a name
 * @param {string} name
 * @returns {string}
 */
export function getInitials(name) {
  if (!name) return 'U';
  return name.split(' ')
    .map(word => word.charAt(0))
    .join('')
    .toUpperCase()
    .substring(0, 2);
}

/**
 * Get CSS classes for order status
 * @param {string} status
 * @returns {string}
 */
export function getOrderStatusClass(status) {
  const classes = {
    'pending': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    'processing': 'bg-blue-100 text-blue-800 border border-blue-200',
    'completed': 'bg-green-100 text-green-800 border border-green-200',
    'cancelled': 'bg-red-100 text-red-800 border border-red-200',
    'shipped': 'bg-purple-100 text-purple-800 border border-purple-200',
  }
  return classes[status] || 'bg-gray-100 text-gray-800 border border-gray-200'
}

/**
 * Get CSS classes for invoice status
 * @param {string} status
 * @returns {string}
 */
export function getInvoiceStatusClass(status) {
  const classes = {
    'draft': 'bg-gray-100 text-gray-800 border border-gray-200',
    'sent': 'bg-blue-100 text-blue-800 border border-blue-200',
    'paid': 'bg-green-100 text-green-800 border border-green-200',
    'overdue': 'bg-red-100 text-red-800 border border-red-200',
    'cancelled': 'bg-red-100 text-red-800 border border-red-200',
    'partial': 'bg-orange-100 text-orange-800 border border-orange-200',
  }
  return classes[status] || 'bg-gray-100 text-gray-800 border border-gray-200'
}

/**
 * Get CSS classes for customer status
 * @param {string} status
 * @returns {string}
 */
export function getCustomerStatusClass(status) {
  switch(status) {
    case 'Active':
      return 'bg-green-100 text-green-800 border border-green-200';
    case 'Inactive':
      return 'bg-red-100 text-red-800 border border-red-200';
    case 'Suspended':
      return 'bg-yellow-100 text-yellow-800 border border-yellow-200';
    default:
      return 'bg-gray-100 text-gray-800 border border-gray-200';
  }
}

/**
 * API helper for customer portal requests
 */
export class CustomerPortalAPI {
  static async getDashboardData() {
    try {
      const response = await Nova.request().get('/nova-vendor/customer-portal/dashboard')
      return response.data
    } catch (error) {
      console.error('Error loading dashboard data:', error)
      throw error
    }
  }







  // Support Tickets API
  static async getTickets(page = 1, filters = {}) {
    try {
      const params = new URLSearchParams()
      params.append('page', page)

      // Add filter parameters
      if (filters.search) {
        params.append('search', filters.search)
      }
      if (filters.status) {
        params.append('status', filters.status)
      }
      if (filters.priority) {
        params.append('priority', filters.priority)
      }
      if (filters.sort_by) {
        params.append('sort_by', filters.sort_by)
      }
      if (filters.sort_direction) {
        params.append('sort_direction', filters.sort_direction)
      }
      if (filters.per_page) {
        params.append('per_page', filters.per_page)
      }

      const response = await Nova.request().get(`/nova-vendor/customer-portal/tickets?${params.toString()}`)
      return response.data
    } catch (error) {
      console.error('Error loading tickets:', error)
      throw error
    }
  }

  static async getTicket(ticketId) {
    try {
      const response = await Nova.request().get(`/nova-vendor/customer-portal/tickets/${ticketId}`)
      return response.data
    } catch (error) {
      console.error('Error loading ticket:', error)
      throw error
    }
  }

  static async createTicket(ticketData) {
    try {
      const response = await Nova.request().post('/nova-vendor/customer-portal/tickets', ticketData)
      return response.data
    } catch (error) {
      console.error('Error creating ticket:', error)
      throw error
    }
  }

  static async addTicketResponse(ticketId, responseData) {
    try {
      const response = await Nova.request().post(`/nova-vendor/customer-portal/tickets/${ticketId}/responses`, responseData)
      return response.data
    } catch (error) {
      console.error('Error adding ticket response:', error)
      throw error
    }
  }

  static async uploadTicketAttachment(ticketId, formData) {
    try {
      const response = await Nova.request().post(`/nova-vendor/customer-portal/tickets/${ticketId}/attachments`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      return response.data
    } catch (error) {
      console.error('Error uploading ticket attachment:', error)
      throw error
    }
  }

  // Profile API
  static async getProfile() {
    try {
      const response = await Nova.request().get('/nova-vendor/customer-portal/profile')
      return response.data
    } catch (error) {
      console.error('Error loading profile:', error)
      throw error
    }
  }

  static async updateProfile(profileData) {
    try {
      const response = await Nova.request().put('/nova-vendor/customer-portal/profile', profileData)
      return response.data
    } catch (error) {
      console.error('Error updating profile:', error)
      throw error
    }
  }

  static async changePassword(passwordData) {
    try {
      const response = await Nova.request().put('/nova-vendor/customer-portal/profile/password', passwordData)
      return response.data
    } catch (error) {
      console.error('Error changing password:', error)
      throw error
    }
  }
}
