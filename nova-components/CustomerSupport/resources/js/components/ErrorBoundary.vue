<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-600 p-6 text-center">
      <!-- Error Icon -->
      <div class="mx-auto w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
      </div>

      <!-- Error Message -->
      <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Something went wrong
      </h2>
      
      <p class="text-gray-600 dark:text-gray-400 mb-6">
        {{ error?.message || 'An unexpected error occurred while loading your support tickets.' }}
      </p>

      <!-- Error Details (expandable) -->
      <div v-if="showDetails && error?.details" class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
        <p class="text-sm font-mono text-gray-700 dark:text-gray-300 break-all">
          {{ error.details }}
        </p>
      </div>

      <!-- Actions -->
      <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button
          v-if="error?.canRetry"
          @click="$emit('retry')"
          class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
        >
          Try Again
        </button>
        
        <button
          @click="goToNova"
          class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200"
        >
          Back to Dashboard
        </button>
      </div>

      <!-- Toggle Details -->
      <button
        v-if="error?.details"
        @click="showDetails = !showDetails"
        class="mt-4 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
      >
        {{ showDetails ? 'Hide' : 'Show' }} technical details
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ErrorBoundary',
  
  props: {
    error: {
      type: Object,
      default: () => ({})
    }
  },
  
  emits: ['retry'],
  
  data() {
    return {
      showDetails: false
    }
  },
  
  methods: {
    goToNova() {
      window.location.href = '/nova'
    }
  }
}
</script>
