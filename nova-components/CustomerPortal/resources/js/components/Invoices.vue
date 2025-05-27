<template>
  <div>
    <Heading class="mb-6">My Invoices</Heading>

    <!-- Action Bar -->
    <Card class="mb-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6">
        <div class="flex flex-col sm:flex-row gap-4">
          <!-- Search Input -->
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search invoices..."
              class="form-control form-input form-input-bordered w-full sm:w-64"
              @input="debouncedSearch"
            />
          </div>

          <!-- Status Filter -->
          <select
            v-model="statusFilter"
            @change="loadInvoices(1)"
            class="form-control form-select form-select-bordered w-full sm:w-48"
          >
            <option value="">All Statuses</option>
            <option value="draft">Draft</option>
            <option value="sent">Sent</option>
            <option value="paid">Paid</option>
            <option value="overdue">Overdue</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>

        <div class="text-sm text-80">
          {{ totalInvoices }} {{ totalInvoices === 1 ? 'invoice' : 'invoices' }} total
        </div>
      </div>
    </Card>

    <!-- Loading State -->
    <Card v-if="loading && invoices.length === 0" class="py-12">
      <div class="flex justify-center items-center">
        <Loader class="text-60" />
        <span class="ml-3 text-80">Loading invoices...</span>
      </div>
    </Card>

    <!-- Empty State -->
    <Card v-else-if="!loading && invoices.length === 0">
      <div class="flex flex-col items-center justify-center py-16 px-6">
        <svg class="w-16 h-16 text-60 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-semibold mb-2">No Invoices Found</h3>
        <p class="text-80 text-center mb-6 max-w-md">
          {{ searchQuery || statusFilter ? 'No invoices match your current filters.' : 'You don\'t have any invoices yet.' }}
        </p>
        <DefaultButton
          v-if="searchQuery || statusFilter"
          @click="clearFilters"
          type="button"
        >
          Clear Filters
        </DefaultButton>
      </div>
    </Card>

    <!-- Invoices Table -->
    <Card v-else class="overflow-hidden">
      <!-- Table Header -->
      <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-b border-20">
        <div class="grid grid-cols-6 gap-4 text-sm font-medium text-80">
          <div class="col-span-2">Invoice Number</div>
          <div>Date</div>
          <div>Due Date</div>
          <div>Status</div>
          <div class="text-right">Total</div>
          <div class="text-right">Actions</div>
        </div>
      </div>

      <!-- Table Body -->
      <div class="divide-y divide-20">
        <div
          v-for="invoice in invoices"
          :key="invoice.id"
          class="px-6 py-4 hover:bg-20 transition-colors duration-150"
        >
          <div class="grid grid-cols-6 gap-4 items-center">
            <div class="col-span-2">
              <div class="text-sm font-medium">
                {{ invoice.invoice_number }}
              </div>
            </div>
            <div>
              <div class="text-sm text-80">
                {{ formatDate(invoice.created_at) }}
              </div>
            </div>
            <div>
              <div class="text-sm text-80">
                {{ formatDate(invoice.due_date) }}
              </div>
            </div>
            <div>
              <Badge :type="getInvoiceBadgeType(invoice.status)">
                {{ formatStatus(invoice.status) }}
              </Badge>
            </div>
            <div class="text-right">
              <div class="text-sm font-medium">
                ${{ formatMoney(invoice.total) }}
              </div>
            </div>
            <div class="text-right">
              <div class="flex justify-end space-x-2">
                <DefaultButton
                  @click="viewInvoiceDetails(invoice)"
                  size="sm"
                  variant="ghost"
                >
                  View
                </DefaultButton>
                <DefaultButton
                  @click="downloadInvoice(invoice.id)"
                  size="sm"
                  variant="ghost"
                >
                  Download
                </DefaultButton>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 border-t border-20">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div class="text-sm text-80">
            Showing {{ ((pagination.current_page - 1) * pagination.per_page) + 1 }} to
            {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} of
            {{ pagination.total }} results
          </div>
          <div class="flex items-center space-x-2">
            <DefaultButton
              @click="loadInvoices(pagination.current_page - 1)"
              :disabled="pagination.current_page <= 1"
              size="sm"
              variant="ghost"
            >
              Previous
            </DefaultButton>
            <span class="px-3 py-1 text-sm text-80">
              Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </span>
            <DefaultButton
              @click="loadInvoices(pagination.current_page + 1)"
              :disabled="pagination.current_page >= pagination.last_page"
              size="sm"
              variant="ghost"
            >
              Next
            </DefaultButton>
          </div>
        </div>
      </div>

      <!-- Loading overlay for pagination -->
      <div v-if="loading && invoices.length > 0" class="absolute inset-0 bg-white dark:bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="flex items-center">
          <Loader class="text-60" />
          <span class="ml-3 text-80">Loading...</span>
        </div>
      </div>
    </Card>

    <!-- Invoice Details Modal -->
    <Modal
      v-if="showInvoiceModal"
      @modal-close="closeInvoiceModal"
      :show="showInvoiceModal"
      max-width="4xl"
    >
      <Card class="overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-20">
          <Heading :level="3">
            Invoice Details - #{{ selectedInvoice?.invoice_number }}
          </Heading>
          <button
            @click="closeInvoiceModal"
            class="text-60 hover:text-80 transition-colors duration-200"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <!-- Modal Content -->
        <div class="p-6">
          <!-- Invoice Summary -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <h4 class="text-sm font-medium mb-3">Invoice Information</h4>
              <dl class="space-y-2">
                <div class="flex justify-between">
                  <dt class="text-sm text-80">Invoice Number:</dt>
                  <dd class="text-sm font-medium">#{{ selectedInvoice?.invoice_number }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-80">Date:</dt>
                  <dd class="text-sm">{{ formatDate(selectedInvoice?.created_at) }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-80">Due Date:</dt>
                  <dd class="text-sm">{{ formatDate(selectedInvoice?.due_date) }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-80">Status:</dt>
                  <dd>
                    <Badge :type="getInvoiceBadgeType(selectedInvoice?.status)">
                      {{ formatStatus(selectedInvoice?.status) }}
                    </Badge>
                  </dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-80">Total:</dt>
                  <dd class="text-sm font-semibold">${{ formatMoney(selectedInvoice?.total) }}</dd>
                </div>
              </dl>
            </div>

            <div>
              <h4 class="text-sm font-medium mb-3">Payment Information</h4>
              <dl class="space-y-2">
                <div class="flex justify-between">
                  <dt class="text-sm text-80">Amount Paid:</dt>
                  <dd class="text-sm font-medium">${{ formatMoney(selectedInvoice?.amount_paid || 0) }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="text-sm text-80">Balance Due:</dt>
                  <dd class="text-sm font-medium">${{ formatMoney((selectedInvoice?.total || 0) - (selectedInvoice?.amount_paid || 0)) }}</dd>
                </div>
                <div v-if="selectedInvoice?.last_payment_date" class="flex justify-between">
                  <dt class="text-sm text-80">Last Payment:</dt>
                  <dd class="text-sm">{{ formatDate(selectedInvoice.last_payment_date) }}</dd>
                </div>
                <div class="mt-3 space-y-2">
                  <DefaultButton
                    @click="downloadInvoice(selectedInvoice.id)"
                    size="sm"
                    class="w-full"
                  >
                    Download PDF
                  </DefaultButton>
                  <DefaultButton
                    v-if="selectedInvoice?.status !== 'paid'"
                    @click="payInvoice(selectedInvoice.id)"
                    size="sm"
                    variant="primary"
                    class="w-full"
                  >
                    Pay Now
                  </DefaultButton>
                </div>
              </dl>
            </div>
          </div>

          <!-- Invoice Items -->
          <div v-if="selectedInvoice?.items?.length">
            <h4 class="text-sm font-medium mb-3">Invoice Items</h4>
            <div class="bg-20 rounded-lg p-4">
              <div class="space-y-3">
                <div
                  v-for="item in selectedInvoice.items"
                  :key="item.id"
                  class="bg-white dark:bg-gray-800 rounded-lg p-4 border-20"
                >
                  <div class="flex justify-between items-start">
                    <div class="flex-1">
                      <h5 class="text-sm font-medium">{{ item.description }}</h5>
                      <div class="flex items-center space-x-4 mt-2 text-xs text-80">
                        <span>Qty: {{ item.quantity }}</span>
                        <span>Rate: ${{ formatMoney(item.unit_price) }}</span>
                      </div>
                    </div>
                    <div class="text-right ml-4">
                      <div class="text-sm font-semibold">
                        ${{ formatMoney(item.total) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Invoice Notes -->
          <div v-if="selectedInvoice?.notes" class="mt-6">
            <h4 class="text-sm font-medium mb-3">Notes</h4>
            <div class="bg-20 rounded-lg p-4">
              <p class="text-sm text-80">{{ selectedInvoice.notes }}</p>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end px-6 py-4 border-t border-20">
          <DefaultButton
            @click="closeInvoiceModal"
            variant="ghost"
          >
            Close
          </DefaultButton>
        </div>
      </Card>
    </Modal>
  </div>
</template>

<script>
import { CustomerPortalAPI } from '../utils/helpers.js'
import {
  formatMoney,
  formatDate,
  formatTime
} from '../utils/helpers.js'

export default {
  name: 'Invoices',
  data() {
    return {
      invoices: [],
      loading: false,
      searchQuery: '',
      statusFilter: '',
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0
      },
      totalInvoices: 0,
      searchTimeout: null,

      // Modal state
      showInvoiceModal: false,
      selectedInvoice: null,
    }
  },

  computed: {
    debouncedSearch() {
      return () => {
        clearTimeout(this.searchTimeout)
        this.searchTimeout = setTimeout(() => {
          this.loadInvoices(1)
        }, 500)
      }
    }
  },

  mounted() {
    this.loadInvoices()
  },

  methods: {
    formatMoney,
    formatDate,
    formatTime,

    async loadInvoices(page = 1) {
      try {
        this.loading = true

        // Build filters object
        const filters = {}

        if (this.searchQuery.trim()) {
          filters.search = this.searchQuery.trim()
        }

        if (this.statusFilter) {
          filters.status = this.statusFilter
        }

        const response = await CustomerPortalAPI.getInvoices(page, filters)

        this.invoices = response.data || []
        this.pagination = response.meta || {}
        this.totalInvoices = response.meta?.total || 0

      } catch (error) {
        console.error('Error loading invoices:', error)
        console.error('Error details:', error.response?.data || error.message)

        // Show user-friendly error message
        if (error.response?.status === 401) {
          this.$toasted?.error('Authentication required. Please log in again.')
        } else if (error.response?.status === 403) {
          this.$toasted?.error('Access denied. You do not have permission to view invoices.')
        } else {
          this.$toasted?.error('Failed to load invoices. Please try again.')
        }

        // Reset data on error
        this.invoices = []
        this.pagination = { current_page: 1, last_page: 1, per_page: 10, total: 0 }
        this.totalInvoices = 0
      } finally {
        this.loading = false
      }
    },

    async viewInvoiceDetails(invoice) {
      this.selectedInvoice = invoice
      this.showInvoiceModal = true

      // Load full invoice details if needed
      try {
        const response = await CustomerPortalAPI.getInvoice(invoice.id)
        this.selectedInvoice = response.data || invoice
      } catch (error) {
        console.error('Error loading invoice details:', error)
        this.$toasted?.error('Failed to load invoice details')
      }
    },

    closeInvoiceModal() {
      this.showInvoiceModal = false
      this.selectedInvoice = null
    },

    async downloadInvoice(invoiceId) {
      try {
        this.$toasted?.info('Preparing invoice download...')
        const response = await CustomerPortalAPI.downloadInvoicePdf(invoiceId)

        // Handle PDF download
        if (response.data) {
          // Create download link
          const url = window.URL.createObjectURL(new Blob([response.data]))
          const link = document.createElement('a')
          link.href = url
          link.setAttribute('download', `invoice-${invoiceId}.pdf`)
          document.body.appendChild(link)
          link.click()
          link.remove()
          window.URL.revokeObjectURL(url)

          this.$toasted?.success('Invoice downloaded successfully')
        }
      } catch (error) {
        console.error('Error downloading invoice:', error)
        this.$toasted?.error('Failed to download invoice. Please try again.')
      }
    },

    async payInvoice(invoiceId) {
      // Placeholder for payment functionality
      this.$toasted?.info(`Payment processing for invoice #${invoiceId} - This feature will be implemented in a future update`)
    },

    clearFilters() {
      this.searchQuery = ''
      this.statusFilter = ''
      this.loadInvoices(1)
    },

    getInvoiceBadgeType(status) {
      const badgeTypes = {
        'draft': 'info',
        'sent': 'info',
        'paid': 'success',
        'overdue': 'danger',
        'cancelled': 'danger',
        'partial': 'warning',
      }
      return badgeTypes[status] || 'info'
    },

    formatStatus(status) {
      if (!status) return 'Unknown'
      return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ')
    },
  }
}
</script>
