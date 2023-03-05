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
            width: 800,
            height: 600,
        },
        settings: {
          packages: ['sankey'],
        },
      };
    },
  };
  </script>