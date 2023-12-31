/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import initAmplitude from './plugins/amplitude';
import {createApp} from "vue";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
const app = createApp({});

import LineChart from './components/LineChart.vue';
app.component('line-chart', LineChart);

import ConfigForm from './components/ConfigForm.vue';
app.component('config-form', ConfigForm);

import BarChart from './components/BarChart.vue';
app.component('bar-chart', BarChart);

import SankeyChart from './components/SankeyChart.vue';
app.component('sankey-chart', SankeyChart);

import DoughnutChart from './components/DoughnutChart.vue';
app.component('doughnut-chart', DoughnutChart);

import CustomerUpsellListByPlan from './components/CustomerUpsellListByPlan.vue';
app.component('customer-upsell-list-by-plan', CustomerUpsellListByPlan);

import UserAccountSettings from './components/UserAccountSettings.vue';
app.component('user-account-settings', UserAccountSettings);

import SaleFunnelTimeline from './components/SaleFunnelTimeline.vue';
app.component('sale-funnel-timeline', SaleFunnelTimeline);

import OrganizationSettings from './components/OrganizationSettings.vue';
app.component('organization-settings', OrganizationSettings);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

initAmplitude(app);
app.mount('#app');
