<?php

?>

<div class="mm_sow-social-wrap">

    <div class="mm_sow-social-list">

        <?php

        $social_profile = $team_member['social_profile'];

        $email			= $social_profile['email_address'];
        $facebook_url	= $social_profile['facebook'];
        $twitter_url	= $social_profile['twitter'];
        $linkedin_url	= $social_profile['linkedin'];
        $dribbble_url 	= $social_profile['dribbble'];
        $pinterest_url	= $social_profile['pinterest'];
        $googleplus_url = $social_profile['google_plus'];
        $instagram_url	= $social_profile['instagram'];


        if ( $email )
            echo '<div class="mm_sow-social-list-item"><a class="mm_sow-email" href="mailto:' . esc_url( $email ) . '" title="' . __("Send an email", 'mm_sow') . '"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></div>';
        if ( $facebook_url )
            echo '<div class="mm_sow-social-list-item"><a class="mm_sow-facebook" href="' . esc_url( $facebook_url ) . '" target="_blank" title="' . __("Follow on Facebook", 'mm_sow') . '"><i class="fa fa-facebook" aria-hidden="true"></i></a></div>';
        if ( $twitter_url )
            echo '<div class="mm_sow-social-list-item"><a class="mm_sow-twitter" href="' . esc_url( $twitter_url ). '" target="_blank" title="' . __("Subscribe to Twitter Feed", 'mm_sow') . '"><i class="fa fa-twitter" aria-hidden="true"></i></a></div>';
        if ( $linkedin_url )
            echo '<div class="mm_sow-social-list-item"><a class="mm_sow-linkedin" href="' . esc_url( $linkedin_url ) . '" target="_blank" title="' . __("View LinkedIn Profile", 'mm_sow') . '"><i class="fa fa-linkedin" aria-hidden="true"></i></a></div>';
        if ( $googleplus_url )
            echo '<div class="mm_sow-social-list-item"><a class="mm_sow-googleplus" href="' . esc_url( $googleplus_url ) . '" target="_blank" title="' . __("Follow on Google Plus", 'mm_sow') . '"><i class="fa fa-google-plus" aria-hidden="true"></i></a></div>';
        if ( $instagram_url )
            echo '<div class="mm_sow-social-list-item"><a class="mm_sow-instagram" href="' . esc_url( $instagram_url ) . '" target="_blank" title="' . __("View Instagram Feed", 'mm_sow') . '"><i class="fa fa-instagram" aria-hidden="true"></i></a></div>';
        if ( $pinterest_url )
            echo '<div class="mm_sow-social-list-item"><a class="fa fa-pinterest-p" href="' . esc_url( $pinterest_url ) . '" target="_blank" title="' . __("Subscribe to Pinterest Feed", 'mm_sow') . '"><i class="mm_sow-icon-pinterest" aria-hidden="true"></i></a></div>';
        if ( $dribbble_url )
            echo '<div class="mm_sow-social-list-item"><a class="mm_sow-dribbble" href="' . esc_url( $dribbble_url ) . '" target="_blank" title="' . __("View Dribbble Portfolio", 'mm_sow') . '"><i class="fa fa-dribbble" aria-hidden="true"></i></a></div>';

        ?>

    </div>

</div>
