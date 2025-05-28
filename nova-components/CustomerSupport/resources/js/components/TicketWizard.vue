<template>
  <transition
    enter-active-class="transition-opacity duration-300"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition-opacity duration-300"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="isOpen"
      class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
      @click.self="closeWizard"
      role="dialog"
      aria-modal="true"
      aria-labelledby="wizard-title"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col border border-gray-200 dark:border-gray-600"
        @click.stop
      >
        <!-- Header -->
        <WizardHeader @close="closeWizard" />

        <!-- Progress Steps -->
        <WizardProgress :currentStep="currentStep" :steps="steps" />

        <!-- Step Content -->
        <div class="flex-1 overflow-y-auto p-6">
          <WizardStep
            :step="currentStep"
            :formData="formData"
            :departments="departments"
            @update:formData="updateFormData"
          />
        </div>

        <!-- Footer Actions -->
        <WizardFooter
          :currentStep="currentStep"
          :totalSteps="steps.length"
          :canProceed="canProceed"
          :isSubmitting="isSubmitting"
          @previous="previousStep"
          @next="nextStep"
          @submit="submitTicket"
        />
      </div>
    </div>
  </transition>
</template>

<script>
import { ref, reactive, computed, watch } from 'vue'
import { useTicketHelpers } from '../composables/useTicketHelpers.js'
import apiService from '../services/api.js'

// Sub-components
const WizardHeader = {
  template: `
    <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-600 bg-gradient-to-r from-blue-50 to-white dark:from-gray-800 dark:to-gray-700">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
          <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
        </div>
        <div>
          <h2 id="wizard-title" class="text-xl font-bold text-gray-900 dark:text-gray-100">
            Create Support Ticket
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">We're here to help you resolve any issues</p>
        </div>
      </div>
      <button
        @click="$emit('close')"
        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
        aria-label="Close dialog"
      >
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  `,
  emits: ['close']
}

const WizardProgress = {
  template: `
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50">
      <div class="flex items-center justify-between">
        <div
          v-for="(_, index) in steps"
          :key="index"
          class="flex items-center"
          :class="{ 'flex-1': index < steps.length - 1 }"
        >
          <div
            class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 shadow-sm"
            :class="getStepClass(index)"
            :aria-current="index === currentStep ? 'step' : undefined"
          >
            <span v-if="index < currentStep">✓</span>
            <span v-else>{{ index + 1 }}</span>
          </div>
          <div v-if="index < steps.length - 1" class="flex-1 h-1 mx-4 rounded-full transition-all duration-300" :class="getConnectorClass(index)"></div>
        </div>
      </div>
      <div class="flex justify-between mt-3">
        <span
          v-for="(step, index) in steps"
          :key="index"
          class="text-sm font-medium flex-1 text-center transition-colors duration-300"
          :class="getStepLabelClass(index)"
        >
          {{ step.title }}
        </span>
      </div>
    </div>
  `,
  props: ['currentStep', 'steps'],
  methods: {
    getStepClass(index) {
      if (index < this.currentStep) {
        return 'bg-green-500 text-white shadow-green-200 dark:shadow-green-900/50'
      } else if (index === this.currentStep) {
        return 'bg-blue-600 text-white shadow-blue-200 dark:shadow-blue-900/50'
      } else {
        return 'bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400'
      }
    },
    getConnectorClass(index) {
      return index < this.currentStep ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-600'
    },
    getStepLabelClass(index) {
      if (index <= this.currentStep) {
        return 'text-blue-600 dark:text-blue-400'
      } else {
        return 'text-gray-500 dark:text-gray-400'
      }
    }
  }
}

const WizardStep = {
  template: `
    <div class="space-y-6">
      <!-- Step 0: Department Selection -->
      <DepartmentStep
        v-if="step === 0"
        :selected="formData.department"
        :departments="departments"
        @select="$emit('update:formData', { department: $event })"
      />

      <!-- Step 1: Priority & Subject -->
      <DetailsStep
        v-else-if="step === 1"
        :priority="formData.priority"
        :subject="formData.subject"
        @update:priority="$emit('update:formData', { priority: $event })"
        @update:subject="$emit('update:formData', { subject: $event })"
      />

      <!-- Step 2: Description & Email -->
      <DescriptionStep
        v-else-if="step === 2"
        :description="formData.description"
        :email="formData.email"
        @update:description="$emit('update:formData', { description: $event })"
        @update:email="$emit('update:formData', { email: $event })"
      />

      <!-- Step 3: Review -->
      <ReviewStep
        v-else-if="step === 3"
        :formData="formData"
        :departments="departments"
      />
    </div>
  `,
  props: ['step', 'formData', 'departments'],
  emits: ['update:formData']
}

