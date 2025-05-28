<template>
  <div 
    v-if="isOpen" 
    class="fixed inset-0 bg-gradient-to-br from-black/40 to-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    @click.self="$emit('close')"
  >
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-600">
      <!-- Header -->
      <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-600 bg-gradient-to-r from-blue-50 to-white dark:from-gray-800 dark:to-gray-700">
        <div class="flex items-center gap-4">
          <div class="flex items-center justify-center w-10 h-10 bg-blue-500 rounded-lg">
            <TicketIcon />
          </div>
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
              Ticket #{{ ticket?.ticket_number }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              {{ ticket?.subject }}
            </p>
          </div>
        </div>
        <button 
          @click="$emit('close')" 
          class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
        >
          <CloseIcon />
        </button>
      </div>

      <!-- Content -->
      <div class="flex-1 overflow-hidden flex flex-col">
        <!-- Ticket Info Bar -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600">
          <div class="flex flex-wrap items-center gap-4 text-sm">
            <div class="flex items-center gap-2">
              <span class="text-gray-500 dark:text-gray-400">Status:</span>
              <span 
                :class="getStatusBadgeClass(ticket?.status)"
                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium uppercase tracking-wider border"
              >
                {{ formatStatus(ticket?.status) }}
              </span>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-gray-500 dark:text-gray-400">Department:</span>
              <span class="text-gray-900 dark:text-gray-100 font-medium">
                {{ getDepartmentName(ticket?.category) }}
              </span>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-gray-500 dark:text-gray-400">Created:</span>
              <span class="text-gray-900 dark:text-gray-100">
                {{ formatDate(ticket?.created_at) }}
              </span>
            </div>
          </div>
        </div>

        <!-- Conversation Thread -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
          <div v-if="loading" class="flex justify-center py-8">
            <LoadingSpinner message="Loading conversation..." />
          </div>
          
          <div v-else-if="responses.length === 0" class="text-center py-8">
            <div class="text-gray-500 dark:text-gray-400">
              No responses yet. Be the first to reply!
            </div>
          </div>

          <div v-else class="space-y-4">
            <div 
              v-for="response in responses" 
              :key="response.id"
              class="flex gap-4"
              :class="{ 'flex-row-reverse': response.is_customer }"
            >
              <!-- Avatar -->
              <div class="flex-shrink-0">
                <div 
                  class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-medium"
                  :class="response.is_customer ? 'bg-blue-500' : 'bg-gray-500'"
                >
                  {{ getInitials(response.author_name) }}
                </div>
              </div>

              <!-- Message -->
              <div 
                class="flex-1 max-w-[70%]"
                :class="{ 'text-right': response.is_customer }"
              >
                <div 
                  class="rounded-2xl px-4 py-3 shadow-sm border"
                  :class="response.is_customer 
                    ? 'bg-blue-500 text-white border-blue-500' 
                    : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-200 dark:border-gray-600'"
                >
                  <div class="text-sm whitespace-pre-wrap">{{ response.message }}</div>
                </div>
                <div 
                  class="text-xs mt-1 px-2"
                  :class="response.is_customer ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400'"
                >
                  {{ response.author_name }} • {{ formatDate(response.created_at) }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Reply Form -->
        <div v-if="canReply" class="border-t border-gray-200 dark:border-gray-600 p-6 bg-gray-50 dark:bg-gray-700/50">
          <form @submit.prevent="submitReply" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Add a reply
              </label>
              <textarea
                v-model="replyMessage"
                placeholder="Type your message here..."
                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-vertical"
                rows="3"
                maxlength="1000"
                :disabled="isSubmitting"
              ></textarea>
              <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                {{ replyMessage.length }}/1000 characters
              </div>
            </div>
            <div class="flex justify-end gap-3">
              <button
                type="button"
                @click="replyMessage = ''"
                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200"
                :disabled="isSubmitting"
              >
                Clear
              </button>
              <button
                type="submit"
                :disabled="!replyMessage.trim() || isSubmitting"
                class="px-6 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
              >
                <span v-if="isSubmitting">Sending...</span>
                <span v-else>Send Reply</span>
                <SendIcon v-if="!isSubmitting" />
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingSpinner from './LoadingSpinner.vue'

// Icon Components
const TicketIcon = {
  template: `
    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
    </svg>
  `
}

const CloseIcon = {
  template: `
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  `
}

const SendIcon = {
  template: `
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
    </svg>
  `
}

export default {
  name: 'TicketDetailsModal',

  components: {
    LoadingSpinner,
    TicketIcon,
    CloseIcon,
    SendIcon
  },

  props: {
    isOpen: {
      type: Boolean,
      default: false
    },
    ticket: {
      type: Object,
      default: null
    }
  },

  emits: {
    close: null,
    addResponse: (message) => typeof message === 'string' && message.trim().length > 0
  },

  data() {
    return {
      loading: false,
      responses: [],
      replyMessage: '',
      isSubmitting: false
    }
  },

  computed: {
    canReply() {
      return this.ticket && ['open', 'in_progress'].includes(this.ticket.status)
    }
  },

  watch: {
    isOpen(newValue) {
      if (newValue && this.ticket) {
        this.loadResponses()
      }
    }
  },

  methods: {
    async loadResponses() {
      if (!this.ticket) return

      try {
        this.loading = true
        const response = await Nova.request().get(`/nova-vendor/customer-support/tickets/${this.ticket.id}/responses`)
        this.responses = response.data.data || []
      } catch (error) {
        console.error('Failed to load responses:', error)
        this.responses = []
      } finally {
        this.loading = false
      }
    },

    async submitReply() {
      if (!this.replyMessage.trim() || !this.ticket) return

      try {
        this.isSubmitting = true
        
        const response = await Nova.request().post(`/nova-vendor/customer-support/tickets/${this.ticket.id}/responses`, {
          message: this.replyMessage.trim()
        })

        this.responses.push(response.data.data)
        this.replyMessage = ''
        this.$emit('addResponse', response.data.data)

        if (this.$toasted) {
          this.$toasted.success('Reply sent successfully!', {
            duration: 3000,
            position: 'top-right'
          })
        }

      } catch (error) {
        console.error('Failed to send reply:', error)
        
        if (this.$toasted) {
          this.$toasted.error('Failed to send reply. Please try again.', {
            duration: 5000,
            position: 'top-right'
          })
        }
      } finally {
        this.isSubmitting = false
      }
    },

    getStatusBadgeClass(status) {
      const classes = {
        'open': 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800/30',
        'in_progress': 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800/30',
        'resolved': 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border-green-200 dark:border-green-800/30',
        'closed': 'bg-gray-50 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700'
      }
      return classes[status] || classes.closed
    },

    formatStatus(status) {
      const statusMap = {
        'open': 'Open',
        'in_progress': 'In Progress',
        'resolved': 'Resolved',
        'closed': 'Closed'
      }
      return statusMap[status] || 'Unknown'
    },

    formatDate(date) {
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
        return 'Invalid Date'
      }
    },

    getDepartmentName(category) {
      const departmentNames = {
        'billing': 'Billing Support',
        'technical': 'Technical Support',
        'sales': 'Sales Inquiry',
        'general': 'General Support'
      }
      return departmentNames[category] || 'General Support'
    },

    getInitials(name) {
      if (!name) return '?'
      return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2)
    }
  }
}
</script>
