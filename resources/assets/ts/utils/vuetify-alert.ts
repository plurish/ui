export type AlertType = 'error' | 'success' | 'warning' | 'info' | undefined;

export type VuetifyAlert = {
    title: string;
    text: string;
    type: AlertType;
    closable: boolean;
};