const WizardFooter = {
  template: `
    <div class="flex justify-between items-center p-6 border-t border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50">
      <button
        v-if="currentStep > 0"
        @click="$emit('previous')"
        class="px-6 py-3 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg font-medium transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-600"
      >
        ← Previous
      </button>
      <div class="flex-1"></div>
      <button
        v-if="currentStep < totalSteps - 1"
        @click="$emit('next')"
        :disabled="!canProceed"
        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-medium rounded-lg transition-colors duration-200 disabled:cursor-not-allowed"
      >
        Next →
      </button>
      <button
        v-else
        @click="$emit('submit')"
        :disabled="!canProceed || isSubmitting"
        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-medium rounded-lg transition-colors duration-200 disabled:cursor-not-allowed flex items-center gap-2"
      >
        <span v-if="isSubmitting">
          <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </span>
        {{ isSubmitting ? 'Creating...' : 'Create Ticket' }}
      </button>
    </div>
  `,
  props: ['currentStep', 'totalSteps', 'canProceed', 'isSubmitting'],
  emits: ['previous', 'next', 'submit']
}

// Step components would be defined here (DepartmentStep, DetailsStep, etc.)
// For brevity, I'll create simplified versions

const DepartmentStep = {
  template: `
    <div>
      <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        Which department can help you?
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label
          v-for="dept in departments"
          :key="dept.value"
          class="relative cursor-pointer rounded-lg border p-4 transition-all duration-200 hover:shadow-md"
          :class="selected === dept.value
            ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-2 ring-blue-500'
            : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500'"
        >
          <input
            type="radio"
            :value="dept.value"
            :checked="selected === dept.value"
            @change="$emit('select', dept.value)"
            class="sr-only"
          >
          <div class="flex items-center">
            <div class="mr-3 text-2xl">{{ dept.icon }}</div>
            <div>
              <div class="font-medium text-gray-900 dark:text-gray-100">{{ dept.label }}</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">{{ dept.description }}</div>
            </div>
          </div>
        </label>
      </div>
    </div>
  `,
  props: ['selected', 'departments'],
  emits: ['select']
}

export default {
  name: 'TicketWizard',

  components: {
    WizardHeader,
    WizardProgress,
    WizardStep,
    WizardFooter,
    DepartmentStep
    // Other step components would be imported here
  },

  props: {
    isOpen: { type: Boolean, default: false }
  },

  emits: ['close', 'ticketCreated'],

  setup(props, { emit }) {
    const currentStep = ref(0)
    const isSubmitting = ref(false)

    const steps = [
      { title: 'Department' },
      { title: 'Details' },
      { title: 'Description' },
      { title: 'Review' }
    ]

    const formData = reactive({
      department: '',
      priority: 'medium',
      subject: '',
      description: '',
      email: ''
    })

    const { departmentConfig } = useTicketHelpers()
    
    const departments = Object.entries(departmentConfig).map(([value, config]) => ({
      value,
      ...config
    }))

    const canProceed = computed(() => {
      switch (currentStep.value) {
        case 0: return formData.department !== ''
        case 1: return formData.priority && formData.subject.trim() !== ''
        case 2: return formData.description.trim() !== '' && formData.email.trim() !== ''
        case 3: return true
        default: return false
      }
    })

    // Reset form when modal closes
    watch(() => props.isOpen, (newValue) => {
      if (!newValue) {
        resetForm()
      }
    })

    const nextStep = () => {
      if (canProceed.value && currentStep.value < steps.length - 1) {
        currentStep.value++
      }
    }

    const previousStep = () => {
      if (currentStep.value > 0) {
        currentStep.value--
      }
    }

    const updateFormData = (updates) => {
      Object.assign(formData, updates)
    }

    const closeWizard = () => {
      emit('close')
    }

    const resetForm = () => {
      currentStep.value = 0
      isSubmitting.value = false
      Object.assign(formData, {
        department: '',
        priority: 'medium',
        subject: '',
        description: '',
        email: ''
      })
    }

    const submitTicket = async () => {
      if (!canProceed.value) return

      isSubmitting.value = true

      try {
        const response = await apiService.createTicket({
          department: formData.department,
          priority: formData.priority,
          subject: formData.subject.trim(),
          description: formData.description.trim(),
          email: formData.email.trim()
        })

        apiService.showSuccess(`Ticket ${response.data.ticket_number} created successfully!`)
        emit('ticketCreated', response.data)
        closeWizard()

      } catch (error) {
        const errorMessage = apiService.formatError(error).message
        apiService.showError(errorMessage)
      } finally {
        isSubmitting.value = false
      }
    }

    return {
      currentStep,
      isSubmitting,
      steps,
      formData,
      departments,
      canProceed,
      nextStep,
      previousStep,
      updateFormData,
      closeWizard,
      submitTicket
    }
  }
}
</script>
