require('./bootstrap');

import Alpine from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Lightbox from "@edsardio/alpine-lightbox";
import mask from '@alpinejs/mask'
import collapse from '@alpinejs/collapse'


Alpine.plugin(Clipboard)
Alpine.plugin(Lightbox);
Alpine.plugin(mask)
Alpine.plugin(collapse)


window.Alpine = Alpine
window.Alpine.start()




