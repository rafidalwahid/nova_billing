// Shared utilities composable
import { computed } from 'vue'

export function useTicketHelpers() {
  // Status configurations
  const statusConfig = {
    'open': {
      label: 'Open',
      badge: 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-700',
      dot: 'bg-blue-500'
    },
    'in_progress': {
      label: 'In Progress',
      badge: 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-700',
      dot: 'bg-amber-500'
    },
    'waiting_customer': {
      label: 'Waiting for Your Response',
      badge: 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 border-orange-200 dark:border-orange-700',
      dot: 'bg-orange-500'
    },
    'resolved': {
      label: 'Resolved',
      badge: 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700',
      dot: 'bg-emerald-500'
    },
    'closed': {
      label: 'Closed',
      badge: 'bg-gray-100 dark:bg-gray-700/50 text-gray-800 dark:text-gray-300 border-gray-200 dark:border-gray-600',
      dot: 'bg-gray-500'
    }
  }

  // Priority configurations
  const priorityConfig = {
    'low': {
      label: 'Low',
      badge: 'bg-slate-100 dark:bg-slate-900/30 text-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700'
    },
    'normal': {
      label: 'Normal',
      badge: 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700'
    },
    'medium': {
      label: 'Medium',
      badge: 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700'
    },
    'high': {
      label: 'High',
      badge: 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-700'
    },
    'urgent': {
      label: 'Urgent',
      badge: 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-700'
    }
  }

  // Department configurations
  const departmentConfig = {
    'billing': {
      label: 'Billing Support',
      badge: 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700',
      icon: '💳',
      description: 'Questions about invoices, payments, or billing issues'
    },
    'technical': {
      label: 'Technical Support',
      badge: 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border-purple-200 dark:border-purple-700',
      icon: '🔧',
      description: 'Website issues, hosting problems, or technical difficulties'
    },
    'general': {
      label: 'General Support',
      badge: 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700',
      icon: '💬',
      description: 'Account questions, general inquiries, or other issues'
    },
    'sales': {
      label: 'Sales Inquiry',
      badge: 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 border-amber-200 dark:border-amber-700',
      icon: '🛒',
      description: 'Questions about services, upgrades, or new purchases'
    }
  }

  // Helper functions
  const getStatusConfig = (status) => statusConfig[status] || statusConfig.closed
  const getPriorityConfig = (priority) => priorityConfig[priority] || priorityConfig.normal
  const getDepartmentConfig = (department) => departmentConfig[department] || departmentConfig.general

  const formatStatus = (status) => getStatusConfig(status).label
  const formatPriority = (priority) => getPriorityConfig(priority).label
  const formatDepartment = (department) => getDepartmentConfig(department).label

  const getStatusBadgeClass = (status) => getStatusConfig(status).badge
  const getStatusDotClass = (status) => getStatusConfig(status).dot
  const getPriorityBadgeClass = (priority) => getPriorityConfig(priority).badge
  const getDepartmentBadgeClass = (department) => getDepartmentConfig(department).badge

  const formatDate = (date) => {
    if (!date) return ''
    try {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    } catch (error) {
      console.warn('Invalid date format:', date)
      return 'Invalid Date'
    }
  }

  const getCustomerName = (ticket) => {
    return ticket.customer?.name || ticket.user?.name || 'Unknown Customer'
  }

  const getCustomerInitials = (name) => {
    if (!name) return '??'
    const parts = name.split(' ')
    if (parts.length >= 2) {
      return (parts[0][0] + parts[1][0]).toUpperCase()
    }
    return name.substring(0, 2).toUpperCase()
  }

  const truncateText = (text, maxLength = 80) => {
    if (!text || text.length <= maxLength) return text
    return text.substring(0, maxLength) + '...'
  }

  return {
    // Configurations
    statusConfig,
    priorityConfig,
    departmentConfig,
    
    // Formatters
    formatStatus,
    formatPriority,
    formatDepartment,
    formatDate,
    
    // Style helpers
    getStatusBadgeClass,
    getStatusDotClass,
    getPriorityBadgeClass,
    getDepartmentBadgeClass,
    
    // Utility functions
    getCustomerName,
    getCustomerInitials,
    truncateText
  }
}
