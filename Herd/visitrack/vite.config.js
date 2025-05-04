export default defineConfig({
    plugins: [
        laravel({
            // These are the main entry points for your CSS and JS
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true, // Keep this for development with Hot Module Replacement
        }),
    ],
    // Add any other Vite configurations if needed
});