<template>
  <div class="flex space-x-2 mb-2">
    <button
      v-for="plan in plans"
      :key="plan"
      class="font-medium capitalize rounded-lg text-sm p-1 px-2"
      :class="[
        plan.name === activePlan.name ? activePlanStyle : inactivePlanStyle,
      ]"
      @click="makeActive(plan)"
    >
      {{ plan.name }}
    </button>
  </div>

  <div class="p-3 flex space-x-8 mb-8" v-if="activePlan.stats.predicted_ARR > 0">
    <div :class="statsCardStyle + ' flex font-bold text-lg'">
      <span
        >{{ activePlan.visibleCustomers.length }} User{{
          activePlan.visibleCustomers.length > 1 ? "s" : ""
        }}
        to upsell</span
      >
    </div>
    <div :class="statsCardStyle">
      <span class="text-xs">Predicted MRR:</span>
      <p class="text-green-500 text-2xl font-bold">
        {{ numberFormat(activePlan.stats.predicted_MRR) }}
        <span class="text-xs"> USD </span>
      </p>
    </div>
    <div :class="statsCardStyle">
      <span class="text-xs">Predicted ARR:</span>
      <p class="text-green-500 text-2xl font-bold">
        {{ numberFormat(activePlan.stats.predicted_ARR) }}
        <span class="text-xs"> USD </span>
      </p>
    </div>
    <div :class="statsCardStyle" v-if="activePlan.name != `all`">
      <span class="text-xs">Plan price:</span>
      <p class="text-green-500 text-2xl font-bold">
        {{ numberFormat(activePlan.stats.plan_price) }}
        <span class="text-xs"> USD </span>
      </p>
    </div>
  </div>

  <div class="flex flex-col">
    <div class="flex">
      <table class="w-full border text-sm text-left text-gray-500">
        <thead>
          <tr>
            <th
              scope="col"
              :class="tableHeaderStyle"
              v-for="(headerName, index) in headerNames"
              :key="index"
            >
              {{ headerName }}
            </th>
          </tr>
        </thead>

        <!-- Empty data -->
        <template v-if="activePlan.visibleCustomers.length === 0">
          <tr>
            <td colspan="4" class="p-5 text-center">No data</td>
          </tr>
        </template>

        <!-- Customers row -->
        <template v-else>
          <tr
            class="bg-white border-b"
            v-for="customer in activePlan.visibleCustomers"
            :key="customer.id"
          >
            <td
              scope="row"
              class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap text-center"
            >
              <a :href="`/customer-dashboard/` + customer.id">{{
                customer.email
              }}</a>
            </td>
            <td scope="row" :class="tableDataStyle">
              <Stars :amount="customer.latest_state.state.likelihood" />
            </td>

            <td :class="tableDataStyle">
              {{ customer.latest_state.state.user_creation_time }}
            </td>

            <td :class="tableDataStyle">
              {{ customer.latest_state.state.time_to_value }}
            </td>

            <!-- Visibility toggle -->
            <td>
              <form
                method="POST"
                :action="`/hide-customer-state/` + customer.id"
              >
                <div class="form-group">
                  <input type="hidden" name="_token" :value="csrfToken" />
                  <button
                    type="submit"
                    onclick="return confirm('Are you sure you want to hide this user from the list?')"
                    class="focus:outline-none text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-2"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                    </svg>
                  </button>
                </div>
              </form>
            </td>
          </tr>
        </template>
      </table>
    </div>
  </div>
</template>

<script>
import Stars from "./Stars.vue";
export default {
  props: { data: Object },
  data() {
    return {
      plans: [],
      csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      activePlan: {
        name: null,
        customers: [],
        visibleCustomers: [],
        stats: { predicted_MRR: 0, predicted_ARR: 0, plan_price: 0 },
      },
      headerNames: [
        "Email",
        "Likelihood",
        "User Creation Time",
        "Time to Value",
      ],
      activePlanStyle:
        "text-white bg-blue-700 hover:bg-blue-800 focus:ring- focus:ring-blue-300 focus:outline-none",
      inactivePlanStyle:
        "text-gray-600 border hover:border hover:border-blue-700 border-gray-300 hover:text-blue-700",
      tableHeaderStyle:
        "px-6 py-3 text-xs text-gray-700 uppercase bg-gray-50 text-center",
      tableDataStyle: "px-6 py-4 text-center",
      statsCardStyle:
        "p-3 border border-gray-300 rounded space-y-2 items-center justify-center w-full",
    };
  },

  // Process data from backend into usable data structures for the component.
  mounted() {
    /**  Extract plans from data and sort by stats.plan_price.
     * This is to arrange the navigtion tabs by the plan
     */
    const dataPlans = Object.values(this.data);
    const plans = dataPlans.sort(
      (a, b) => a.stats.plan_price - b.stats.plan_price
    );

    // Compute total MRR/ARR from the stats (to be used for "All" nav option).
    const allStats = plans.flatMap((plan) => plan.stats);
    const totalStats = allStats.reduce(
      (accumulator, plan) => {
        accumulator.predicted_MRR += plan.predicted_MRR;
        accumulator.predicted_ARR += plan.predicted_ARR;
        return accumulator;
      },
      { predicted_MRR: 0, predicted_ARR: 0 }
    );

    // Combine all customers in each group into a single group for an "All" tab.
    const allCustomers = plans.flatMap((plan) => plan.customers);

    // Create an "All" group and add to the start of the plans array.
    plans.unshift({ name: "all", customers: allCustomers, stats: totalStats });
    this.plans = plans;
    this.makeActive(plans[0]);
  },

  methods: {
    // Sets the state of the active plan in the navigation options.
    makeActive(plan) {
      this.activePlan = plan;
      const visibleCustomers = plan.customers.filter((c) => !c.hidden_at);
      this.activePlan.visibleCustomers = visibleCustomers;
    },
    numberFormat(number) {
      return parseFloat(number).toLocaleString();
    },
  },
  components: { Stars },
};
</script>
