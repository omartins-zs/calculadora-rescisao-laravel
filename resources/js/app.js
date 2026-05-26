import './bootstrap';

import Alpine from 'alpinejs';
import Mask from '@alpinejs/mask';
import { initFlowbite } from 'flowbite';

Alpine.plugin(Mask);

window.Alpine = Alpine;
Alpine.start();

// Inicializa componentes Flowbite (tooltips, dropdowns, etc.)
document.addEventListener('DOMContentLoaded', () => {
    initFlowbite();
});
