<template>
  <div class="my-4">
    <div class="mb-4 flex items-center justify-between">
      <div class="">
        <p class="font-bold text-2xl">Organization settings</p>
        <p class="text-gray-500 text-xs">
          Manage your organization members and settings here.
        </p>
      </div>

      <button @click="createOrganizationModal = true"
        class="rounded p-2 px-4 border border-gray-300 bg-white flex items-center space-x-2">
        <Cog8 class="w-4 h-4" />
        <span>Change settings</span>
      </button>
    </div>

    <div class="p-3 rounded-xl shadow-sm bg-white">
      <div class="mb-4 flex items-center justify-between">
        <div class="">
          <p class="font-bold text-xl">Members in your oganization</p>
          <p class="text-xs">
            These are the members in your organization, you can edit, delete and add new member.
          </p>
        </div>
        <button @click="addMemberToOrganization" v-if="user.organization_id"
          class="rounded p-2 px-4 bg-blue-600 text-white flex items-center space-x-2">
          <span>
            Add member
          </span>
          <Plus class="w-4 h-4" />
        </button>
      </div>
      <table class="w-full border text-sm text-left text-gray-500">
        <thead>
          <tr>
            <th scope="col" :class="tableHeaderStyle" v-for="(headerName, index) in tableHeaderNames" :key="index">
              {{ headerName }}
            </th>

          </tr>
        </thead>

        <!-- Empty data -->
        <template v-if="members.length === 0">
          <tr>
            <td colspan="4" class="p-5 ">
              <div class="flex w-full flex-col space-y-2 items-center justify-center">
                <p>No members yet</p>
                <button @click="addMemberToOrganization"
                  class="rounded p-2 px-4 bg-blue-600 text-white flex items-center space-x-2">
                  <span>
                    Add member
                  </span>
                  <Plus class="w-4 h-4" />
                </button>
              </div>
            </td>
          </tr>
        </template>

        <!-- Members row -->
        <template v-else>
          <tr class="bg-white border-b" v-for="member in members" :key="member.id">
            <td :class="tableDataStyle">
              {{ member.email }}
            </td>
            <td :class="tableDataStyle" class="uppercase font-bold">
              {{ member.role || 'member' }}</td>
            <td :class="tableDataStyle">
              <span class="p-0.5 px-1 text-xs rounded capitalize"
                :class="member.invite_accepted ? 'bg-green-200  text-green-600' : 'bg-yellow-200  text-yellow-600'">
                {{ member.invite_accepted ? 'accepted' : 'pending' }}
              </span>
            </td>

            <td class="flex items-center justify-center space-x-4 p-3">
              <button class="p-1 px-2 rounded border border-gray-600">
                <Delete class="w-4 h-4 text-red-600" />
              </button>
              <button class="p-1 px-2 rounded border border-gray-600">
                <Pencil class="w-4 h-4 text-blue-600" />
              </button>
            </td>
          </tr>
        </template>
      </table>
    </div>
  </div>

  <ModalWrapper :isOpen="createOrganizationModal" @close="createOrganizationModal = false" width="w-[40vw]"
    height="h-fit">
    <div class="p-3 mx-auto">
      <p class="font-bold text-lg">Setup your organization</p>

      <form class="w-full" :action="routes.create_organization" method="post">
        <input type="hidden" name="_token" :value="csrfToken" />
        <div class="space-y-4 mt-6">
          <div class="space-y-1">
            <label for="name" class="flex-1 font-bold">
              Oraganization name:
            </label>
            <div class="flex-1">
              <InputField :value="name" :isError="errors?.name?.length" id="name" type="text" name="name"
                :required="true" />
            </div>
          </div>
          <div class="space-y-1">
            <label for="number_of_employees" class="flex-1 font-bold">
              Number of employees:
            </label>
            <div class="flex-1">
              <select name="number_of_employees"
                class="rounded border border-gray-300 p-2.5 w-full ring-0 focus:outline-none" v-model="numberOfEmployees"
                :required="true">
                <option v-for="(option, i) in numberOfEmployeesOptions" :key="i" :value="option.value">
                  {{ option.title }}
                </option>
              </select>
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
    </div>
  </ModalWrapper>
  <ModalWrapper :isOpen="addMemberModal" @close="addMemberModal = false" width="w-[40vw]" height="h-fit">
    <div class="px-8 space-y-4 mb-8">
      <p class="font-bold text-xl">Invite member to your organization</p>
      <div class="p-3 bg-gray-100 rounded">
        <p class="text-xs">
          Add someone to join your organization by inviting them to join.
          We will send an invite link to their email address.
        </p>
      </div>
      <form :action="routes.add_member" method="post" class="space-y-4 w-full mx-auto">
        <input type="hidden" name="_token" :value="csrfToken" />
        <div class="">
          <label>Email address</label>
          <div class="flex-1">
            <InputField :value="newMemberEmail" :isError="errors?.email?.length" id="name" type="email" name="email"
              class="w-full" :required="true" />
            <span v-if="errors?.email?.length" class="text-xs text-red-600">{{ errors?.email[0] }}</span>
          </div>
        </div>
        <div class="w-full">
          <label>Select role</label>
          <select name="role" class="uppercase rounded border border-gray-300 p-2.5 w-full ring-0 focus:outline-none"
            v-model="newMemberRole" :required="true">
            <option disabled>SELECT ROLE</option>
            <option v-for="(role, i) in availableRoles" :key="i" :value="role" class="uppercase">
              {{ role }}
            </option>
          </select>
        </div>
        <div class="w-full flex justify-end">
          <button class="p-2.5 px-4 bg-blue-600 text-white rounded">
            Add member
          </button>
        </div>
      </form>
    </div>
  </ModalWrapper>
