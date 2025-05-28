<template>
  <div v-if="isOpen" class="fixed inset-0 bg-gradient-to-br from-black/40 to-black/60 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-[95%] max-w-2xl max-h-[95vh] overflow-hidden flex flex-col m-4 border border-gray-200 dark:border-gray-600">
      <!-- Header -->
      <div class="flex justify-between items-center p-8 border-b border-gray-200 dark:border-gray-600 bg-gradient-to-r from-blue-50 to-white dark:from-gray-800 dark:to-gray-700">
        <h2 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100">
          Create New Support Ticket
        </h2>
        <button @click="closeWizard" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200">
          <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Progress Steps -->
      <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50">
        <div class="flex items-center justify-between">
          <div
            v-for="(_, index) in steps"
            :key="index"
            class="flex items-center"
            :class="{ 'flex-1': index < steps.length - 1 }"
          >
            <div
              class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium transition-all duration-200"
              :class="{
                'bg-blue-500 text-white': index === currentStep,
                'bg-green-500 text-white': index < currentStep,
                'bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400': index > currentStep
              }"
            >
              <span v-if="index < currentStep" class="text-white">✓</span>
              <span v-else class="text-sm font-medium">{{ index + 1 }}</span>
            </div>
            <div v-if="index < steps.length - 1" class="flex-1 h-0.5 mx-4 bg-gray-200 dark:bg-gray-600" :class="{ 'bg-green-500': index < currentStep, 'bg-blue-500': index === currentStep }"></div>
          </div>
        </div>
        <div class="flex justify-between mt-2">
          <span
            v-for="(step, index) in steps"
            :key="index"
            class="text-xs font-medium flex-1 text-center px-1"
            :class="{
              'text-blue-600 dark:text-blue-400': index === currentStep,
              'text-green-600 dark:text-green-400': index < currentStep,
              'text-gray-500 dark:text-gray-400': index > currentStep
            }"
          >
            <span class="hidden sm:inline">{{ step.title }}</span>
            <span class="sm:hidden">{{ step.title.substring(0, 4) }}</span>
          </span>
        </div>
      </div>

      <!-- Step Content -->
      <div class="p-8 bg-white dark:bg-gray-800 min-h-[300px] max-h-[60vh] overflow-y-auto">
        <!-- Step 1: Department Selection -->
        <div v-if="currentStep === 0" class="space-y-4">
          <h3 class="text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Which department can help you?
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <label
              v-for="dept in departments"
              :key="dept.value"
              class="relative cursor-pointer rounded-lg border p-4 transition-all duration-200 hover:shadow-md"
              :class="formData.department === dept.value
                ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-2 ring-blue-500'
                : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500'"
            >
              <input
                type="radio"
                :value="dept.value"
                v-model="formData.department"
                class="sr-only"
              >
              <div class="flex items-center">
                <div class="mr-3 text-lg sm:text-xl">{{ dept.icon }}</div>
                <div class="flex-1 min-w-0">
                  <div class="font-medium text-gray-900 dark:text-gray-100 text-sm sm:text-base">{{ dept.name }}</div>
                  <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 leading-tight">{{ dept.description }}</div>
                </div>
              </div>
            </label>
          </div>
        </div>

        <!-- Step 2: Priority & Subject -->
        <div v-if="currentStep === 1" class="space-y-4">
          <h3 class="text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Tell us about your issue
          </h3>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority Level</label>
            <select v-model="formData.priority" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
              <option value="low">Low - General question or request</option>
              <option value="medium">Medium - Issue affecting my work</option>
              <option value="high">High - Urgent issue needs quick resolution</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
            <input
              type="text"
              v-model="formData.subject"
              placeholder="Brief description of your issue"
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
              maxlength="100"
            >
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              {{ formData.subject.length }}/100 characters
            </div>
          </div>
        </div>

        <!-- Step 3: Description & Details -->
        <div v-if="currentStep === 2" class="space-y-4">
          <h3 class="text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Provide more details
          </h3>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea
              v-model="formData.description"
              placeholder="Please describe your issue in detail. Include any error messages, steps to reproduce, or relevant information."
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-vertical"
              rows="6"
              maxlength="1000"
            ></textarea>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              {{ formData.description.length }}/1000 characters
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Email</label>
            <input
              type="email"
              v-model="formData.email"
              placeholder="your@email.com"
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
            >
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              We'll send updates to this email address
            </div>
          </div>
        </div>

        <!-- Step 4: Review & Submit -->
        <div v-if="currentStep === 3" class="space-y-4">
          <h3 class="text-sm sm:text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Review your ticket
          </h3>

          <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 space-y-4">
            <div class="flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600">
              <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Department:</span>
              <span class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ getDepartmentName(formData.department) }}</span>
            </div>
            <div class="flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600">
              <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Priority:</span>
              <span class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ getPriorityName(formData.priority) }}</span>
            </div>
            <div class="flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600">
              <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Subject:</span>
              <span class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ formData.subject }}</span>
            </div>
            <div class="flex justify-between items-start py-2 border-b border-gray-200 dark:border-gray-600">
              <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Email:</span>
              <span class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ formData.email }}</span>
            </div>
            <div class="py-2">
              <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block mb-2">Description:</span>
              <div class="text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 p-3 rounded border border-gray-200 dark:border-gray-600 whitespace-pre-wrap">{{ formData.description }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Actions -->
      <div class="flex justify-between items-center p-8 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 gap-4">
        <button
          v-if="currentStep > 0"
          @click="previousStep"
          class="bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-8 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-lg hover:-translate-y-0.5"
        >
          Previous
        </button>
        <div class="flex-1"></div>
        <button
          v-if="currentStep < steps.length - 1"
          @click="nextStep"
          :disabled="!canProceed"
          class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
        >
          Next
        </button>
        <button
          v-if="currentStep === steps.length - 1"
          @click="submitTicket"
          :disabled="isSubmitting"
          class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-sm tracking-wide transition-all duration-200 shadow-sm hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
        >
          {{ isSubmitting ? 'Creating...' : 'Create Ticket' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, reactive, watch } from 'vue'

export default {
  name: 'TicketWizard',

  props: {
    isOpen: {
      type: Boolean,
      default: false,
      required: true
    }
  },

  emits: {
    close: null,
    ticketCreated: (ticket) => ticket && typeof ticket === 'object'
  },

  setup(props, { emit }) {
    // Reactive state
    const currentStep = ref(0)
    const isSubmitting = ref(false)

    // Static configuration
    const steps = [
      { title: 'Department' },
      { title: 'Details' },
      { title: 'Description' },
      { title: 'Review' }
    ]

    const departments = [
      {
        value: 'billing',
        name: 'Billing Support',
        description: 'Questions about invoices, payments, or billing issues',
        icon: '💳'
      },
      {
        value: 'technical',
        name: 'Technical Support',
        description: 'Website issues, hosting problems, or technical difficulties',
        icon: '🔧'
      },
      {
        value: 'general',
        name: 'General Support',
        description: 'Account questions, general inquiries, or other issues',
        icon: '💬'
      },
      {
        value: 'sales',
        name: 'Sales Inquiry',
        description: 'Questions about services, upgrades, or new purchases',
        icon: '🛒'
      }
    ]

    // Form data
    const formData = reactive({
      department: '',
      priority: 'medium',
      subject: '',
      description: '',
      email: ''
    })

    // Computed properties
    const canProceed = computed(() => {
      switch (currentStep.value) {
        case 0:
          return formData.department !== ''
        case 1:
          return formData.priority !== '' && formData.subject.trim() !== ''
        case 2:
          return formData.description.trim() !== '' && formData.email.trim() !== ''
        case 3:
          return true
        default:
          return false
      }
    })

    // Watch for modal close to reset form
    watch(() => props.isOpen, (newValue) => {
      if (!newValue) {
        resetForm()
      }
    })

    return {
      currentStep,
      isSubmitting,
      steps,
      departments,
      formData,
      canProceed,
      emit
    }
  },

  methods: {
    nextStep() {
      if (this.canProceed && this.currentStep < this.steps.length - 1) {
        this.currentStep++
      }
    },

    previousStep() {
      if (this.currentStep > 0) {
        this.currentStep--
      }
    },

    closeWizard() {
      this.resetForm()
      this.emit('close')
    },

    resetForm() {
      this.currentStep = 0
      this.isSubmitting = false
      Object.assign(this.formData, {
        department: '',
        priority: 'medium',
        subject: '',
        description: '',
        email: ''
      })
    },

    async submitTicket() {
      this.isSubmitting = true

      try {
        const payload = {
          department: this.formData.department,
          priority: this.formData.priority,
          subject: this.formData.subject.trim(),
          description: this.formData.description.trim(),
          email: this.formData.email.trim()
        }

        const response = await Nova.request().post('/nova-vendor/customer-support/tickets', payload)

        const ticketNumber = response.data.data?.ticket_number || 'Unknown'
        this.showSuccessMessage(`Ticket ${ticketNumber} created successfully! You will receive a confirmation email shortly.`)

        this.emit('ticketCreated', response.data.data)
        this.closeWizard()

      } catch (error) {
        const errorMessage = this.getErrorMessage(error)
        this.showErrorMessage(errorMessage)
      } finally {
        this.isSubmitting = false
      }
    },

    getDepartmentName(value) {
      const dept = this.departments.find(d => d.value === value)
      return dept ? dept.name : value
    },

    getPriorityName(value) {
      const priorityMap = {
        'low': 'Low Priority',
        'medium': 'Medium Priority',
        'high': 'High Priority'
      }
      return priorityMap[value] || value
    },

    getErrorMessage(error) {
      const status = error.response?.status
      const data = error.response?.data

      switch (status) {
        case 401:
          return 'Authentication required. Please log in again.'
        case 403:
          return 'Access denied. You do not have permission to create tickets.'
        case 422:
          if (data?.errors) {
            const errorList = Object.values(data.errors).flat().join('\n')
            return `Validation errors:\n${errorList}`
          }
          return 'Please check your input. Some fields may be invalid.'
        case 429:
          return 'Too many requests. Please wait a moment before trying again.'
        case 500:
          return data?.message ? `Server error: ${data.message}` : 'Internal server error occurred.'
        default:
          return data?.message || 'Failed to create ticket. Please try again.'
      }
    },

    showSuccessMessage(message) {
      if (this.$toasted) {
        this.$toasted.success(message, {
          duration: 5000,
          position: 'top-right'
        })
      }
    },

    showErrorMessage(message) {
      if (this.$toasted) {
        this.$toasted.error(message, {
          duration: 8000,
          position: 'top-right'
        })
      }
    }
  }
}
</script>
