require('./bootstrap');

import Alpine from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Lightbox from "@edsardio/alpine-lightbox";

Alpine.plugin(Clipboard)
Alpine.plugin(Lightbox);




window.Alpine = Alpine
window.Alpine.start()




