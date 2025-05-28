<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-xl shadow-gray-100 dark:shadow-gray-900/20 py-16 transition-all duration-300">
    <div class="flex flex-col justify-center items-center">
      <div class="relative mb-6">
        <!-- Outer Ring -->
        <div class="w-16 h-16 border-4 border-emerald-200 dark:border-emerald-800 rounded-full animate-pulse"></div>
        <!-- Inner Spinner -->
        <div class="absolute inset-0 w-16 h-16 border-4 border-transparent border-t-emerald-500 border-r-emerald-500 rounded-full animate-spin"></div>
        <!-- Center Dot -->
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="w-3 h-3 bg-emerald-500 rounded-full animate-bounce"></div>
        </div>
      </div>
      <div class="text-center">
        <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">{{ message }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400">Please wait while we load your data...</p>
      </div>
    </div>
  </div>
</template>

<script>
// Enhanced Spinner Icon Component
const SpinnerIcon = {
  template: `
    <div class="relative">
      <!-- Outer Ring -->
      <div class="w-12 h-12 border-4 border-emerald-200 dark:border-emerald-800 rounded-full animate-pulse"></div>
      <!-- Inner Spinner -->
      <div class="absolute inset-0 w-12 h-12 border-4 border-transparent border-t-emerald-500 border-r-emerald-500 rounded-full animate-spin"></div>
      <!-- Center Dot -->
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce"></div>
      </div>
    </div>
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
