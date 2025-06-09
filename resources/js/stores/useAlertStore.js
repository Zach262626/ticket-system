// resources/js/stores/useAlertStore.js
import { defineStore } from 'pinia'

export const useAlertStore = defineStore('alert', {
    state: () => ({
        alerts: []
    }),
    actions: {
        addAlert(message, type = 'info') {
            const id = Date.now()
            this.alerts.push({ id, message, type })
            setTimeout(() => this.removeAlert(id), 5000)
        },
        removeAlert(id) {
            this.alerts = this.alerts.filter(a => a.id !== id)
        }
    }
})
