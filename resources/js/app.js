require('./bootstrap');

import Alpine from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Lightbox from "@edsardio/alpine-lightbox"
import mask from '@alpinejs/mask'
import collapse from '@alpinejs/collapse'
import Tooltip from "@ryangjchandler/alpine-tooltip";
import html2canvas from "html2canvas";
import NiceColours from "nice-color-palettes"



Alpine.plugin(Clipboard)
Alpine.plugin(Lightbox);
Alpine.plugin(mask)
Alpine.plugin(collapse)
Alpine.plugin(Tooltip);


window.Alpine = Alpine
window.Alpine.start()





