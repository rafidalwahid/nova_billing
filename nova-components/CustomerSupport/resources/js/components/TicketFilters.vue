<template>
  <div class="mb-4 sm:mb-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6">
      <h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-2 sm:mb-4">
        Support Tickets
      </h1>
    </div>

    <!-- Search, Filters and Create Button - Responsive Layout -->
    <div class="space-y-4 lg:space-y-0">
      <!-- Mobile/Tablet: Stacked Layout -->
      <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 lg:hidden">
        <!-- Search -->
        <div class="relative flex-1">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <SearchIcon />
          </div>
          <input
            :value="searchQuery"
            @input="$emit('update:searchQuery', $event.target.value)"
            type="text"
            placeholder="Search tickets..."
            class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm sm:text-base"
          />
        </div>

        <!-- Filter and Create Button Row -->
        <div class="flex gap-3 sm:gap-4">
          <!-- Filter Button -->
          <div class="relative flex-1 sm:flex-none">
            <button
              @click="showFilters = !showFilters"
              class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 text-sm sm:text-base font-medium"
            >
              <FilterIcon />
              <span>Filter</span>
            </button>

            <!-- Filter Dropdown -->
            <div
              v-if="showFilters"
              class="absolute left-0 sm:right-0 sm:left-auto mt-2 w-72 sm:w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl shadow-xl z-20"
            >
              <div class="p-4 sm:p-6 space-y-4">
                <!-- Status Filter -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                  <select
                    :value="statusFilter"
                    @change="$emit('update:statusFilter', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                  >
                    <option
                      v-for="option in statusOptions"
                      :key="option.value"
                      :value="option.value"
                    >
                      {{ option.label }}
                    </option>
                  </select>
                </div>

                <!-- Department Filter -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                  <select
                    :value="departmentFilter"
                    @change="$emit('update:departmentFilter', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                  >
                    <option
                      v-for="option in departmentOptions"
                      :key="option.value"
                      :value="option.value"
                    >
                      {{ option.label }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Create Button Mobile/Tablet -->
          <button
            @click="$emit('createTicket')"
            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg create-ticket-btn text-sm sm:text-base"
          >
            <PlusIcon />
            <span class="hidden xs:inline">Create Support Ticket</span>
            <span class="xs:hidden">Create</span>
          </button>
        </div>
      </div>

      <!-- Desktop: Horizontal Layout -->
      <div class="hidden lg:flex items-center gap-4 justify-between w-full min-h-[44px] filters-container">
        <!-- Left Side: Search and Filter -->
        <div class="flex items-center gap-4 flex-shrink-0 filters-left">
          <!-- Search -->
          <div class="relative w-80 xl:w-96">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <SearchIcon />
            </div>
            <input
              :value="searchQuery"
              @input="$emit('update:searchQuery', $event.target.value)"
              type="text"
              placeholder="Search tickets..."
              class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
            />
          </div>

          <!-- Filter Button -->
          <div class="relative">
            <button
              @click="showFilters = !showFilters"
              class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200"
            >
              <FilterIcon />
              <span>Filter</span>
            </button>

            <!-- Filter Dropdown Desktop -->
            <div
              v-if="showFilters"
              class="absolute left-0 mt-2 w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg z-10"
            >
              <div class="p-4 space-y-4">
                <!-- Status Filter -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                  <select
                    :value="statusFilter"
                    @change="$emit('update:statusFilter', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  >
                    <option
                      v-for="option in statusOptions"
                      :key="option.value"
                      :value="option.value"
                    >
                      {{ option.label }}
                    </option>
                  </select>
                </div>

                <!-- Department Filter -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                  <select
                    :value="departmentFilter"
                    @change="$emit('update:departmentFilter', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  >
                    <option
                      v-for="option in departmentOptions"
                      :key="option.value"
                      :value="option.value"
                    >
                      {{ option.label }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Side: Create Ticket Button Desktop -->
        <div class="flex-shrink-0 filters-right">
          <button
            @click="$emit('createTicket')"
            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition-all duration-200 whitespace-nowrap shadow-sm border-0 relative z-10 create-ticket-btn"
          >
            <PlusIcon />
            Create Support Ticket
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

// Icon Components
const PlusIcon = {
  template: `
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
  `
}

const SearchIcon = {
  template: `
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
  `
}

const FilterIcon = {
  template: `
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
    </svg>
  `
}

export default {
  name: 'TicketFilters',

  components: {
    PlusIcon,
    SearchIcon,
    FilterIcon
  },

  props: {
    searchQuery: {
      type: String,
      default: '',
      validator: (value) => typeof value === 'string'
    },
    statusFilter: {
      type: String,
      default: '',
      validator: (value) => typeof value === 'string'
    },
    departmentFilter: {
      type: String,
      default: '',
      validator: (value) => typeof value === 'string'
    },
    totalTickets: {
      type: Number,
      default: 0,
      validator: (value) => typeof value === 'number' && value >= 0
    }
  },

  emits: {
    'update:searchQuery': (value) => typeof value === 'string',
    'update:statusFilter': (value) => typeof value === 'string',
    'update:departmentFilter': (value) => typeof value === 'string',
    'createTicket': null
  },

  setup() {
    const showFilters = ref(false)

    // Filter options
    const statusOptions = [
      { value: '', label: 'All Statuses' },
      { value: 'open', label: 'Open' },
      { value: 'waiting_customer', label: 'Waiting for Your Response' },
      { value: 'resolved', label: 'Resolved' },
      { value: 'closed', label: 'Closed' }
    ]

    const departmentOptions = [
      { value: '', label: 'All Departments' },
      { value: 'billing', label: 'Billing Support' },
      { value: 'technical', label: 'Technical Support' },
      { value: 'sales', label: 'Sales Inquiry' },
      { value: 'general', label: 'General Support' }
    ]

    return {
      showFilters,
      statusOptions,
      departmentOptions
    }
  }
}
</script>

<style scoped>
/* Ensure create button is always visible in both light and dark modes */
.filters-container .filters-right .create-ticket-btn {
  background-color: #10b981 !important;
  color: white !important;
  border: none !important;
  display: inline-flex !important;
  visibility: visible !important;
  opacity: 1 !important;
  position: relative !important;
  z-index: 10 !important;
  min-width: auto !important;
  max-width: none !important;
  width: auto !important;
  height: auto !important;
  min-height: 44px !important;
}

.filters-container .filters-right .create-ticket-btn:hover {
  background-color: #059669 !important;
  color: white !important;
}

.filters-container .filters-right .create-ticket-btn:focus {
  background-color: #059669 !important;
  color: white !important;
  outline: 2px solid #10b981 !important;
  outline-offset: 2px !important;
}

/* Ensure the container is always visible */
.filters-container {
  display: flex !important;
  width: 100% !important;
  align-items: center !important;
  justify-content: space-between !important;
  min-height: 44px !important;
}

.filters-left {
  display: flex !important;
  align-items: center !important;
  flex-shrink: 0 !important;
}

.filters-right {
  display: flex !important;
  flex-shrink: 0 !important;
  align-items: center !important;
}

/* Override any Nova styles that might hide the button */
.filters-right button {
  display: inline-flex !important;
  visibility: visible !important;
  opacity: 1 !important;
}
</style>
