<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


$autoload_widgets = mm_sow_get_option('mm_sow_autoload_widgets', false);

$max_widget_width = mm_sow_get_option('mm_sow_max_widget_width', "960px");

$debug_mode = mm_sow_get_option('mm_sow_enable_debug', false);

$custom_css = mm_sow_get_option('mm_sow_custom_css', '');

?>

<div class="mm_sow-settings">

    <div class="postbox">

        <!-------------------
        OPTIONS HOLDER START
        -------------------->
        <div class="mm_sow-menu-options settings-options">

            <div class="mm_sow-inner">

                <!-------------------  LI TABS -------------------->

                <ul class="mm_sow-tabs-wrap">
                    <li class="mm_sow-tab selected" data-target="general"><i
                            class="mm_sow-icon dashicons dashicons-admin-generic"></i><?php echo __('General', 'mm_sow') ?>
                    </li>
                    <li class="mm_sow-tab" data-target="custom-css"><i
                            class="mm_sow-icon dashicons dashicons-editor-code"></i><?php echo __('Custom CSS', 'mm_sow') ?>
                    </li>
                    <li class="mm_sow-tab" data-target="debugging"><i
                            class="mm_sow-icon dashicons dashicons-warning"></i><?php echo __('Debugging', 'mm_sow') ?>
                    </li>

                </ul>

                <!-------------------  GENERAL TAB -------------------->

                <div class="mm_sow-tab-content general mm_sow-tab-show">

                    <!---- Auto activate Micemade widgets -->
                    <div class="mm_sow-box-side">
                        <h3><?php echo __('Auto load', 'mm_sow') ?></h3>
                    </div>
                    <div class="mm_sow-inner mm_sow-box-inner">
                        <div class="mm_sow-spacer" style="height: 15px"></div>
                        <label
                            class="mm_sow-label mm_sow-label-outside"><?php echo __('Activate all plugin widgets', 'mm_sow') ?></label>
                        <div class="mm_sow-row mm_sow-type-checkbox mm_sow-field">
                            <p class="mm_sow-desc"><?php echo __('You can selectively activate plugin widgets in', 'mm_sow'); ?>
                                <strong> <a href="<?php echo site_url() . '/wp-admin/plugins.php?page=so-widgets-plugins'; ?>" target="_blank"><?php echo __('Plugins->SiteOrigin Widgets.', 'mm_sow') ?></a></strong>
                                <?php echo __('Or you can choose to auto activate all the widgets part of this plugin by checking below.', 'mm_sow'); ?></p>
                            <div class="mm_sow-toggle">
                                <input type="checkbox" class="mm_sow-checkbox" name="mm_sow_autoload_widgets"
                                       id="mm_sow_autoload_widgets" data-default=""
                                       value="<?php echo $autoload_widgets ?>" <?php echo checked(!empty($autoload_widgets), 1, false) ?>>
                                <label for="mm_sow_autoload_widgets"></label>
                            </div>
                        </div>

                    </div>
					
					<div class="mm_sow-clearfix"></div>
					
                    <!---- Maximum width for Micemade widgets -->
                    <div class="mm_sow-box-side">
                        <h3><?php echo __('Maximum wigets width', 'mm_sow') ?></h3>
                    </div>
                    <div class="mm_sow-inner mm_sow-box-inner">
                        <div class="mm_sow-spacer" style="height: 15px"></div>
                        <label
                            class="mm_sow-label mm_sow-label-outside"><?php echo __('Maximum widget width', 'mm_sow') ?>
						</label>
						
                        <div class="mm_sow-row mm_sow-type-checkbox mm_sow-field">
                            <p class="mm_sow-desc">
								<?php echo __('Enter maximum widget width. Each widget has option to discard this setting, to render full width widget (if no row padding / margin is set)', 'mm_sow'); ?>
								<br>
								<?php echo __('Also, each row can be set to have same maximum width in Edit Row > Row Styles > Layout', 'mm_sow'); ?>
							</p>
                            <div class="mm_sow-text">
                                <input type="text" class="mm_sow-text" name="mm_sow_max_widget_width"
                                       id="mm_sow_max_widget_width" data-default=""
                                       value="<?php echo $max_widget_width ?>">
                                <label for="mm_sow_max_widget_width"></label>
                            </div>
                        </div>

                    </div>

                    <div class="mm_sow-clearfix"></div>

                </div>

                <!------------------- Custom CSS TAB -------------------->

                <div class="mm_sow-tab-content custom-css">

                    <!---- Custom CSS -->
                    <div class="mm_sow-box-side">
                        <h3><?php echo __('Custom CSS', 'mm_sow') ?></h3>
                    </div>
                    <div class="mm_sow-inner mm_sow-box-inner">
                        <div class="mm_sow-row mm_sow-field mm_sow-custom-css">
                            <label
                                class="mm_sow-label"><?php echo __('Custom CSS', 'mm_sow') ?></label>
                            <div class="mm_sow-spacer" style="height: 5px"></div>
                            <p class="mm_sow-desc"><?php echo __('Please enter custom CSS for custom styling of widgets', 'mm_sow') ?></p>

                            <div class="mm_sow-spacer" style="height: 15px"></div>

                            <textarea class="mm_sow-textarea" name="mm_sow_custom_css" id="mm_sow_custom_css" rows="20" cols="120"><?php echo $custom_css ?></textarea>

                        </div>
                    </div>

                    <div class="mm_sow-clearfix"></div>

                </div>

                <!------------------- Debugging TAB -------------------->

                <div class="mm_sow-tab-content debugging">

                    <!---- Enable script debugging -->
                    <div class="mm_sow-box-side">
                        <h3><?php echo __('Debug Mode', 'mm_sow') ?></h3>
                    </div>
                    <div class="mm_sow-inner mm_sow-box-inner">
                        <div class="mm_sow-spacer" style="height: 15px"></div>
                        <label
                            class="mm_sow-label mm_sow-label-outside"><?php echo __('Enable Script Debug Mode', 'mm_sow') ?></label>
                        <div class="mm_sow-row mm_sow-type-checkbox mm_sow-field">
                            <p class="mm_sow-desc"><?php echo __('Use unminified Javascript files instead of minified ones to help developers debug an issue', 'mm_sow') ?></p>
                            <div class="mm_sow-toggle">
                                <input type="checkbox" class="mm_sow-checkbox" name="mm_sow_enable_debug" id="mm_sow_enable_debug"
                                       data-default="" value="<?php echo $debug_mode ?>" <?php echo checked(!empty($debug_mode), 1, false) ?>>
                                <label for="mm_sow_enable_debug"></label>
                            </div>
                        </div>
                    </div>

                    <div class="mm_sow-clearfix"></div>

                    <!---- System Info -->
                    <div class="mm_sow-box-side">
                        <h3><?php echo __('System Info', 'mm_sow') ?></h3>
                    </div>
                    <div class="mm_sow-inner mm_sow-box-inner">

                        <div class="mm_sow-row mm_sow-field">
                            <label
                                class="mm_sow-label"><?php echo __('System Information', 'mm_sow') ?></label>
                            <p class="mm_sow-desc"><?php echo __('Server setup information useful for debugging purposes.', 'mm_sow'); ?></p>

                            <div class="mm_sow-spacer" style="height: 15px"></div>

                            <p class="debug-info"><?php echo nl2br(mm_sow_get_sysinfo()); ?></p>
                        </div>

                    </div>

                    <div class="mm_sow-clearfix"></div>

                </div>

                <!-------------------  OPTIONS HOLDER END  -------------------->
            </div>
            
        </div>

        <!------------------- BUILD PANEL SETTINGS -------------------->

    </div>

</div>
