<template>
    <Line 
    :data="chartData" 
    :options="chartOptions"
    />
  </template>



<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale)

export default {
  props: ['label','data'],
  name: 'CHART',
  components: { Line },

  data() {
    return {
      chartData: {
        labels: Object.keys(this.data),
        datasets:{
          label: this.label,
          data:Object.values(this.data),
        }, 
      },
      chartOptions: {
        responsive: true
      }
    }
  }
}
</script>