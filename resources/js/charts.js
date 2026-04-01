
/**
 * Apex Chars Options
 */
class Charts {

    constructor() {
        this.init();
    }

    // initialize
    init()
    {
        this.reportLineChart();
        this.reportBarChart();
    }

    /**
     * Line Chart for counts of inquiries per intervals
     */
    reportLineChart() {
        const el = document.querySelector("#chartOne");
        if (!el) return;

        // Get data from Blade
        const data = el.dataset.count ? JSON.parse(el.dataset.count) : [];
        const labels = el.dataset.months ? JSON.parse(el.dataset.months) : [];

        const options = {
            series: [{
                name: 'Warranty Inquiries',
                data: data
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%',
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['oklch(20.5% 0 0)'],
            xaxis: {
                categories: labels,
            },
            yaxis: {
                title: {
                    text: 'Inquiries Count Per Interval'
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " inquiries";
                    }
                }
            }
        };
        const chart = new ApexCharts(el, options);
        chart.render();
    }

    reportBarChart() {
        const el = document.querySelector('#top-reported-products');
        if (!el) return;

        const data = el.dataset.reportCount ? JSON.parse(el.dataset.reportCount) : [];
        const labels = el.dataset.reportedName ? JSON.parse(el.dataset.reportedName) : [];

        const options = {
            series: data,
            chart: {
                type: 'donut',
                height: '100%',
                toolbar: { show: false }
            },
            labels: labels,
            plotOptions: {
                pie: {
                    customScale: 0.9,
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Reports',
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                markers: { radius: 12 },
                itemMargin: {
                    horizontal: 10,
                    vertical: 5
                }
            },
            colors: ['#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            stroke: {
                show: true,
                width: 2,
                colors: ['#fff']
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { height: 300 },
                    legend: { position: 'bottom' }
                }
            }]
        };

        const chart = new ApexCharts(el, options);
        chart.render();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    new Charts();
});