import './bootstrap';

import.meta.glob([
    '../images/**'
]);

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

Alpine.plugin(persist);
Alpine.start();
