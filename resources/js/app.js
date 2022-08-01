require('./bootstrap');

import Alpine from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Lightbox from "@edsardio/alpine-lightbox";
import mask from '@alpinejs/mask'

Alpine.plugin(Clipboard)
Alpine.plugin(Lightbox);
Alpine.plugin(mask)




window.Alpine = Alpine
window.Alpine.start()




