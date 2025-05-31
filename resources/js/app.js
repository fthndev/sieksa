import './bootstrap';

import Alpine from 'alpinejs';
import './mobile-menu.js';
import intersect from '@alpinejs/intersect';

window.Alpine = Alpine;
Alpine.plugin(intersect); 
import '@fortawesome/fontawesome-free/css/all.min.css'; 

Alpine.start();

