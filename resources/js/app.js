import './bootstrap';
import Alpine from 'alpinejs';
import Precognition from 'laravel-precognition-alpine';
import 'flowbite';
import './lib/phone-formatter.js';

window.Alpine = Alpine;
window.Precognition = Precognition;

Alpine.plugin(Precognition);
Alpine.start();