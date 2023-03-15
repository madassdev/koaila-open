import { createApp } from 'vue'
import * as amplitude from '@amplitude/analytics-browser';

// Init amplitude client
window.amplitude = amplitude
amplitude.init('e4b4a405f604a27b0bf91ec1fec479c2', {
    defaultEvents: {
        pageViews: true,
        sessions: true,
        formInteractions: true,
        fileDownloads: true,
    },
    serverZone: amplitude.Types.ServerZone.EU,
});

// Hook function used by event listener
function hookLogEvent (binding) {
    const modifiers = Object.keys(binding.modifiers)
    if (modifiers.length !== 1) {
        throw new Error('Amplitude directive takes only one modifier which is the event name.')
    }
    const eventName = modifiers[0]
    amplitude.track(eventName, binding.value)
}

// Register directive to log event
const registeredListeners = {}

function initAmplitude(vueApp) {
    // Log event function used to log event. Can be used when not using the directive.
    vueApp.provide('$logEvent',  function (eventName, eventData) {
        if (!window.amplitude) return
        if (eventData && typeof eventData !== 'object') {
            throw new Error('Amplitude event value must be an object.')
        }

        window.amplitude.getInstance().logEvent(eventName, eventData)
    })
    vueApp.directive('track', {
        beforeMount (el, binding) {
            registeredListeners[el] = () => {
                hookLogEvent(binding)
            }
            el.addEventListener('click', registeredListeners[el])
        },
    });
}
export default initAmplitude;
