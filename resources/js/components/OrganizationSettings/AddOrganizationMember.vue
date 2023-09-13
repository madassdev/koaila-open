<template>
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
                    :value="newMemberRole" :required="true">
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
</template>
<script>
import InputField from "@/components/InputField.vue";

export default {
    components: { InputField },
    data() {
        return {
            newMemberEmail: '',
            newMemberRole: ''
        }
    },
    props: {
        availableRoles: Array,
        routes: Array,
        errors: Array,
        newMemberRole: String,
        csrfToken: String,
        oldValues: Object
    },
    mounted() {
        if (this.errors.hasOwnProperty("email") || this.errors.hasOwnProperty("role")) {
            this.newMemberEmail = this.oldValues.email;
            this.newMemberRole = this.oldValues.role;
        }
    }
}
</script>