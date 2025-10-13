import './bootstrap';
import Alpine from 'alpinejs';
import Precognition from 'laravel-precognition-alpine';
import '../css/speed-dial.css';
import 'flowbite';
import './lib/phone-formatter.js';
import './common/loading-spinner';
import './common/speed-dial.js';
import { disableEnterOnInputs } from './common/disable-enter';

window.Alpine = Alpine;
window.Precognition = Precognition;

Alpine.plugin(Precognition);
Alpine.start();

disableEnterOnInputs();
