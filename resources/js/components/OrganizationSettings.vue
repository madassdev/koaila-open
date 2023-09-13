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
              <!-- <button class="p-1 px-2 rounded border border-gray-600">
                <Delete class="w-4 h-4 text-red-600" />
              </button> -->
              <button @click="editMember(member)" class="p-1 px-2 rounded border border-gray-600">
                <Pencil class="w-4 h-4 text-blue-600" />
              </button>
            </td>
          </tr>
        </template>
      </table>
    </div>
  </div>

  <ModalWrapper :isOpen="createOrganizationModal" @close="createOrganizationModal = false" width="w-[40vw]" height="h-fit">
    <ChangeOrganizationSettings 
      :routes="routes" 
      :errors="errors" 
      :oldValues="oldValues" 
      :csrfToken="csrfToken"
      :organization="organization"
       />
  </ModalWrapper>

  <ModalWrapper :isOpen="addMemberModal" @close="addMemberModal = false" width="w-[40vw]" height="h-fit">
    <AddOrganizationMember 
      :availableRoles="availableRoles" 
      :routes="routes" 
      :errors="errors" 
      :oldValues="oldValues" 
      :newMemberRole="newMemberRole"
      :csrfToken="csrfToken"
      :newMemberEmail="newMemberEmail" />
  </ModalWrapper>

  <ModalWrapper :isOpen="editMemberModal" @close="editMemberModal = false" width="w-[40vw]" height="h-fit">
    <EditOrganizationMember 
      :availableRoles="availableRoles" 
      :routes="routes" 
      :errors="errors" 
      :newMemberRole="newMemberRole"
      :csrfToken="csrfToken"
      :memberToEdit="memberToEdit" />
  </ModalWrapper>
</template>

<script>
import ModalWrapper from "@/components/ModalWrapper.vue";
import AddOrganizationMember from "@/components/OrganizationSettings/AddOrganizationMember.vue";
import EditOrganizationMember from "@/components/OrganizationSettings/EditOrganizationMember.vue";
import ChangeOrganizationSettings from "@/components/OrganizationSettings/ChangeOrganizationSettings.vue";
import { Pencil, Delete, Cog8, Plus } from '@/components/Icons/Index.vue'

export default {
  components: {
    ModalWrapper,
    Delete,
    Pencil,
    Cog8,
    Plus,
    AddOrganizationMember,
    EditOrganizationMember,
    ChangeOrganizationSettings
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
      memberToEdit: null,
      editMemberModal: false,
      availableRoles: this.roles,
      newMemberEmail: "",
      newMemberRole: "",
      tableHeaderStyle: "px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center",
      tableDataStyle: "px-4 py-2 text-center",
      csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      tableHeaderNames: ['Email address', 'role', 'Invite Status', 'Action'],
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
    },
    editMember(member) {
      this.memberToEdit = member;
      this.editMemberModal = true;
    }
  },
};
</script>
