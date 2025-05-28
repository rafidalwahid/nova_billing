<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-lg py-12">
    <div class="flex justify-center items-center">
      <div class="flex items-center">
        <SpinnerIcon />
        <span class="ml-3 text-gray-600 dark:text-gray-400">{{ message }}</span>
      </div>
    </div>
  </div>
</template>

<script>
// Spinner Icon Component
const SpinnerIcon = {
  template: `
    <svg class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
  `
}

export default {
  name: 'LoadingSpinner',

  components: {
    SpinnerIcon
  },

  props: {
    message: {
      type: String,
      default: 'Loading...',
      validator: (value) => typeof value === 'string'
    }
  }
}
</script>
