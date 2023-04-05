<template>
    <GChart :type="chartType" :data="chartData" :options="chartOptions" :settings="settings" />
  </template>

  <script>
  import { GChart } from 'vue-google-charts';

  export default {
    props:{
        'data':Object
    },
    name: 'GoogleChart',
    components: {
      GChart,
    },
    data() {
      return {
        chartType: 'Sankey',
        chartData: this.data,
        chartOptions: {
            width: 1500,
            height: 200,
            sankey: {
                node:
                    {
                        width: 5,
                    }
            },
        },
        settings: {
          packages: ['sankey'],
        },
      };
    },
  };
  </script>
