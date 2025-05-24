
<template>
    <div class="card py-4">
        <div class="border-x-8  flex justify-center border-emerald-500 bg-emerald-100 border border-emerald-400 text-emerald-700 py-4 text-center text-3xl uppercase font-thin">
            <CurrencyDollarIcon class="size-10 text-emerald-600" aria-hidden="true" />
            Budgets & Dotations  </div>
        <Chart type="bar" :data="chartData" :options="chartOptions" class="h-[30rem]"  />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Chart from 'primevue/chart';
import {CurrencyDollarIcon} from "@heroicons/vue/20/solid/index.js";
const props = defineProps({budgets:Object,dotations:Object})
const sum = a => eval(a.join('+'));
onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
    Object.keys(props.dotations).forEach(key => {
        chartData.value.datasets[1].data[ key - 1] = sum(props.dotations[key]);
    })
    Object.keys(props.budgets).forEach(key => {
        chartData.value.datasets[0].data[ key - 1] = sum(props.budgets[key]);
    })
});
const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        datasets: [
            {
                label: 'Budget',
                backgroundColor: documentStyle.getPropertyValue('--p-teal-500'),
                borderColor: documentStyle.getPropertyValue('--p-teal-500'),
                data: [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            },
            {
                label: 'Dotation',
                backgroundColor: documentStyle.getPropertyValue('--p-gray-500'),
                borderColor: documentStyle.getPropertyValue('--p-gray-500'),
                data: [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
    const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                    font: {
                        weight: 500
                    }
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder,
                    drawBorder: false
                }
            }
        }
    };
}
</script>
