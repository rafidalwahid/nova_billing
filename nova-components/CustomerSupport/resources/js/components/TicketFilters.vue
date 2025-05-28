<template>
  <div class="mb-4 sm:mb-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6">
      <h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-2 sm:mb-4">
        Support Tickets
      </h1>
      <p v-if="totalTickets > 0" class="text-sm text-gray-600 dark:text-gray-400">
        {{ totalTickets }} {{ totalTickets === 1 ? 'ticket' : 'tickets' }} found
      </p>
    </div>

    <!-- Filters Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 p-4 sm:p-6 shadow-sm">
      <!-- Mobile Layout -->
      <div class="sm:hidden space-y-4">
        <SearchInput
          :modelValue="searchQuery"
          @update:modelValue="$emit('update:searchQuery', $event)"
          @input="$emit('search')"
        />
        <div class="flex gap-3">
          <FilterDropdown
            v-model="showFilters"
            :statusFilter="statusFilter"
            :departmentFilter="departmentFilter"
            @update:statusFilter="$emit('update:statusFilter', $event)"
            @update:departmentFilter="$emit('update:departmentFilter', $event)"
            @filterChange="$emit('filterChange')"
          />
          <CreateButton @click="$emit('createTicket')" />
        </div>
      </div>

      <!-- Desktop Layout -->
      <div class="hidden sm:flex items-center justify-between gap-6">
        <div class="flex items-center gap-4 flex-1">
          <SearchInput
            :modelValue="searchQuery"
            @update:modelValue="$emit('update:searchQuery', $event)"
            @input="$emit('search')"
            class="max-w-md"
          />
          <FilterDropdown
            v-model="showFilters"
            :statusFilter="statusFilter"
            :departmentFilter="departmentFilter"
            @update:statusFilter="$emit('update:statusFilter', $event)"
            @update:departmentFilter="$emit('update:departmentFilter', $event)"
            @filterChange="$emit('filterChange')"
          />
        </div>
        <CreateButton @click="$emit('createTicket')" />
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import Icon from './Icon.vue'
import { useTicketHelpers } from '../composables/useTicketHelpers.js'

// Sub-components for better organization
const SearchInput = {
  template: `
    <div class="relative">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <Icon name="Search" />
      </div>
      <input
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        type="text"
        placeholder="Search tickets..."
        class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
      />
    </div>
  `,
  props: ['modelValue'],
  emits: ['update:modelValue', 'input'],
  components: { Icon }
}

const FilterDropdown = {
  template: `
    <div class="relative">
      <button
        @click="$emit('update:modelValue', !modelValue)"
        class="inline-flex items-center gap-2 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200"
      >
        <Icon name="Filter" />
        <span>Filter</span>
        <span v-if="hasActiveFilters" class="w-2 h-2 bg-blue-500 rounded-full"></span>
      </button>

      <div
        v-if="modelValue"
        class="absolute left-0 sm:right-0 sm:left-auto mt-2 w-72 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl shadow-xl z-20 p-4 space-y-4"
      >
        <FilterSelect
          label="Status"
          :value="statusFilter"
          :options="statusOptions"
          @change="$emit('update:statusFilter', $event); $emit('filterChange')"
        />
        <FilterSelect
          label="Department"
          :value="departmentFilter"
          :options="departmentOptions"
          @change="$emit('update:departmentFilter', $event); $emit('filterChange')"
        />
      </div>
    </div>
  `,
  props: ['modelValue', 'statusFilter', 'departmentFilter'],
  emits: ['update:modelValue', 'update:statusFilter', 'update:departmentFilter', 'filterChange'],
  computed: {
    hasActiveFilters() {
      return this.statusFilter || this.departmentFilter
    },
    statusOptions() {
      return [
        { value: '', label: 'All Statuses' },
        { value: 'open', label: 'Open' },
        { value: 'waiting_customer', label: 'Waiting for Response' },
        { value: 'resolved', label: 'Resolved' },
        { value: 'closed', label: 'Closed' }
      ]
    },
    departmentOptions() {
      return [
        { value: '', label: 'All Departments' },
        { value: 'billing', label: 'Billing Support' },
        { value: 'technical', label: 'Technical Support' },
        { value: 'sales', label: 'Sales Inquiry' },
        { value: 'general', label: 'General Support' }
      ]
    }
  },
  components: { Icon }
}

const FilterSelect = {
  template: `
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        {{ label }}
      </label>
      <select
        :value="value"
        @change="$emit('change', $event.target.value)"
        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
      >
        <option v-for="option in options" :key="option.value" :value="option.value">
          {{ option.label }}
        </option>
      </select>
    </div>
  `,
  props: ['label', 'value', 'options'],
  emits: ['change']
}

const CreateButton = {
  template: `
    <button
      @click="$emit('click')"
      class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-sm whitespace-nowrap"
    >
      <Icon name="Plus" />
      <span class="hidden sm:inline">Create Support Ticket</span>
      <span class="sm:hidden">Create</span>
    </button>
  `,
  emits: ['click'],
  components: { Icon }
}

export default {
  name: 'TicketFilters',

  components: {
    Icon,
    SearchInput,
    FilterDropdown,
    FilterSelect,
    CreateButton
  },

  props: {
    searchQuery: { type: String, default: '' },
    statusFilter: { type: String, default: '' },
    departmentFilter: { type: String, default: '' },
    totalTickets: { type: Number, default: 0 },
    loading: { type: Boolean, default: false }
  },

  emits: [
    'update:searchQuery',
    'update:statusFilter',
    'update:departmentFilter',
    'createTicket',
    'search',
    'filterChange'
  ],

  setup() {
    const showFilters = ref(false)
    const { statusConfig, departmentConfig } = useTicketHelpers()

    return {
      showFilters,
      statusConfig,
      departmentConfig
    }
  }
}
</script>
