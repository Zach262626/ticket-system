import { defineStore } from 'pinia'

let idCounter = 0

export const useAlertStore = defineStore('alert', {
    state: () => ({
        alerts: []
    }),
    actions: {
        addAlert(alert, type = 'info') {
            if (typeof alert === 'string') {
                this.alerts.push({
                    id: ++idCounter,
                    message: alert,
                    type,
                })
            } else {
                this.alerts.push({
                    id: ++idCounter,
                    ...alert
                })
            }
        },
        removeAlert(id) {
            this.alerts = this.alerts.filter(alert => alert.id !== id)
        }
    }
})
