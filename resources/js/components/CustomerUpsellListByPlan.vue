<template>
  <div class="flex items-center justify-between px-4">
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
    <button
      class="font-medium capitalize rounded-lg text-sm p-1 px-2 mb-2"
      :class="[
        activePlan.name === 'hidden' ? activePlanStyle : inactivePlanStyle,
      ]"
      @click="showHiddenCustomers()"
    >
      Hidden
    </button>
  </div>

  <div class="p-4 flex space-x-8" v-if="activePlan.stats.plan_exists">
    <div :class="statsCardStyle + ' flex font-bold text-lg'">
      <span
        >{{ activePlan.customers.length }} User{{
          activePlan.customers.length > 1 ? "s" : ""
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
  
  <div class="p-4" v-if="activePlan.name !== 'all'">
    <SaleFunnelTimeline :sale-funnel-data="activePlan.sale_funnel" />
  </div>
  <div class="flex flex-col p-4">
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
            <th :class="tableHeaderStyle">
              {{ activePlan.name == "hidden" ? "Unhide" : "Hide" }}
            </th>
          </tr>
        </thead>

        <!-- Empty data -->
        <template v-if="activePlan.customers.length === 0">
          <tr>
            <td colspan="4" class="p-5 text-center">No data</td>
          </tr>
        </template>

        <!-- Customers row -->
        <template v-else>
          <tr
            class="bg-white border-b"
            v-for="customer in activePlan.customers"
            :key="customer.id"
          >
            <td
              scope="row"
              class="px-6 py-4 font-bold whitespace-nowrap text-center"
            >
              <a :href="`/customer-dashboard/` + customer.id">{{
                customer.email
              }}</a>
            </td>
            <td scope="row" :class="tableDataStyle">
              <div class="flex items-center justify-center">
                <Stars :amount="customer.latest_state.state.likelihood" />
              </div>
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
                <div class="form-group flex justify-center items-center">
                  <input type="hidden" name="_token" :value="csrfToken" />
                  <button
                    type="submit"
                    onclick="return confirm('Are you sure?')"
                    class="focus:outline-none text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-2"
                  >
                    <HideUnhideToggleIcon
                      :hidden="activePlan.name == 'hidden'"
                    />
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
import HideUnhideToggleIcon from "./HideUnhideToggleIcon.vue";
import SaleFunnelTimeline from "./SaleFunnelTimeline.vue";
export default {
  props: { data: Object, saleFunnelData: Object },
  data() {
    return {
      plans: [],
      csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      activePlan: {
        name: null,
        customers: [],
        stats: { predicted_MRR: 0, predicted_ARR: 0, plan_price: 0 },
        sale_funnel: [],
      },
      hiddenCustomers: [],
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

    // Check if all plans do not exist the data, and set the plan_exists key accordingly.
    const plansThatExist = plans.filter((p) => p.stats.plan_exists);

    const totalStats = allStats.reduce(
      (accumulator, plan) => {
        accumulator.predicted_MRR += plan.predicted_MRR;
        accumulator.predicted_ARR += plan.predicted_ARR;
        return accumulator;
      },
      {
        predicted_MRR: 0,
        predicted_ARR: 0,
        plan_exists: Boolean(plansThatExist.length),
      }
    );

    // Combine all customers in each group into a single group for an "All" tab.
    const allCustomers = plans.flatMap((plan) => plan.customers);

    // Get all hidden users
    this.hiddenCustomers = allCustomers.filter((c) => c.hidden_at);

    // Create an "All" group and add to the start of the plans array.
    plans.unshift({ name: "all", customers: allCustomers, stats: totalStats });

    // Use only groups that have a plan name
    this.plans = plans.filter((p) => p.name != "");
    this.makeActive(plans[0]);
  },

  methods: {
    // Sets the state of the active plan in the navigation options.
    makeActive(plan) {
      this.activePlan = plan;
      const visibleCustomers = plan.customers.filter((c) => !c.hidden_at);
      this.activePlan.customers = visibleCustomers;
    },
    // Displays only hidden customers.
    showHiddenCustomers() {
      this.activePlan = {
        name: "hidden",
        customers: this.hiddenCustomers,
        stats: { plan_exists: false },
      };
    },
    numberFormat(number) {
      return parseFloat(number).toLocaleString();
    },
  },
  components: { Stars, HideUnhideToggleIcon, SaleFunnelTimeline },
};
</script>
