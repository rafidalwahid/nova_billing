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

  static async getOrders() {
    try {
      const response = await Nova.request().get('/nova-vendor/customer-portal/orders')
      return response.data
    } catch (error) {
      console.error('Error loading orders:', error)
      throw error
    }
  }

  static async getInvoices() {
    try {
      const response = await Nova.request().get('/nova-vendor/customer-portal/invoices')
      return response.data
    } catch (error) {
      console.error('Error loading invoices:', error)
      throw error
    }
  }

  static async getTickets() {
    try {
      const response = await Nova.request().get('/nova-vendor/customer-portal/tickets')
      return response.data
    } catch (error) {
      console.error('Error loading tickets:', error)
      throw error
    }
  }
}
