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
          <label for="name" class="w-60 font-bold"> Name </label>
          <div class="flex-1">
            <InputField
              id="name"
              type="text"
              :value="name"
              :isError="errors?.name?.length"
              name="name"
              :required="true"
            />
          </div>
        </div>
        <div class="flex items-center">
          <label for="company_name" class="w-60 font-bold">
            Company name
          </label>
          <div class="flex-1">
            <InputField
              id="company_name"
              :type="text"
              :value="companyName"
              :isError="errors?.company_name?.length"
              name="company_name"
              :required="true"
            />
          </div>
        </div>
        <div class="flex">
          <label for="email" class="w-60 font-bold"> Email address </label>
          <div class="flex-1">
            <InputField
              id="email"
              type="email"
              :isError="errors?.current_email?.length"
              name="email"
              :required="true"
              :value="currentEmail"
            />
          </div>
        </div>
        <div class="space-x-4 w-full">
          <div class="w-60"></div>
          <div class="flex-1 flex items-center justify-end">
            <div class="space-x-4">
              <button class="bg-blue-700 text-white p-2 rounded px-4">
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <form class="w-full" :action="routes.password" method="post">
      <div class="flex justify-between">
        <p class="text-2xl font-bold">Password</p>
      </div>
      <hr class="my-2" />
      <input type="hidden" name="_token" :value="csrfToken" />
      <div class="space-y-4 w-2/3 mt-6">
        <div class="flex">
          <label class="w-60 font-bold">Password</label>
          <button
            v-if="!isEditingPassword"
            type="button"
            @click="isEditingPassword = true"
            class="border border-gray-600 rounded p-2 px-4"
          >
            Change password
          </button>
          <div v-else class="flex-1 space-y-2">
            <div class="space-y-1">
              <label for="current_password" class="font-bold">
                Current password
              </label>
              <InputField
                id="current_password"
                type="password"
                :isError="errors?.current_password?.length"
                name="current_password"
                :required="true"
                :value="currentPassword"
              />
            </div>
            <div class="space-y-1">
              <label for="new_password" class="font-bold">New password</label>
              <InputField
                id="new_password"
                type="password"
                :isError="errors?.new_password?.length"
                name="new_password"
                :required="true"
                :value="newPassword"
              />
            </div>
            <div class="space-y-1">
              <label for="new_password_confirmation" class="font-bold"
                >Confirm password</label
              >
              <InputField
                id="new_password_confirmation"
                type="password"
                :isError="errors?.new_password_confirmation?.length"
                name="new_password_confirmation"
                :required="true"
                :value="confirmPassword"
              />
            </div>
            <div class="space-x-4 w-full pt-4">
              <div class="w-60"></div>
              <div class="flex-1 flex items-center justify-end">
                <div class="space-x-4">
                  <button
                    type="button"
                    @click="isEditingPassword = false"
                    class="border border-gray-600 rounded p-2 px-4"
                  >
                    Cancel
                  </button>
                  <button class="bg-blue-700 text-white p-2 rounded px-4">
                    Change password
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import InputField from "@/components/InputField.vue";
export default {
  components: {
    InputField,
  },
  props: {
    user: Object,
    errors: Object,
    routes: Object,
    oldValues: Object,
  },

  data() {
    return {
      name: this.user.name,
      currentEmail: this.user.email,
      newEmail: "",
      companyName: this.user.company_name,
      currentPassword: "",
      newPassword: "",
      confirmPassword: "",
      isEditingProfileInfo: true,
      isEditingEmail: true,
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
      // Set the name and companyName values to the old values.
      this.name = this.oldValues.name;
      this.companyName = this.oldValues.company_name;
    }

    // Check if there are any errors related to email (current_email or new_email).
    if (
      this.errors.hasOwnProperty("current_email") ||
      this.errors.hasOwnProperty("new_email")
    ) {
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