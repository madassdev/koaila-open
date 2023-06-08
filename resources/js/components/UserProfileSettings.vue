<template>
  <div class="space-y-12">
    <form class="w-full" :action="routes.personal_info" method="post">
      <input type="hidden" name="_token" :value="csrfToken" />
      <div class="flex items-center justify-between">
        <p class="text-2xl font-bold">Profile Information</p>
      </div>
      <hr class="my-2" />
      <div class="space-y-4 w-2/3 mt-6">
        <div class="flex items-center">
          <label for="name" class="w-60 font-bold"> Name: </label>
          <p class="text-gray-600" v-if="!isEditingProfileInfo">
            {{ user.name }}
          </p>
          <div v-else class="flex-1">
            <input
              id="name"
              type="text"
              class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5"
              :class="errors?.name?.length && 'is-invalid'"
              name="name"
              v-model="name"
              required
              autocomplete="name"
              :autofocus="true"
            />
          </div>
        </div>
        <div class="flex items-center">
          <label for="company_name" class="w-60 font-bold">
            Company name:
          </label>
          <p class="text-gray-600" v-if="!isEditingProfileInfo">
            {{ user.company_name }}
          </p>
          <div v-else class="flex-1">
            <input
              id="company_name"
              type="text"
              class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5"
              :class="errors?.company_name?.length && 'is-invalid'"
              name="company_name"
              v-model="companyName"
              required
              autocomplete="company_name"
              :autofocus="true"
            />
          </div>
        </div>
        <div class="space-x-4 w-full">
          <div class="w-60"></div>
          <div class="flex-1 flex items-center justify-end">
            <button
              type="button"
              @click="isEditingProfileInfo = true"
              v-if="!isEditingProfileInfo"
              class="border border-gray-600 p-2 rounded py-1"
            >
              Edit
            </button>
            <div class="space-x-4" v-else>
              <button
                type="button"
                @click="isEditingProfileInfo = false"
                class="border border-gray-600 p-2 rounded py-1"
              >
                Cancel
              </button>
              <button class="bg-blue-700 text-white p-2 rounded py-1">
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <hr class="" />
    <form class="" :action="routes.email" method="post">
      <input type="hidden" name="_token" :value="csrfToken" />
      <div class="space-y-4 w-2/3">
        <div class="flex items-center">
          <label for="name" class="w-60 font-bold"> Email: </label>
          <p class="text-gray-600" v-if="!isEditingEmail">
            {{ user.email }}
          </p>
          <div v-else class="flex-1 space-y-2">
            <div class="space-y-1">
              <label> Current email </label>
              <input
                id="current_email"
                type="email"
                class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5"
                :class="errors?.current_email?.length && 'is-invalid'"
                name="current_email"
                v-model="currentEmail"
                :required="true"
                autofocus
              />
            </div>
            <div class="space-y-1">
              <label> New email </label>
              <input
                id="new_email"
                type="email"
                class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5"
                :class="errors?.new_email?.length && 'is-invalid'"
                name="new_email"
                v-model="newEmail"
                :required="true"
              />
            </div>
          </div>
        </div>
        <div class="space-x-4 w-full">
          <div class="w-60"></div>
          <div class="flex-1 flex items-center justify-end">
            <button
              type="button"
              @click="isEditingEmail = true"
              v-if="!isEditingEmail"
              class="border border-gray-600 p-2 rounded py-1"
            >
              Edit
            </button>
            <div class="space-x-4" v-else>
              <button
                type="button"
                @click="isEditingEmail = false"
                class="border border-gray-600 p-2 rounded py-1"
              >
                Cancel
              </button>
              <button class="bg-blue-700 text-white p-2 rounded py-1">
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <hr />
    <form class="w-full" :action="routes.password" method="post">
      <input type="hidden" name="_token" :value="csrfToken" />
      <div class="space-y-4 w-2/3 mt-6">
        <div class="flex">
          <label for="name" class="w-60 font-bold"> Password: </label>
          <p class="text-gray-600 text-lg font-bold" v-if="!isEditingPassword">
            * * * * * * * *
          </p>
          <div v-else class="flex-1 space-y-2">
            <div class="space-y-1">
              <label>Current password</label>
              <input
                id="current_password"
                type="password"
                class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5"
                :class="errors?.current_password?.length && 'is-invalid'"
                name="current_password"
                v-model="currentPassword"
                required
                :autofocus="true"
              />
            </div>
            <div class="space-y-1">
              <label>New password</label>
              <input
                id="new_password"
                type="password"
                class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5"
                :class="errors?.new_password?.length && 'is-invalid'"
                name="new_password"
                v-model="newPassword"
                required
              />
            </div>
            <div class="space-y-1">
              <label>Confirm password</label>
              <input
                id="new_password_confirmation"
                type="password"
                class="form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5"
                :class="
                  errors?.new_password_confirmation?.length && 'is-invalid'
                "
                name="new_password_confirmation"
                v-model="confirmPassword"
                required
              />
            </div>
          </div>
        </div>
        <div class="space-x-4 w-full">
          <div class="w-60"></div>
          <div class="flex-1 flex items-center justify-end">
            <button
              type="button"
              @click="isEditingPassword = true"
              v-if="!isEditingPassword"
              class="border border-gray-600 p-2 rounded py-1"
            >
              Edit
            </button>
            <div class="space-x-4" v-else>
              <button
                type="button"
                @click="isEditingPassword = false"
                class="border border-gray-600 p-2 rounded py-1"
              >
                Cancel
              </button>
              <button class="bg-blue-700 text-white p-2 rounded py-1">
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  props: {
    user: Object,
    errors: Object,
    routes: Object,
    oldValues: Object,
  },

  data() {
    return {
      name: this.user.name,
      currentEmail: "",
      newEmail: "",
      companyName: this.user.company_name,
      currentPassword: "",
      newPassword: "",
      confirmPassword: "",
      isEditingProfileInfo: false,
      isEditingEmail: false,
      isEditingPassword: false,
      csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },

  mounted() {
    // Check if there are any errors related to profile info (name or company_name).
    if (
      this.errors.hasOwnProperty("name") ||
      this.errors.hasOwnProperty("company_name")
    ) {
      // Set isEditingProfileInfo flag to true.
      this.isEditingProfileInfo = true;

      // Set the name and companyName values to the old values.
      this.name = this.oldValues.name;
      this.companyName = this.oldValues.company_name;
    }

    // Check if there are any errors related to email (current_email or new_email).
    if (
      this.errors.hasOwnProperty("current_email") ||
      this.errors.hasOwnProperty("new_email")
    ) {
      // Set isEditingEmail flag to true.
      this.isEditingEmail = true;

      // Set the currentEmail and newEmail values to the old values.
      this.currentEmail = this.oldValues.current_email;
      this.newEmail = this.oldValues.new_email;
    }

    // Check if there are any errors related to password (current_password or new_password).
    if (
      this.errors.hasOwnProperty("current_password") ||
      this.errors.hasOwnProperty("new_password")
    ) {
      // Set isEditingPassword flag to true.
      this.isEditingPassword = true;
    }
  },
};
</script>