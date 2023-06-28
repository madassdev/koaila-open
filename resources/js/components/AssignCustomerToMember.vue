<template>
    <div class="px-3 space-y-8 mb-8">
        <p class="font-bold text-xl">Assign customer to a member</p>


        <div class="space-y-2">
            <div class="flex items-center justify-between" v-if="customer.user">
                <span>Currently assigned to:</span>
                <div class="flex flex-col items-end">

                    <span class="uppercase">{{ customer.user.email }}</span>
                    <form :action="routes.assign_customer_to_member" method="post" class="space-y-4">
                        <input type="hidden" name="_token" :value="csrfToken" />
                        <input type="hidden" name="customer_id" :value="customer.id" />
                        <input type="hidden" name="member_id" :value="null" />
                        <button class="text-xs text-red-600 flex items-center justify-center space-x-1">
                            <Delete class="w-3 h-3" />
                            <span>Unassign</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-l-4 border-yellow-400 bg-yellow-100 bg-opacity-30 p-2 text-xs">
                <p class="text-yellow-600 text-base">
                    You are about to assign
                    <span class="font-bold">
                        {{ customer.email }}.
                    </span>
                </p>
                <p>
                    Select a member of your organization you would like to assign this customer to.
                    Selected member will be able to view the customer's details on their dashboard when they sign in.
                </p>
            </div>
        </div>

        <form :action="routes.assign_customer_to_member" method="post" class="space-y-4">
            <input type="hidden" name="_token" :value="csrfToken" />
            <input type="hidden" name="customer_id" :value="customer.id" />
            <div class="">
                <label>Select member</label>
                <select name="member_id" class="rounded border border-gray-300 p-2.5 w-full ring-0 focus:outline-none"
                    v-model="memberAssignedTo" :required="true">
                    <option disabled>SELECT MEMBER</option>
                    <option v-for="(member, i) in members" :key="i" :value="member.id"
                        :selected="customer.user_id == member.id">
                        {{ member.email }}
                    </option>
                </select>
            </div>

            <div class="flex items-center justify-end">
                <button class="p-2 px-4 rounded bg-blue-600 text-white flex items-center justify-center space-x-2">
                    <UserPlus class="w-4 h-4" />
                    <span>Assign</span>

                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { UserPlus, Delete } from './Icons/Index.vue';
export default {
    props: { customer: Object, members: Array, routes: Array },
    data() {
        return {
            memberAssignedTo: null,
            csrfToken: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        };

    },
    components: { UserPlus, Delete }
}
</script>