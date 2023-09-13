<template>
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
                            class="rounded border border-gray-300 p-2.5 w-full ring-0 focus:outline-none"
                            v-model="numberOfEmployees" :required="true">
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
</template>
<script>
import InputField from "@/components/InputField.vue";

export default {
    components: { InputField },
    data() {
        return {
            newMemberEmail: '',
            newMemberRole: '',
            numberOfEmployeesOptions: [
                { title: "1 to 10 employees", value: "1-10" },
                { title: "10 to 50 employees", value: "10-50" },
                { title: "50 to 100 employees", value: "50-100" },
                { title: "100 to 1,000 employees", value: "100-1000" },
                { title: "1,000+ employees", value: "1000+" },
            ],
            name: this.organization?.name ?? this.user.company_name,
            numberOfEmployees: this.organization?.number_of_employees,
        }
    },
    props: {
        organization:Object,
        routes: Array,
        errors: Array,
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