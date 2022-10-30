import {QuotesPresenterOutput} from "./quotes_presenter_output.js";
import {Chart, registerables} from "chart.js";
Chart.register(...registerables);

export class ChartGenerator {
    /**
     * @param chartDomElement
     * @param {QuotesPresenterOutput} presenterOutput
     * @return {Chart}
     */
    generate(chartDomElement, presenterOutput) {
        const ctx = chartDomElement.getContext('2d')
        const labels = [];
        let datasetPositive = this.getDatasetPositive()
        let datasetNegative = this.getDatasetNegative()
        let yMin = undefined;
        let yMax = undefined;

        presenterOutput.data.forEach(item => {
            labels.push(item.dateFormatted())
            const min = item.open < item.close ? item.open : item.close;
            const max = item.open >= item.close ? item.open : item.close;
            if (yMin === undefined || min < yMin) {
                yMin = Math.floor(min);
            }
            if (yMax === undefined || yMax < max) {
                yMax = Math.ceil(max);
            }
            if (item.open <= item.close) {
                datasetPositive.data.push([item.open.toFixed(2), item.close.toFixed(2)])
                datasetNegative.data.push([])
            } else {
                datasetPositive.data.push([])
                datasetNegative.data.push([item.close.toFixed(2), item.open.toFixed(2)])
            }
        })

        return this.getChart(ctx, labels, datasetPositive, datasetNegative, yMin, yMax);
    }

    getChart(ctx, labels, datasetPositive, datasetNegative, yMin, yMax) {
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [datasetPositive, datasetNegative]
            },
            options: {
                responsive: true,
                scales: {
                    yAxis: {
                        min: yMin,
                        max: yMax
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Open - Closed Prices'
                    }
                },
                legend: {display: false},
                tooltips: {enabled: false}
            }
        });
    }

    getDatasetNegative() {
        return {
            label: '-',
            data: [],
            backgroundColor: 'rgb(185,40,1)',
        };
    }

    getDatasetPositive() {
        return {
            label: '+',
            data: [],
            backgroundColor: 'rgb(40,185,0)',
        };
    }
}