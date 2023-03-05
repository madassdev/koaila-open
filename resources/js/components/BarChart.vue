<template>
    <Bar 
    :data="chartData" 
    :options="chartOptions"
    />
  </template>



<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, CategoryScale, LinearScale } from 'chart.js/auto'

ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale)

export default {
  props: ['label','data', 'backgroundcolor','legend','limit'],
  name: 'barChart',
  components: { Bar },

  mounted(){
    if(this.label ==="Feature adoption"){
      let a=[]
      let dataLabels=[]
      let random_color= ''
      let temp =''
      let counter = 0
      for(let dataLabel of Object.keys(this.data)){
        if(counter == this.limit){
          break
        }
        while(temp === random_color){
          temp = '#'+Math.floor(Math.random()*16777215).toString(16)
        }
        random_color=temp
        
        a.push({
          label: dataLabel.replaceAll('_', ' '),
          data:Object.values(this.data[dataLabel]),
          backgroundColor: random_color,
          borderColor: random_color
        })
        dataLabels = Object.keys(this.data[dataLabel])
        counter++
      }
      this.chartData={
        labels: dataLabels,
        datasets: a,
      }
    }
  },

  data() {
    return {
      chartData: {
        labels: Object.keys(this.data),
        datasets:[{
          label: this.label,
          data:Object.values(this.data),
          backgroundColor: this.backgroundcolor,
          borderColor: this.backgroundcolor
        }], 
      },
      chartOptions: {
        responsive: true,
        pointRadius: 0,
        indexAxis: 'y',
        scales: {
          x: {
            grid: {
              display: false,
            },
            min: 0,
            max: 100,
          },
          y: {
            grid: {
              display: false,
            },
          },
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