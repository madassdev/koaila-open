<template>
    <Doughnut
        :data="chartData"
        :options="chartOptions"
    />
</template>



<script>
import { Doughnut } from 'vue-chartjs'
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
    name: 'doughnutChart',
    components: { Doughnut },

    mounted(){
        this.chartData={
            labels: this.labels,
            datasets:[{
                label: this.label,
                data:Object.values(this.data),
                backgroundColor: this.backgroundcolor,
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
                plugins: {
                    legend: {
                        display: this.legend
                    }
                },
                radius:100,
                aspectRatio:2,
            }
        }
    },
}
</script>
