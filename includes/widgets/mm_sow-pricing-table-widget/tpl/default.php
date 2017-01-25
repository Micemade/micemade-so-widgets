<?php
/**
 * @var $pricing_plans
 * @var $settings
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = mm_sow_get_column_class(intval($settings['per_line'])); ?>

<div class="mm_sow-pricing-table mm_sow-container">

    <?php

    foreach ($pricing_plans as $pricing_plan) :

        $pricing_title = esc_html($pricing_plan['pricing_title']);
        $tagline = esc_html($pricing_plan['tagline']);
        $price_tag = htmlspecialchars_decode(wp_kses_post($pricing_plan['price_tag']));
        $pricing_img = $pricing_plan['image'];
        $pricing_url = (empty($pricing_plan['url'])) ? '#' : sow_esc_url($pricing_plan['url']);
        $pricing_button_text = esc_html($pricing_plan['button_text']);
        $button_new_window = esc_html($pricing_plan['button_new_window']);
        $highlight = esc_html($pricing_plan['highlight']);
        
        $price_tag = (empty($price_tag)) ? '' : $price_tag;

        ?>

        <div
            class="mm_sow-pricing-plan <?php echo(!empty($highlight) ? ' mm_sow-highlight' : ''); ?> <?php echo $column_style; ?>">

            <div class="mm_sow-top-header">

                <?php if (!empty($tagline))
                    echo '<p class="mm_sow-tagline center">' . $tagline . '</p>'; ?>

                <h3 class="mm_sow-center"><?php echo $pricing_title; ?></h3>

                <?php

                if (!empty($pricing_img)) :
                    echo wp_get_attachment_image($pricing_img, 'full', false, array('class' => 'mm_sow-image full', 'alt' => $pricing_title));
                endif;

                ?>

            </div>

            <h4 class="mm_sow-plan-price mm_sow-plan-header mm_sow-center">

                <span class="mm_sow-text">

                    <?php echo wp_kses_post($price_tag); ?>

                </span>

            </h4>

            <div class="mm_sow-plan-details">

                <?php

                foreach ($pricing_plan['items'] as $pricing_item) : ?>

                    <div class="mm_sow-pricing-item">

                        <div class="mm_sow-title">

                            <?php echo htmlspecialchars_decode(wp_kses_post($pricing_item['title'])); ?>

                        </div>

                        <div class="mm_sow-value-wrap">

                            <?php

                            if (!empty($pricing_item['icon_new'])) {
                                echo siteorigin_widget_get_icon($pricing_item['icon_new']);
                            }

                            ?>

                            <div class="mm_sow-value">

                                <?php echo htmlspecialchars_decode(wp_kses_post($pricing_item['value'])); ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
            <!-- .mm_sow-plan-details -->

            <div class="mm_sow-purchase">

                <a class="mm_sow-button default" href="<?php echo esc_url($pricing_url); ?>"
                    <?php if (!empty($button_new_window))
                        echo 'target="_blank"'; ?>><?php echo esc_html($pricing_button_text); ?></a>

            </div>

        </div>
        <!-- .mm_sow-pricing-plan -->

        <?php

    endforeach;

    ?>

</div><!-- .mm_sow-pricing-table -->

<div class="mm_sow-clear"></div>