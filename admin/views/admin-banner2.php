<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<div id="mm_sow-banner-wrap">

    <div id="mm_sow-banner" class="mm_sow-banner-sticky">
        <h2><span><?php echo __('Micemade SO Widgets', 'mm_sow'); ?></span><?php echo __('Plugin Settings', 'mm_sow') ?></h2>
        <div id="mm_sow-buttons-wrap">
            <a class="mm_sow-button" data-action="mm_sow_save_settings" id="mm_sow_settings_save"><i
                    class="dashicons dashicons-yes"></i><?php echo __('Save Settings', 'mm_sow') ?></a>
            <a class="mm_sow-button reset" data-action="mm_sow_reset_settings" id="mm_sow_settings_reset"><i
                    class="dashicons dashicons-update"></i><?php echo __('Reset', 'mm_sow') ?></a>
        </div>
    </div>

</div>