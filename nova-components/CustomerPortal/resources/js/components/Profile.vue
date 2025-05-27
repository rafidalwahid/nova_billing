<template>
  <div>
    <Heading class="mb-6">My Profile</Heading>

    <!-- Loading State -->
    <Card v-if="loading" class="py-12">
      <div class="flex justify-center items-center">
        <Loader class="text-60" />
        <span class="ml-3 text-80">Loading profile...</span>
      </div>
    </Card>

    <!-- Profile Content -->
    <div v-else class="space-y-6">
      <!-- Profile Information -->
      <Card>
        <div class="px-6 py-4 border-b border-20">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium">Profile Information</h3>
            <DefaultButton
              @click="editMode = !editMode"
              size="sm"
              :variant="editMode ? 'ghost' : 'primary'"
            >
              {{ editMode ? 'Cancel' : 'Edit Profile' }}
            </DefaultButton>
          </div>
        </div>
        <div class="p-6">
          <form v-if="editMode" @submit.prevent="updateProfile" class="space-y-6">
            <!-- Personal Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium mb-2">First Name</label>
                <input
                  v-model="profileForm.first_name"
                  type="text"
                  class="form-control form-input form-input-bordered w-full"
                  required
                />
              </div>
              <div>
                <label class="block text-sm font-medium mb-2">Last Name</label>
                <input
                  v-model="profileForm.last_name"
                  type="text"
                  class="form-control form-input form-input-bordered w-full"
                  required
                />
              </div>
              <div>
                <label class="block text-sm font-medium mb-2">Email Address</label>
                <input
                  v-model="profileForm.email"
                  type="email"
                  class="form-control form-input form-input-bordered w-full"
                  required
                />
              </div>
              <div>
                <label class="block text-sm font-medium mb-2">Phone Number</label>
                <input
                  v-model="profileForm.phone"
                  type="tel"
                  class="form-control form-input form-input-bordered w-full"
                />
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-2">Company Name</label>
                <input
                  v-model="profileForm.company_name"
                  type="text"
                  class="form-control form-input form-input-bordered w-full"
                />
              </div>
            </div>

            <!-- Address Information -->
            <div class="border-t border-20 pt-6">
              <h4 class="text-md font-medium mb-4">Address Information</h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium mb-2">Street Address</label>
                  <input
                    v-model="profileForm.address"
                    type="text"
                    class="form-control form-input form-input-bordered w-full"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-2">City</label>
                  <input
                    v-model="profileForm.city"
                    type="text"
                    class="form-control form-input form-input-bordered w-full"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-2">State/Province</label>
                  <input
                    v-model="profileForm.state"
                    type="text"
                    class="form-control form-input form-input-bordered w-full"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-2">Country</label>
                  <input
                    v-model="profileForm.country"
                    type="text"
                    class="form-control form-input form-input-bordered w-full"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-2">Postal Code</label>
                  <input
                    v-model="profileForm.postal_code"
                    type="text"
                    class="form-control form-input form-input-bordered w-full"
                  />
                </div>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-20">
              <DefaultButton
                @click="editMode = false"
                type="button"
                variant="ghost"
              >
                Cancel
              </DefaultButton>
              <DefaultButton
                type="submit"
                variant="primary"
                :disabled="updating"
              >
                {{ updating ? 'Updating...' : 'Update Profile' }}
              </DefaultButton>
            </div>
          </form>

          <!-- Read-only Profile Display -->
          <div v-else class="space-y-6">
            <!-- Personal Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-80 mb-1">First Name</label>
                <p class="text-sm">{{ profile.customer?.first_name || 'Not provided' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-80 mb-1">Last Name</label>
                <p class="text-sm">{{ profile.customer?.last_name || 'Not provided' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-80 mb-1">Email Address</label>
                <p class="text-sm">{{ profile.user?.email || 'Not provided' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-80 mb-1">Phone Number</label>
                <p class="text-sm">{{ profile.customer?.phone || 'Not provided' }}</p>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-80 mb-1">Company Name</label>
                <p class="text-sm">{{ profile.customer?.company_name || 'Not provided' }}</p>
              </div>
            </div>

            <!-- Address Information -->
            <div class="border-t border-20 pt-6">
              <h4 class="text-md font-medium mb-4">Address Information</h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-80 mb-1">Street Address</label>
                  <p class="text-sm">{{ profile.customer?.address || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-80 mb-1">City</label>
                  <p class="text-sm">{{ profile.customer?.city || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-80 mb-1">State/Province</label>
                  <p class="text-sm">{{ profile.customer?.state || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-80 mb-1">Country</label>
                  <p class="text-sm">{{ profile.customer?.country || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-80 mb-1">Postal Code</label>
                  <p class="text-sm">{{ profile.customer?.postal_code || 'Not provided' }}</p>
                </div>
              </div>
            </div>

            <!-- Account Information -->
            <div class="border-t border-20 pt-6">
              <h4 class="text-md font-medium mb-4">Account Information</h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-80 mb-1">Account Status</label>
                  <Badge :type="profile.customer?.status ? 'success' : 'danger'">
                    {{ profile.customer?.status ? 'Active' : 'Inactive' }}
                  </Badge>
                </div>
                <div>
                  <label class="block text-sm font-medium text-80 mb-1">Member Since</label>
                  <p class="text-sm">{{ formatDate(profile.customer?.created_at) }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-80 mb-1">Last Login</label>
                  <p class="text-sm">{{ formatDate(profile.customer?.last_login) || 'Never' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Card>

      <!-- Password Change -->
      <Card>
        <div class="px-6 py-4 border-b border-20">
          <h3 class="text-lg font-medium">Change Password</h3>
        </div>
        <div class="p-6">
          <form @submit.prevent="changePassword" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium mb-2">Current Password</label>
                <input
                  v-model="passwordForm.current_password"
                  type="password"
                  class="form-control form-input form-input-bordered w-full"
                  required
                />
              </div>
              <div></div>
              <div>
                <label class="block text-sm font-medium mb-2">New Password</label>
                <input
                  v-model="passwordForm.new_password"
                  type="password"
                  class="form-control form-input form-input-bordered w-full"
                  required
                />
              </div>
              <div>
                <label class="block text-sm font-medium mb-2">Confirm New Password</label>
                <input
                  v-model="passwordForm.new_password_confirmation"
                  type="password"
                  class="form-control form-input form-input-bordered w-full"
                  required
                />
              </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-20">
              <DefaultButton
                type="submit"
                variant="primary"
                :disabled="changingPassword"
              >
                {{ changingPassword ? 'Changing Password...' : 'Change Password' }}
              </DefaultButton>
            </div>
          </form>
        </div>
      </Card>
    </div>
  </div>
</template>

<script>
import { CustomerPortalAPI } from '../utils/helpers.js'
import {
  formatDate,
  formatTime
} from '../utils/helpers.js'

export default {
  name: 'Profile',
  data() {
    return {
      profile: {
        user: {},
        customer: {}
      },
      loading: false,
      editMode: false,
      updating: false,
      changingPassword: false,

      // Profile form data
      profileForm: {
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        company_name: '',
        address: '',
        city: '',
        state: '',
        country: '',
        postal_code: '',
      },

      // Password form data
      passwordForm: {
        current_password: '',
        new_password: '',
        new_password_confirmation: '',
      },
    }
  },

  mounted() {
    this.loadProfile()
  },

  methods: {
    formatDate,
    formatTime,

    async loadProfile() {
      try {
        this.loading = true
        const response = await CustomerPortalAPI.getProfile()
        this.profile = response.data || { user: {}, customer: {} }

        // Populate form with current data
        this.populateProfileForm()

      } catch (error) {
        console.error('Error loading profile:', error)
        console.error('Error details:', error.response?.data || error.message)

        // Show user-friendly error message
        if (error.response?.status === 401) {
          this.$toasted?.error('Authentication required. Please log in again.')
        } else if (error.response?.status === 403) {
          this.$toasted?.error('Access denied. You do not have permission to view profile.')
        } else {
          this.$toasted?.error('Failed to load profile. Please try again.')
        }

        // Reset data on error
        this.profile = { user: {}, customer: {} }
      } finally {
        this.loading = false
      }
    },

    populateProfileForm() {
      this.profileForm = {
        first_name: this.profile.customer?.first_name || '',
        last_name: this.profile.customer?.last_name || '',
        email: this.profile.user?.email || '',
        phone: this.profile.customer?.phone || '',
        company_name: this.profile.customer?.company_name || '',
        address: this.profile.customer?.address || '',
        city: this.profile.customer?.city || '',
        state: this.profile.customer?.state || '',
        country: this.profile.customer?.country || '',
        postal_code: this.profile.customer?.postal_code || '',
      }
    },

    async updateProfile() {
      try {
        this.updating = true

        const response = await CustomerPortalAPI.updateProfile(this.profileForm)

        if (response.success) {
          this.$toasted?.success('Profile updated successfully!')
          this.profile = response.data || this.profile
          this.editMode = false
        } else {
          this.$toasted?.error(response.message || 'Failed to update profile')
        }

      } catch (error) {
        console.error('Error updating profile:', error)
        console.error('Error details:', error.response?.data || error.message)

        // Show user-friendly error message
        if (error.response?.status === 422) {
          const errors = error.response.data.errors || {}
          const firstError = Object.values(errors)[0]?.[0]
          this.$toasted?.error(firstError || 'Validation error occurred')
        } else if (error.response?.status === 401) {
          this.$toasted?.error('Authentication required. Please log in again.')
        } else if (error.response?.status === 403) {
          this.$toasted?.error('Access denied. You do not have permission to update profile.')
        } else {
          this.$toasted?.error('Failed to update profile. Please try again.')
        }
      } finally {
        this.updating = false
      }
    },

    async changePassword() {
      try {
        // Validate password confirmation
        if (this.passwordForm.new_password !== this.passwordForm.new_password_confirmation) {
          this.$toasted?.error('New password and confirmation do not match')
          return
        }

        this.changingPassword = true

        const response = await CustomerPortalAPI.changePassword(this.passwordForm)

        if (response.success) {
          this.$toasted?.success('Password changed successfully!')

          // Clear form
          this.passwordForm = {
            current_password: '',
            new_password: '',
            new_password_confirmation: '',
          }
        } else {
          this.$toasted?.error(response.message || 'Failed to change password')
        }

      } catch (error) {
        console.error('Error changing password:', error)
        console.error('Error details:', error.response?.data || error.message)

        // Show user-friendly error message
        if (error.response?.status === 422) {
          const errors = error.response.data.errors || {}
          const firstError = Object.values(errors)[0]?.[0]
          this.$toasted?.error(firstError || 'Validation error occurred')
        } else if (error.response?.status === 401) {
          this.$toasted?.error('Current password is incorrect')
        } else if (error.response?.status === 403) {
          this.$toasted?.error('Access denied. You do not have permission to change password.')
        } else {
          this.$toasted?.error('Failed to change password. Please try again.')
        }
      } finally {
        this.changingPassword = false
      }
    },
  }
}
</script>