</template>

<script>
import InputField from "@/components/InputField.vue";
import ModalWrapper from "@/components/ModalWrapper.vue";
import { Pencil, Delete, Cog8, Plus } from '@/components/Icons/Index.vue'

export default {
  components: {
    InputField, ModalWrapper, Delete, Pencil, Cog8, Plus
  },
  props: {
    user: Object,
    organization: Object,
    members: { type: Array, default: [] },
    errors: Object,
    routes: Object,
    oldValues: Object,
    roles: Array
  },
  data() {
    return {
      showModal: true,
      createOrganizationModal: Boolean(!this.organization),
      addMemberModal: false,
      availableRoles: this.roles,
      name: this.organization?.name ?? this.user.company_name,
      numberOfEmployees: this.organization?.number_of_employees,
      newMemberEmail: "",
      newMemberRole: "",
      tableHeaderStyle: "px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center",
      tableDataStyle: "px-4 py-2 text-center",
      csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      tableHeaderNames: ['Email address', 'role', 'Invite Status', 'Action'],
      numberOfEmployeesOptions: [
        { title: "1 to 10 employees", value: "1-10" },
        { title: "10 to 50 employees", value: "10-50" },
        { title: "50 to 100 employees", value: "50-100" },
        { title: "100 to 1,000 employees", value: "100-1000" },
        { title: "1,000+ employees", value: "1000+" },
      ],
    };
  },
  mounted() {
    // Check if there are any errors.
    if (
      this.errors.hasOwnProperty("name") ||
      this.errors.hasOwnProperty("number_of_employees")
    ) {
      // Set the name and numberOfEmployees values to the old values.
      this.name = this.oldValues.name;
      this.numberOfEmployees = this.oldValues.number_of_employees;
    }

    if (this.errors.hasOwnProperty("email") || this.errors.hasOwnProperty("role")) {
      this.addMemberModal = true;
      this.newMemberEmail = this.oldValues.email;
      this.newMemberRole = this.oldValues.role;
    }
  },

  methods: {
    // Open modal to add member or setup organization based on user's organization status.
    addMemberToOrganization() {
      if (this.user.organization_id) {
        this.addMemberModal = true;
      } else {
        this.createOrganizationModal = true
      }
    }
  },
};
</script>
