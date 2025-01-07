import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/inventory_view.css',  
                'resources/js/app.js',
                'resources/css/inventory/add-material.css',
                'resources/css/inventory/record-receipt.css',
                'resources/css/inventory/record-usage.css',
                'resources/css/material_usage/material_usage.css',
                'resources/css/material_usage/weight_recording.css',
                'resources/css/material_usage/loss_calculation.css',
                'resources/css/inventory/material-history.css',
                'resources/css/inventory/edit-receipt.css'

                
            ],
            refresh: true,
        }),
    ],
});