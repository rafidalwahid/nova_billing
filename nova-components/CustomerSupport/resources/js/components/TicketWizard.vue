<template>
  <div v-if="isOpen" class="wizard-overlay">
    <div class="wizard-modal">
      <!-- Header -->
      <div class="wizard-header">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Create New Support Ticket
        </h2>
        <button @click="closeWizard" class="wizard-close-btn">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Progress Steps -->
      <div class="wizard-progress">
        <div class="flex items-center justify-between">
          <div
            v-for="(step, index) in steps"
            :key="index"
            class="flex items-center"
            :class="{ 'flex-1': index < steps.length - 1 }"
          >
            <div
              class="wizard-step-circle"
              :class="{
                'wizard-step-active': index === currentStep,
                'wizard-step-completed': index < currentStep,
                'wizard-step-pending': index > currentStep
              }"
            >
              <span v-if="index < currentStep" class="text-white">✓</span>
              <span v-else class="text-sm font-medium">{{ index + 1 }}</span>
            </div>
            <div v-if="index < steps.length - 1" class="wizard-step-line"></div>
          </div>
        </div>
        <div class="flex justify-between mt-2">
          <span
            v-for="(step, index) in steps"
            :key="index"
            class="text-xs font-medium"
            :class="{
              'text-blue-600 dark:text-blue-400': index === currentStep,
              'text-green-600 dark:text-green-400': index < currentStep,
              'text-gray-500 dark:text-gray-400': index > currentStep
            }"
          >
            {{ step.title }}
          </span>
        </div>
      </div>

      <!-- Step Content -->
      <div class="wizard-content">
        <!-- Step 1: Department Selection -->
        <div v-if="currentStep === 0" class="wizard-step">
          <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Which department can help you?
          </h3>
          <div class="grid grid-cols-1 gap-3">
            <label
              v-for="dept in departments"
              :key="dept.value"
              class="wizard-radio-card"
              :class="{ 'wizard-radio-selected': formData.department === dept.value }"
            >
              <input
                type="radio"
                :value="dept.value"
                v-model="formData.department"
                class="sr-only"
              >
              <div class="flex items-center">
                <div class="wizard-radio-icon">{{ dept.icon }}</div>
                <div>
                  <div class="font-medium text-gray-900 dark:text-gray-100">{{ dept.name }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">{{ dept.description }}</div>
                </div>
              </div>
            </label>
          </div>
        </div>

        <!-- Step 2: Priority & Subject -->
        <div v-if="currentStep === 1" class="wizard-step">
          <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Tell us about your issue
          </h3>

          <div class="mb-4">
            <label class="wizard-label">Priority Level</label>
            <select v-model="formData.priority" class="form-control">
              <option value="low">Low - General question or request</option>
              <option value="medium">Medium - Issue affecting my work</option>
              <option value="high">High - Urgent issue needs quick resolution</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="wizard-label">Subject</label>
            <input
              type="text"
              v-model="formData.subject"
              placeholder="Brief description of your issue"
              class="form-control"
              maxlength="100"
            >
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              {{ formData.subject.length }}/100 characters
            </div>
          </div>
        </div>

        <!-- Step 3: Description & Details -->
        <div v-if="currentStep === 2" class="wizard-step">
          <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Provide more details
          </h3>

          <div class="mb-4">
            <label class="wizard-label">Description</label>
            <textarea
              v-model="formData.description"
              placeholder="Please describe your issue in detail. Include any error messages, steps to reproduce, or relevant information."
              class="form-control"
              rows="6"
              maxlength="1000"
            ></textarea>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              {{ formData.description.length }}/1000 characters
            </div>
          </div>

          <div class="mb-4">
            <label class="wizard-label">Contact Email</label>
            <input
              type="email"
              v-model="formData.email"
              placeholder="your@email.com"
              class="form-control"
            >
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              We'll send updates to this email address
            </div>
          </div>
        </div>

        <!-- Step 4: Review & Submit -->
        <div v-if="currentStep === 3" class="wizard-step">
          <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
            Review your ticket
          </h3>

          <div class="wizard-review">
            <div class="wizard-review-item">
              <span class="wizard-review-label">Department:</span>
              <span class="wizard-review-value">{{ getDepartmentName(formData.department) }}</span>
            </div>
            <div class="wizard-review-item">
              <span class="wizard-review-label">Priority:</span>
              <span class="wizard-review-value">{{ getPriorityName(formData.priority) }}</span>
            </div>
            <div class="wizard-review-item">
              <span class="wizard-review-label">Subject:</span>
              <span class="wizard-review-value">{{ formData.subject }}</span>
            </div>
            <div class="wizard-review-item">
              <span class="wizard-review-label">Email:</span>
              <span class="wizard-review-value">{{ formData.email }}</span>
            </div>
            <div class="wizard-review-item">
              <span class="wizard-review-label">Description:</span>
              <div class="wizard-review-description">{{ formData.description }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Actions -->
      <div class="wizard-footer">
        <button
          v-if="currentStep > 0"
          @click="previousStep"
          class="wizard-btn-secondary"
        >
          Previous
        </button>
        <div class="flex-1"></div>
        <button
          v-if="currentStep < steps.length - 1"
          @click="nextStep"
          :disabled="!canProceed"
          class="wizard-btn-primary"
          :class="{ 'wizard-btn-disabled': !canProceed }"
        >
          Next
        </button>
        <button
          v-if="currentStep === steps.length - 1"
          @click="submitTicket"
          :disabled="isSubmitting"
          class="wizard-btn-primary"
          :class="{ 'wizard-btn-disabled': isSubmitting }"
        >
          {{ isSubmitting ? 'Creating...' : 'Create Ticket' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TicketWizard',

  props: {
    isOpen: {
      type: Boolean,
      default: false
    }
  },

  emits: ['close', 'ticketCreated'],

  data() {
    return {
      currentStep: 0,
      isSubmitting: false,

      steps: [
        { title: 'Department' },
        { title: 'Details' },
        { title: 'Description' },
        { title: 'Review' }
      ],

      departments: [
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
      ],

      formData: {
        department: '',
        priority: 'medium',
        subject: '',
        description: '',
        email: ''
      }
    }
  },

  computed: {
    canProceed() {
      switch (this.currentStep) {
        case 0:
          return this.formData.department !== ''
        case 1:
          return this.formData.priority !== '' && this.formData.subject.trim() !== ''
        case 2:
          return this.formData.description.trim() !== '' && this.formData.email.trim() !== ''
        case 3:
          return true
        default:
          return false
      }
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
      this.$emit('close')
    },

    resetForm() {
      this.currentStep = 0
      this.isSubmitting = false
      this.formData = {
        department: '',
        priority: 'medium',
        subject: '',
        description: '',
        email: ''
      }
    },

    async submitTicket() {
      this.isSubmitting = true

      try {
        // Make actual API call to create ticket
        const response = await Nova.request().post('/nova-vendor/customer-support/tickets', {
          department: this.formData.department,
          priority: this.formData.priority,
          subject: this.formData.subject,
          description: this.formData.description,
          email: this.formData.email
        })

        console.log('Ticket created successfully:', response.data)

        // Show success message
        const ticketNumber = response.data.data?.ticket_number || 'Unknown'
        alert(`Ticket ${ticketNumber} created successfully! You will receive a confirmation email shortly.`)

        this.$emit('ticketCreated', response.data.data)
        this.closeWizard()

      } catch (error) {
        console.error('Error creating ticket:', error)
        console.error('Error response:', error.response)

        // Show detailed error message
        let errorMessage = 'Failed to create ticket. Please try again.'

        if (error.response?.status === 401) {
          errorMessage = 'Authentication required. Please log in again.'
        } else if (error.response?.status === 403) {
          errorMessage = 'Access denied. You do not have permission to create tickets.'
        } else if (error.response?.status === 422) {
          // Validation errors
          const validationErrors = error.response?.data?.errors
          if (validationErrors) {
            const errorList = Object.values(validationErrors).flat().join('\n')
            errorMessage = `Validation errors:\n${errorList}`
          } else {
            errorMessage = 'Please check your input. Some fields may be invalid.'
          }
        } else if (error.response?.status === 500) {
          // Server error
          const serverMessage = error.response?.data?.message
          errorMessage = serverMessage ? `Server error: ${serverMessage}` : 'Internal server error occurred.'
        } else if (error.response?.data?.message) {
          errorMessage = error.response.data.message
        }

        alert(errorMessage)
      } finally {
        this.isSubmitting = false
      }
    },

    getDepartmentName(value) {
      const dept = this.departments.find(d => d.value === value)
      return dept ? dept.name : value
    },

    getPriorityName(value) {
      const priorities = {
        'low': 'Low Priority',
        'medium': 'Medium Priority',
        'high': 'High Priority'
      }
      return priorities[value] || value
    }
  }
}
</script>
