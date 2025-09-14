import "./bootstrap";
import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import { Carousel } from "@fancyapps/ui/dist/carousel/";
import "@fancyapps/ui/dist/carousel/carousel.css";
import { Dots } from "@fancyapps/ui/dist/carousel/carousel.dots.js";
import "@fancyapps/ui/dist/carousel/carousel.dots.css";
import { Arrows } from "@fancyapps/ui/dist/carousel/carousel.arrows.js";
import "@fancyapps/ui/dist/carousel/carousel.arrows.css";
import { Autoplay } from "@fancyapps/ui/dist/carousel/carousel.autoplay.js";
import "@fancyapps/ui/dist/carousel/carousel.autoplay.css";
import { Autoscroll } from "@fancyapps/ui/dist/carousel/carousel.autoscroll.js";

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import idLocale from '@fullcalendar/core/locales/id'

window.Fancybox = Fancybox;
window.Carousel = Carousel;
window.Dots = Dots;
window.Arrows = Arrows;
window.Autoplay = Autoplay;
window.Autoscroll = Autoscroll;

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.idLocale = idLocale;
