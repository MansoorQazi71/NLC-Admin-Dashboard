<style>
    /* Public site / Elementor-aligned palette for admin */
    :root {
        --nlc-primary: #69727d;
        --nlc-text: #1f2124;
        --nlc-border: #69727d;
        --nlc-muted: #69727d;
        --nlc-success: #5cb85c;
        --nlc-info: #5bc0de;
        --nlc-warning: #f0ad4e;
        --nlc-danger: #d9534f;
        --nlc-surface: #ffffff;
        --nlc-canvas: #f4f5f7;
        --bs-primary: #69727d;
        --bs-primary-rgb: 105, 114, 125;
        --bs-success: #5cb85c;
        --bs-success-rgb: 92, 184, 92;
        --bs-info: #5bc0de;
        --bs-info-rgb: 91, 192, 222;
        --bs-warning: #f0ad4e;
        --bs-warning-rgb: 240, 173, 78;
        --bs-danger: #d9534f;
        --bs-danger-rgb: 217, 83, 79;
        --bs-body-color: #1f2124;
        --bs-body-bg: #f4f5f7;
        --bs-secondary-color: #69727d;
        --bs-border-color: rgba(105, 114, 125, 0.22);
        --bs-link-color: #69727d;
        --bs-link-hover-color: #4f565f;
    }
    .btn-primary {
        --bs-btn-bg: var(--nlc-primary);
        --bs-btn-border-color: var(--nlc-primary);
        --bs-btn-hover-bg: #5a626c;
        --bs-btn-hover-border-color: #545b64;
        --bs-btn-active-bg: #545b64;
        --bs-btn-active-border-color: #4f565f;
        --bs-btn-disabled-bg: var(--nlc-primary);
        --bs-btn-disabled-border-color: var(--nlc-primary);
    }
    .btn-outline-primary {
        --bs-btn-color: var(--nlc-primary);
        --bs-btn-border-color: var(--nlc-primary);
        --bs-btn-hover-bg: var(--nlc-primary);
        --bs-btn-hover-border-color: var(--nlc-primary);
        --bs-btn-active-bg: var(--nlc-primary);
        --bs-btn-active-border-color: var(--nlc-primary);
    }
    body {
        background: var(--nlc-canvas);
        color: var(--nlc-text);
    }
    .form-control:focus,
    .form-select:focus {
        border-color: var(--nlc-primary);
        box-shadow: 0 0 0 0.2rem rgba(105, 114, 125, 0.2);
    }
    /* Table row actions: inline-flex keeps buttons in a row; larger hit targets */
    .admin-table-actions {
        display: inline-flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
        max-width: 100%;
    }
    .admin-table-actions form {
        display: inline-flex;
        margin: 0;
    }
    .btn-admin-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        font-size: 0.9375rem;
        font-weight: 500;
        line-height: 1.2;
        min-height: 2.5rem;
    }
    .btn-admin-action i {
        font-size: 1.05em;
    }
</style>
