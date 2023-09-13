<template>
    <div class="px-8 space-y-4 mb-8">
        <p class="font-bold text-xl">Update member in your organization</p>
        <form :action="routes.update_member" method="post" class="space-y-4 w-full mx-auto">
            <input type="hidden" name="_token" :value="csrfToken" />
            <input type="hidden" name="member_id" :value="memberToEdit.id" />
            <div class="">
                <label>Email address</label>
                <div class="flex-1">
                    <InputField :isError="errors?.email?.length" id="name" type="email" name="email"
                        class="w-full bg-gray-300" :required="true" :value="memberToEdit.email" :disabled="true" />
                    <span v-if="errors?.email?.length" class="text-xs text-red-600">{{ errors?.email[0] }}</span>
                </div>
            </div>
            <div class="w-full">
                <label>Select role</label>
                <select name="role" class="uppercase rounded border border-gray-300 p-2.5 w-full ring-0 focus:outline-none"
                    value="newMemberRole" :required="true">
                    <option v-for="(role, i) in availableRoles" :key="i" :value="role" class="uppercase">
                        {{ role }}
                    </option>
                </select>
            </div>
            <div class="w-full flex justify-end">
                <button class="p-2.5 px-4 bg-blue-600 text-white rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</template>
<script>
import InputField from "@/components/InputField.vue";

export default {
    components: {InputField},
    props: {
        availableRoles:Array,
        routes: Array,
        errors: Array,
        newMemberRole: String,
        csrfToken: String,
        memberToEdit: Object
    }
}
</script>