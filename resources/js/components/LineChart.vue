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
    if(this.label ==="Feature adoption"){
      let a=[]
      let dataLabels=[]
      let random_color= ''
      let temp =''
      for(let dataLabel of Object.keys(this.data)){
        while(temp === random_color){
          temp = '#'+Math.floor(Math.random()*16777215).toString(16)
        }
        random_color=temp

        dataLabels = Object.keys(this.data[dataLabel])
        a.push({
          label: dataLabel.replaceAll('_', ' '),
          data:Object.values(this.data[dataLabel]),
          backgroundColor: random_color,
          borderColor: random_color
        })
      }
      this.chartData={
        labels: dataLabels,
        datasets: a,
      }
    }
    else{
      this.chartData={
          labels: Object.keys(this.data),
          datasets:[{
              label: this.label,
              data:Object.values(this.data),
              borderColor: this.backgroundcolor
          }],
      }
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
