<x-filament-panels::page>
    <style>
        /* Vertical Tabs Full Width Styles */
        .fi-tabs-vertical {
            width: 100% !important;
        }

        .fi-tabs-vertical .fi-tabs-list {
            width: 25% !important;
            min-width: 250px !important;
        }

        .fi-tabs-vertical .fi-tabs-content {
            width: 75% !important;
            flex: 1 !important;
        }

        /* Ensure form takes full width */
        .fi-form {
            width: 100% !important;
        }

        /* Make sections full width */
        .fi-section {
            width: 100% !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .fi-tabs-vertical .fi-tabs-list {
                width: 100% !important;
                min-width: auto !important;
            }

            .fi-tabs-vertical .fi-tabs-content {
                width: 100% !important;
            }
        }

        /* Ensure proper spacing */
        .fi-tabs-vertical .fi-tabs-panel {
            padding: 1.5rem !important;
        }

        /* Make repeater and form elements full width */
        .fi-repeater,
        .fi-section-content {
            width: 100% !important;
        }

        /* Grid columns adjustment */
        .fi-section-content .fi-grid {
            width: 100% !important;
        }
    </style>
</x-filament-panels::page>