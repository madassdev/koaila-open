<template>
    <Line
    :data="chartData"
    :options="chartOptions"
    />
  </template>



<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, CategoryScale, LinearScale } from 'chart.js/auto'

ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale)

export default {
  props: {
    'label':String,
    'data': Object,
    'labels': Object,
    'backgroundcolor': String,
    'legend': Boolean
  },
  name: 'lineChart',
  components: { Line },

  mounted(){
      this.chartData={
          labels: Object.keys(this.data),
          datasets:[{
              label: this.label,
              data:Object.values(this.data),
              borderColor: this.backgroundcolor
          }],
      }
  },

  data() {
    return {
      chartData: {
        labels: [],
        datasets:[],
      },

      chartOptions: {
        responsive: true,
        pointRadius: 0,
        scales: {
          x: {
            grid: {
              display: false,
            },
          },
          y: {
            grid: {
              display: false,
            },
          }
        },
        plugins: {
          legend: {
            display: this.legend
          }
        }
      }
    }
  },
}
</script>
