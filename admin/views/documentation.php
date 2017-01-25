<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Theme info
$plugin = get_plugin_data(MM_SOW_PLUGIN_FILE);


if (is_multisite()) {
    $soPageBuilderUrl = network_admin_url('plugin-install.php?tab=plugin-information&plugin=siteorigin-panels&TB_iframe=true&width=640&height=589');
    $soWidgetsBundleUrl = network_admin_url('plugin-install.php?tab=plugin-information&plugin=so-widgets-bundle&TB_iframe=true&width=640&height=589');
    $portfolioPostTypeUrl = network_admin_url('plugin-install.php?tab=plugin-information&plugin=portfolio-post-type&TB_iframe=true&width=640&height=589');
}
else {
    $soPageBuilderUrl = admin_url('plugin-install.php?tab=plugin-information&plugin=siteorigin-panels&TB_iframe=true&width=640&height=589');
    $soWidgetsBundleUrl = admin_url('plugin-install.php?tab=plugin-information&plugin=so-widgets-bundle&TB_iframe=true&width=640&height=589');
    $portfolioPostTypeUrl = admin_url('plugin-install.php?tab=plugin-information&plugin=portfolio-post-type&TB_iframe=true&width=640&height=589');
}

?>

<div class="micemade-doc">

    <h2 class="notices"></h2>

    <div class="intro-wrap">
	
	
		<img src="<?php echo esc_url(MM_SOW_PLUGIN_URL . 'admin/assets/images/mm_so_widgets.jpg')?>">	
       
		<div class="intro">
			
			<h3><?php printf( '<small>' .__('Welcome to', 'mm_sow') .'</small><br>%1$s v%2$s', $plugin['Name'], $plugin['Version']); ?></h3>

            <h4><?php printf(__('Thanks for installing %1$s! We truly appreciate the support and the opportunity to share our work with you. Please visit the tabs below to get started on using our plugin to build your site!', 'mm_sow'), $plugin['Name']); ?></h4>
        </div>

    </div>

    <div class="panels">
        <ul class="inline-list">
            <li class="current">
				<a id="help" href="#">
					<span class="dashicons dashicons-yes"></span> <?php _e('Help &amp; Guide', 'mm_sow'); ?>
				</a>
            </li>
            <li>
				<a id="plugins" href="#"><span
                        class="dashicons dashicons-admin-plugins"></span> <?php _e('Required Plugins', 'mm_sow'); ?>
                </a>
            </li>
            <li><a id="support" href="#"><span
                        class="dashicons dashicons-editor-help"></span> <?php _e('FAQ &amp; Support', 'mm_sow'); ?>
                </a>
            </li>
            
        </ul>

        <div id="panel" class="panel">

            <!-- Help file panel -->
            <div id="help-panel" class="panel-left visible">

                <!-- Grab feed of help file -->

                <!-- Output the feed -->
                <ul id="top" class="toc">
                    <li><a href="#getting-started">Getting Started</a></li>
                    <li><a href="#install-plugins">Installing Recommended/Required Plugins</a></li>
                    <li><a href="#plugin-widgets">Working with plugin widgets</a></li>

                    <li><a href="#heading-widget">Heading Widget</a></li>
                    <li><a href="#services-widget">Services Widget</a></li>
                    <li><a href="#team-members">Team Members</a></li>
                    <li><a href="#statistics-widgets">Statistics Widgets</a></li>
                    <li><a href="#testimonials-widgets">Testimonials Widgets</a></li>
                    <li><a href="#posts-carousel">Posts Carousel</a></li>
                    <li><a href="#carousel-widget">Carousel Widget</a></li>
                    <li><a href="#grid-widget">Micemade Grid</a></li>
                    <li><a href="#clients-widget">Clients</a></li>
                    <li><a href="#pricing-table">Pricing Table</a></li>
                    <li><a href="#button-widget">Buttons</a></li>
                    <li><a href="#icon-list">Icon List</a></li>
                    <li><a href="#hero-header">Hero Header</a></li>
                    <li><a href="#tabs-accordions">Tabs and Accordions</a></li>
                    <li><a href="#stretcher">Stretcher (posts and custom posts)</a></li>
                    <li><a href="#wc-categories">WooCommerce Categories</a></li>


                </ul>
                <h3 id="getting-started">Getting Started<a class="back-to-top" href="#panel"><span
                            class="dashicons dashicons-arrow-up-alt2"></span> Back to top</a></h3>
                <p>Thanks for choosing our plugin for SiteOrigin widgets. This help file aims to provide you with all the information you need to make the best use of this powerful plugin. The aim of the plugin to make the task of building a website effortless and pleasurable. Towards that end, we have built a number of widgets most commonly used across most of the websites of small businesses, corporates, design agencies, freelancers, artists etc.</p>
<p>Do follow the steps below to get started - </p>
                <ol>
                    <li>Install and activate the <strong>required plugin</strong> <a
                            href="https://wordpress.org/plugins/so-widgets-bundle/" rel="nofollow" target="_blank">SiteOrigin
                            Widgets
                            Bundle</a>.
                    </li>
                    <li>Unzip the downloaded micemade-so-widgets.zip file and upload to the <code>/wp-content/plugins/</code>
                        directory or upload the plugin zip with the help of Plugins→Installed Plugins→Add New button.<br>
                        Activate the plugin through the 'Plugins' menu in WordPress. If you are viewing this help page
                        in WordPress admin under Micemade Widgets→Documentation, you have already activated the plugin.
                    </li>
                    <li>Enable all the widgets you need from <strong> <a
                                href="<?php echo admin_url() . 'plugins.php?page=so-widgets-plugins'; ?>"
                                target="_blank"><?php echo __('Plugins → SiteOrigin Widgets', 'mm_sow') ?></a></strong>.
                        Alternatively you can
                        visit <strong> <a href="<?php echo admin_url() . 'admin.php?page=micemade_so_widgets'; ?>"
                                          target="_blank"><?php echo __('Micemade Widgets→Settings', 'mm_sow') ?></a></strong>
                        and check the box 'Activate all plugin widgets' option - that
                        will activate all of the widgets part of the plugin. The widgets can be selectively deactivated
                        later in <strong> <a href="<?php echo admin_url() . 'plugins.php?page=so-widgets-plugins'; ?>"
                                             target="_blank"><?php echo __('Plugins → SiteOrigin Widgets', 'mm_sow') ?></a></strong>.
                    </li>
                    <li>If you need page builder functions, install and activate the <strong>optional plugin</strong> <a
                            href="https://wordpress.org/plugins/siteorigin-panels/" rel="nofollow" target="_blank">Page
                            Builder by
                            SiteOrigin</a>. To get most of this plugin, we highly recommend you install the page
                        builder.
                    </li>
                   
                </ol>

                <hr>
                <h3 id="install-plugins">Installing Recommended/Required Plugins<a class="back-to-top"
                                                                                   href="#panel"><span
                            class="dashicons dashicons-arrow-up-alt2"></span> Back to top</a></h3>
                <p>Below is a list of recommended plugins to install that will help you get the most out of this plugin.
                    Although many of these plugins are optional, we recommend that you install these popular plugins if
                    you plan to get most out of this plugin.</p>
                
				<p>These plugins are also listed in the Plugins tab of this help file under Micemade Widgets →
                    Documentation, and you can install the plugins directly from there.</p>
                <ul>
                    <li>
					<strong>SiteOrigin Page Builder</strong> is one of the most popular page builder plugins for WordPress.
                        It makes it easy to create responsive column based content, using WordPress widgets including
                        those created by Micemade SO Widgets plugin. All of the pages of our demo site for
                        the plugin have been built using this page builder. <strong>You should install and activate this plugin
                        if you plan to replicate the plugin demo site by importing the sample data provided</strong>.
                        <p><a href="https://wordpress.org/plugins/siteorigin-panels/" target="_blank">More about SiteOrigin Page Builder →</a>
						</p>
					</li>
						
					<li><strong>SiteOrigin Widgets Bundle</strong> is a powerful framework for building WordPress
                        widgets with support for advanced forms, unlimited colors and 1500+ icons. Widgets built using
                        this framework can be used in a page builder page or any widgetized area of your site like the
                        sidebar or footer.
                        <p>All of the widgets part of Micemade SO Widgets plugin were created using this
                            framework and hence <strong>this plugin must be installed and activated on the site for this plugin
                            to function</strong>.</p>
                        <p><a href="https://wordpress.org/plugins/so-widgets-bundle/" target="_blank">More about SiteOrigin Widgets Bundle →</a></p>
					</li>
                    
                    
                </ul>

                <hr>
				
                <h3 id="plugin-widgets">Working with plugin widgets<a class="back-to-top" href="#panel"><span
                            class="dashicons dashicons-arrow-up-alt2"></span> Back to top</a></h3>

                <ul>
                    <li>If you plan to use the <a href="https://wordpress.org/plugins/siteorigin-panels/" target="_blank">SiteOrigin Page Builder</a> to build your site (recommended) and new to its
                        functions, make sure you checkout the <a
                            href="https://siteorigin.com/page-builder/documentation/"
                            title="SiteOrigin Page Builder Documentation" target="_blank">documentation of the page builder</a> before
                        starting to use this plugin.
                    </li>

                    <li>As mentioned earlier, Micemade SO Widgets plugin is built on a powerful widget builder framework of <a href="https://wordpress.org/plugins/so-widgets-bundle/"
                                  title="SiteOrigin Widgets Bundle" target="_blank">SiteOrigin Widgets Bundle</a> plugin. If you need
                        more information about this plugin or need help with it, go through the <a
                            href="https://siteorigin.com/widgets-bundle/"
                            title="SiteOrigin Widgets Bundle documentation" target="_blank">SiteOrigin Widgets Bundle documentation</a>.
                    </li>

                    <li>Once the Micemade SO Widgets plugin is activated, you should see a menu item <strong> <a href="<?php echo admin_url() . 'admin.php?page=micemade_so_widgets'; ?>"
                                            target="_blank"><?php echo __('Micemade Widgets', 'mm_sow') ?></a></strong> in WordPress admin with two sections - Settings and Documentation .
                        
						<hr>
                        <p><strong> <a href="<?php echo admin_url() . 'admin.php?page=micemade_so_widgets'; ?>"
                                       target="_blank"><?php echo __('Micemade Widgets→Settings', 'mm_sow') ?></a></strong> - The settings screen for the plugin is self-documenting with minimal
                        options. If you need the plugin widgets auto activated by default, you can check the option
                            <strong>'Activate all plugin widgets'</strong> option. This will avoid you having to go to  <a href="<?php echo admin_url() . 'plugins.php?page=so-widgets-plugins'; ?>" target="_blank"><?php echo __('Plugins → SiteOrigin Widgets', 'mm_sow') ?></a> screen (see below) and activate the plugin widgets individually. Once auto activate is enabled via
                        Settings, you can still deactivate widgets by reaching Plugins→SiteOrigin Widgets.</p>

                    </li>

                    <li>
						<strong> 
						<a href="<?php echo admin_url() . 'plugins.php?page=so-widgets-plugins'; ?>" target="_blank">
						<?php echo __('Plugins → SiteOrigin Widgets', 'mm_sow') ?></a></strong> - This is the admin page for deactivation and
                        activation of all widgets created using the framework built by SiteOrigin Widgets Bundle. If you
                        have the option 'Activate all plugin widgets' option in <a href="<?php echo admin_url() . 'admin.php?page=micemade_so_widgets'; ?>" target="_blank"><?php echo __('Micemade Widgets→Settings', 'mm_sow') ?></a> screen above unchecked, you
                        will need to activate each of the widgets defined by the plugin.

                        
                    </li>

                    <li>Once a SiteOrigin widget is activated (or auto activated), the widgets are available in
                        <strong><a href="<?php echo admin_url() . 'widgets.php'; ?>"
                           target="_blank"><?php echo __('Appearance→Widgets', 'mm_sow') ?></a></strong> screen for drag and drop into widgetized areas defined by the theme
                        activated on your site.
                        
                    </li>

                    <li>
						The activated widgets also become available for drag and drop in the SiteOrigin Page builder. In
                        the Page edit window, click on the <strong>'Page Builder'</strong> tab to bring up the page builder controls on the page edit screen.
                       
                    </li>

                    <li>
						To add a Micemade widget, just click on the <strong>'Add Widget'</strong> button to bring up the 'Add New Widget'popup screen of the page builder. The plugin widgets are grouped under <strong>'Micemade SiteOrigin Widgets'</strong> tab on the left. Click on a widget listed on the right closes the popup and adds the widget to the page builder.
                      
                    </li>

                    <li>
						Hovering over the widget added to the page builder, you can view the Edit link. Clicking the
                        widget also brings up the edit/configure screen of a widget. <strong>Most of the widget options are
                        self-documented</strong> but additional help is provided in the below sections for each of the Micemade
                        widgets.

                        <p>Once the data required for configuring a widget is entered, you can preview the changes by
                        clicking on the <strong>'Preview'</strong> button.</p>

                        <p>Click on the <strong>'Done'</strong> button once the required data is provided for the widget and you are done
                        with previewing.</p>
                      

                    </li>

                    <li>
						After you hit the <strong>Update</strong> or <strong>Publish</strong> button on the page,the widget is then ready for viewing on the frontend page.
                        

                    </li>

                </ul>


                <p>The below sections provide help on each of the widgets built as part of <strong>Micemade SO Widgets</strong>
                    plugin.</p>

                <hr>
                
				<h3 id="heading-widget">Heading Widget<a class="back-to-top" href="#panel"> Back to top</a></h3>
                
                <p>The heading widget is perhaps the most frequently used widget on a page since it displays a heading
                    at the top of a section.</p>
                <p>It comes in three styles – Style 1, Style 2 and Style 3 which allow variations of headings displayed
                    in various sections.</p>

                <p>The heading consists of the main heading text which is renders as one of the HTML heading tags on the
                    frontend. Additionally, a short text is displayed below the heading and some of the heading styles
                    allow you to input a subtitle which is usually displayed on top of the main heading title.</p>
                <p>You can choose to align the heading left, right or center with center being the default
                    alignment.</p>
              
			  
                <hr>
				
				
				
                <h3 id="services-widget">Services Widget<a class="back-to-top" href="#panel"> Back to top</a></h3>
                

                <p>Many agencies, freelancers, corporates, products/apps require capturing the services provided by the agency or the features of a product. The services widget is designed to help users capture these services or features in a multi-column grid.</p>
                <p>
				The widget supports about 3 different styles and each of these styles can be customized further by choosing the type of icon desired to represent the service – a font icon or an custom image icon. While the choice of font icons is huge in number and perhaps sufficient for most common services, the icon images can help present the unique nature of the services offered.
				</p>
				
                <p>Each of the service requires you to input a title for the service/feature and a short description of the service offered or the product feature. Additionally, each service allows you to enter a font icon or an icon image file to represent that service.</p>
               

                <p>Services widget supports the following options –</p>
                <ul>
                    <li><strong>Columns per row</strong> – Number of services to display per row of services.</li>
                    <li><strong>Icon Custom Size</strong> – If the icon chosen for services is icon font, you can
                        specify a custom size for the font icon in pixels.
                    </li>
                    <li><strong>Icon Custom Color</strong> – Specify a custom color for the font icon.</li>
                    <li><strong>Icon Custom Hover Color</strong> – Specify a custom hover color for the font icon.</li>
                </ul>


                <hr>
				
				
                <h3 id="team-members">Team Members<a class="back-to-top" href="#panel"> Back to top</a></h3>

                <p>This widget provides an easy way to capture the team members of your organization or an agency. The
                    details captured include team member name, position, a short description and the email plus social
                    profile of the individual team members.</p>
               

                <hr>
				
				
                <h3 id="statistics-widgets">Statistics Widgets<a class="back-to-top" href="#panel"> Back to top</a></h3>


                <p>The plugin features a number of widgets that help display statistical information in the form of
                    odometers, piecharts and stats bars. </p>
                <p>Most of these widgets are designed to animate the display of the statistical information or numbers
                    when the users scroll down to the section containing the widget.</p>
				
				
				<hr>
				
				
				
                <p><strong>Odometers</strong></p>
          

                <p>This widget displays one or more animated odometer statistics in a multi-column grid. This number
                    statistic requires a start and an end value with a title and icon providing the information about
                    what the number represents – like a download number or number of products sold or customers
                    gained.</p>
                <p>The widget animates from the start value to the end value when the user scrolls down to the section.
                    You can control the number of such odometers displayed per row.</p>
               
				<hr>
				
                <p><strong>Stats Bars</strong></p>
               

                <p>Stats Bars capture percentage statistics like coverage area, skills gained, survey findings, usage
                    statistics etc. that typically require bar charts to represent them. Each statistical item requires
                    a percentage value, a title describing the number. The user can choose to display the bar charts in
                    multiple or single color with the help of color choice available with each value input.</p>
                <p>The widget animates from the zero to the percentage value set for the item when the user scrolls down
                    to the section containing the widget. The bars are placed one below the other horizontally.</p>
                
				<hr>

                <p><strong>Piecharts</strong></p>
                <p>Piecharts provide an alternative way to display percentage stats. When the users scrolls down and the
                    chart becomes visible, the widget animates from zero to percentage value provided for the statistic.
                    A bar of user chosen color moves along a track to display the percentage information. An option to
                    specify the number of charts displayed per row is provided.</p>
                

                <hr>
				
                <h3 id="testimonials-widgets">Testimonials Widgets<a class="back-to-top" href="#panel"> Back to top</a></h3>
               

                <p>The plugin features two widgets for capturing testimonials received for your product or business or
                    services. Most agencies, corporates, small businesses, freelancers and products/apps require
                    testimonials to displayed prominently on the site to help convert visitors to customers. The two
                    widgets provided are elegantly designed to achieve greater conversion rate.</p>
                <p>The testimonials information include details about the person/company endorsing the product/service;
                    details like name, company, website of this person/organization along with an image representing
                    this person/entity.</p>
                <p><strong>Testimonials</strong></p>
                <p>The regular <strong>testimonials widget</strong> displays multiple testimonials in a row with the
                    user having the option to specify the number of items per row. This is useful if you need a large
                    number of testimonials to be visible instantly when the user scrolls down to view the testimonials
                    section.</p>
                
			
                <p><strong>Testimonials Slider</strong></p>
               
                <p>The <strong>testimonials slider widget</strong> is useful for display of endorsements/recommendations
                    with large amount of text for each testimonial. The slider displays the testimonials as a slideshow
                    with multiple widget options provided to control/customize this slideshow – options like speed of
                    switching, speed of animation, whether to pause the slideshow on hover, controls needed for manual
                    navigation by the user etc. The slider is completely responsive and touch swipe controls available
                    for easy navigation on smartphones/tablets.</p>
                

				
                <hr>
				
				
                <h3 id="posts-carousel">Posts Carousel<a class="back-to-top" href="#panel"> Back to top</a></h3>
                

                <p>The responsive carousel helps display posts or any custom post types like your portfolio entries with
                    controls available for easy navigation of the items displayed. The widget features a Posts Query
                    window to help choose posts or custom posts to display. This powerful tool has number of fields to
                    control what gets displayed and in what order with an additional field available to provide query
                    arguments explained in the <a href="https://codex.wordpress.org/Class_Reference/WP_Query">codex page</a>.
				</p>
				

                <p>The Posts Query tool has the following options for filtering posts –</p>
                <ol>
                    <li><strong>Post Type</strong> – Select the custom post type that you need the widget for. By
                        default “All” is selected.
                    </li>
                    <li><strong>Post In</strong> – This field enabled you to specify the post ids of the posts or custom
                        post types you would like to include in your widget. If you do not know the IDs, you can click
                        on the ‘Select Posts’ button to bring up popup that can be used to search and select the
                        specific posts of the post type selected above.
                    </li>
                    <li><strong>Taxonomies</strong> – If you need to filter the posts by specific category or taxonomy
                        terms, you can specific the same here. The field autocompletes the terms you type in here.
                    </li>
                    <li><strong>Date Range</strong> – Specific a date range for filtering the posts – only those posts
                        published during this period will be chosen for display by the widget.
                    </li>
                    <li><strong>Order By</strong> – Lets you decide on how you want the posts to be ordered – by
                        Published Date, by Post ID, by Menu Order etc. and whether you want the ordering by Ascending or
                        Descending.
                    </li>
                    <li><strong>Posts Per Page</strong> – Set the number of posts you wish you display in the widget. If
                        the widget does not support pagination, the number of posts chosen by the limited by the number
                        specified here. This is also the number of posts to display per page when the widget supports
                        pagination as is the case with Micemade Grid widget. Choosing the value zero makes the widget
                        all the selected posts.
                    </li>
                    <li><strong>Sticky Posts</strong> – Tell the widget to ignore, exclude or include the sticky posts.
                    </li>
                    <li><strong>Additional</strong> – You may specify any additional query parameters here as documented
                        in the <a href="https://codex.wordpress.org/Class_Reference/WP_Query">codex page</a>. These
                        parameters will be applied in addition to the query parameters generated from the values
                        specified in the above fields.
                    </li>
                </ol>
                

                <p>The posts carousel has numerous other options to control the display of posts or custom post types.
                    Some of these are –</p>
                <ul>
                    <li><strong>Choose Taxonomy to display info</strong> – When the post info is displayed, the specific
                        taxonomy you want the info to use. For example, choosing category will display category
                        information for a posts while choosing ‘post_tag’ would display the tag information for posts.
                    </li>
                    <li><strong>Link images to Posts</strong> – Make the images link to the posts or custom post types
                        they represent.
                    </li>
                    <li><strong>Display post titles</strong> – Checking this box will display post title below the
                        featured image for the posts or custom post type.
                    </li>
                    <li><strong>Display post excerpt/summary</strong> – Display summary information for the posts below
                        the featured image and post title.
                    </li>
                    <li><strong>Post Meta</strong> – Display post meta information like published date, author name,
                        taxonomy information below the posts. The specific taxonomy chosen above under “Choose Taxonomy
                        to display info” will be used for display taxonomy information.
                    </li>
                </ul>
              

                <p><strong>Carousel Settings</strong> – This section has options that control how the carousel is
                    displayed. Options include autoplay speed, gutter value between post items in various resolutions,
                    navigation controls for carousel, number of columns or items to display before making the user to
                    scroll for additional items etc.</p>
                <ul>
                    <li><strong>Prev/Next Arrows</strong> – Display navigation for the carousel.</li>
                    <li><strong>Show dot indicators for navigation</strong> – Display control navigation or pagination
                        controls for the carousel.
                    </li>
                    <li><strong>Autoplay</strong> – Display carousel as a slideshow.</li>
                    <li><strong>Autoplay speed in ms</strong> – The time between display of each page of images when
                        Autoplay option is enabled.
                    </li>
                    <li><strong>Autoplay animation speed in ms</strong> – The time taken for animation that moves the
                        carousel to next or previous page of items.
                    </li>
                    <li><strong>Pause on mouse hover</strong> – Pause the slideshow if the user has mouse hovered over
                        the carousel contents.
                    </li>
                    <li><strong>Columns per row</strong> – Number of gallery items visible at any given point of time
                        without scrolling.
                    </li>
                    <li><strong>Columns to scroll</strong> – With each scroll action – using the prev/next arrows or the
                        dotted navigation, specify the number of items to scroll for each invocation of the navigation
                        controls.
                    </li>
                    <li><strong>Gutter</strong> – The spacing in pixels between images/videos in the carousel.</li>
                </ul>

				
                <hr>
				
				
                <h3 id="carousel-widget">Carousel<a class="back-to-top" href="#panel"> Back to top</a></h3>
               

                <p>Micemade Carousel is a generic carousel of custom HTML content of your choice. Possibilities are endless – image
                    carousels with textual content describing the images, video carousels, event carousels with link to
                    the events, a carousel of team of volunteers, a collection of books sold on Amazon etc.</p>
               

                <p>If you need a carousel of custom content HTML of your choice, this widget helps achieve the same. For
                    the HTML content, you will need to provide your own custom CSS under Settings for the carousel.
                    While posts carousel helps you display carousel items derived from posts or custom post types, this
                    widget lets you display any well-formed HTML content as items in a carousel. You may use the
                    WordPress visual editor to construct the required content. </p>
                

                <p>The section "Carousel Settings" has options that control how the carousel is displayed. Options
                    include autoplay speed, gutter value between post items in various resolutions, navigation controls
                    for carousel, number of columns or items to display before making the user to scroll for additional
                    items etc. The carousel settings are explained in the help section above for Posts Carousel.</p>
               

			  
			  <hr>
                
				
				
				<h3 id="grid-widget">Micemade Grid<a class="back-to-top" href="#panel"> Back to top</a></h3>
                

                <p>Perhaps the most popular and most important of all widgets part of all widgets part of this plugin,
                    Micemade Grid helps you build a multi-column grid of posts or custom post types. The posts displayed
                    are filterable by taxonomy terms.</p>

                
                <p>Using the Grid widget, you can construct a portfolio of your posts/products or other post types. </p>

                
                <p>The widget features a Posts Query window to help choose posts or custom posts to display. This
                    powerful tool has number of fields to control what gets displayed and in what order with an
                    additional field available to provide query arguments explained in the <a
                        href="https://codex.wordpress.org/Class_Reference/WP_Query">codex page</a>.</p>

                <p>The Posts Query tool has the following options for filtering posts –</p>
                <ol>
                    <li><strong>Post Type</strong> – Select the custom post type that you need the widget for. By
                        default “All” is selected. To construct a grid of blog posts, products or other post types choose on of the Post Types.
                    </li>
                    <li><strong>Post In</strong> – This field enabled you to specify the post ids of the posts or custom
                        post types you would like to include in your widget. If you do not know the IDs, you can click
                        on the ‘Select Posts’ button to bring up popup that can be used to search and select the
                        specific posts of the post type selected above.
                    </li>
                    <li><strong>Taxonomies</strong> – If you need to filter the posts by specific category or taxonomy
                        terms, you can specific the same here. The field autocompletes the terms you type in here.
                    </li>
                    <li><strong>Date Range</strong> – Specific a date range for filtering the posts – only those posts
                        published during this period will be chosen for display by the widget.
                    </li>
                    <li><strong>Order By</strong> – Lets you decide on how you want the posts to be ordered – by
                        Published Date, by Post ID, by Menu Order etc. and whether you want the ordering by Ascending or
                        Descending.
                    </li>
                    <li><strong>Posts Per Page</strong> – Set the number of posts you wish you display in the widget. If
                        the widget does not support pagination, the number of posts chosen by the limited by the number
                        specified here.&nbsp;<strong>This is also the number of posts to display per page when the
                            widget supports pagination as is the case with Micemade Grid widget.</strong> Choosing the
                        value zero makes the widget all the selected posts.
                    </li>
                    <li><strong>Sticky Posts</strong> – Tell the widget to ignore, exclude or include the sticky posts.
                    </li>
                    <li><strong>Additional</strong> – You may specify any additional query parameters here as documented
                        in the <a href="https://codex.wordpress.org/Class_Reference/WP_Query">codex page</a>. These
                        parameters will be applied in addition to the query parameters generated from the values
                        specified in the above fields.
                    </li>
                </ol>
         

                <p>The grid widget has numerous other options to control the display of posts or custom post types. Some
                    of these are –</p>

                <ul>
                    <li><strong>Choose Taxonomy to display and filter on</strong> – The terms of this taxonomy chosen
                        will be used for filtering the posts if ‘Filterable’ option is checked. When the post info is
                        displayed, the specific taxonomy you want the info to use. For example, choosing category will
                        make the posts filterable on category while choosing ‘post_tag’ would make the posts filterable
                        by post tags instead of category.
                    </li>
                    <li><strong>Choose a Layout for the grid</strong> – You may choose Masonry or Fit Rows layout for
                        the grid.
                    </li>
                    
                    <li><strong>Link images to Posts/Portfolio</strong> – Make the post images link to the posts or
                        custom post types they represent.
                    </li>
                    
                    <li><strong>Display post titles</strong> – Checking this box will display post/portfolio
                        entry title below the featured image for the posts or custom post type.
                    </li>
                    <li><strong>Display post/portfolio excerpt/summary</strong> – Display summary information for the
                        posts/portfolio items below the featured image and post title.
                    </li>
                    <li><strong>Post Meta</strong> – Display post meta information like published date, author name,
                        taxonomy information below the posts. The specific taxonomy chosen above under “Choose Taxonomy
                        to display and filter on” will be used for display taxonomy information.
                    </li>
                    <li><strong>Columns per row</strong> – The number of posts/portfolio items to display in each row on
                        desktop.
                    </li>
                    <li><strong>Gutter options</strong> – The spacing in pixels between each entry in the grid. If you
                        need a packed layout, specify zero here.
                    </li>
                </ul>


				
                <hr>
                
				
				
				<h3 id="clients-widget">Clients<a class="back-to-top" href="#panel"> Back to top</a></h3>

                <p>Whether you are freelancer or run a small business, agency or represent a big corporate house, you
                    have a list of clients that you have worked with. This widget lets you create a list of these
                    clients with banner images representing these clients.</p>

                <p>For each of the client, you provide a client name, a banner image for the client and a URL for their
                    website. The client name is shown on user hovering over the banner image and title text is
                    optionally a link pointing to the website of the client, if that link is provided by the user.</p>
                <p>The collection of clients will be displayed in a multi-column grid. The ‘Columns per Row’ option lets
                    you control the number of client entries per row of clients displayed.</p>

					
                <hr>
				
				
                <h3 id="pricing-table">Pricing Table<a class="back-to-top" href="#panel"> Back to top</a></h3>

                <p>The pricing plans offered by your business can be captured with pricing plan widget. The pricing
                    plans are displayed in a multi-column grid.</p>

                <p>For each of the pricing plan, provide the following information –</p>
                <ul>
                    <li><strong>Pricing Plan Title</strong> – The title for the pricing plan like Standard, Premium,
                        Developer etc.
                    </li>
                    <li><strong>Tagline Text</strong> – Provide any subtitle or taglines like “Most Popular”, “Best
                        Value”, “Best Selling”, “Most Flexible” etc. that you would like to use for this pricing plan.
                        Usually displayed above the pricing plan title.
                    </li>
                    <li><strong>Image</strong> – Optional image or icon to represent the pricing plan.</li>
                    <li><strong>Price Tag</strong> – This is where you specify the actual price tag for the plan along
                        with the currency. HTML is allowed.
                    </li>
                    <li><strong>Text for Pricing Link/Button</strong> – Specify the text for the link or a button
                        displayed at the bottom of the pricing plan. This link takes the user to the purchase page.
                    </li>
                    <li><strong>URL for the Pricing link/button</strong> – Provide the target URL for the link or the
                        button shown for this pricing plan. This link takes the user to the purchase page. Check the
                        option ‘Open Button URL in a new window’ if you need the link to open the target page in a new
                        tab or window of the browser.
                    </li>
                    <li><strong>Highlight Pricing Plan</strong> – Specify if you want to highlight the pricing plan.
                        This would be most likely plan your user would choose to sign up for.
                    </li>
                    <li><strong>Pricing Columns per row</strong> – The number of pricing plans to display per row of
                        plans. Most businesses choose to fit in all of their plans into a single row.
                    </li>
                </ul>


                <hr>
				
				
				
                <h3 id="button-widget">Buttons<a class="back-to-top" href="#panel"> Back to top</a></h3>
               

                <p>The plugin lets you create buttons of multiple colors that you would use in your site. The supported
                    colors are Orange, Blue, Teal, Cyan, Green, Pink, Black, Red, Transparent and Semi Transparent (for
                    dark backgrounds). You can choose a custom color and custom hover color too for the button to create
                    a button of your chosen color.</p>

                <p>Additional options provided are button size, rounded and alignment – center, right, left and
                    None.</p>
                <p>You can choose to display an icon along with the button text. The icon can be a icon font or an
                    image.</p>
                
				

                <hr>
				
				
				
                <h3 id="icon-list">Icon List<a class="back-to-top" href="#panel"> Back to top</a></h3>
                

                <p>The icon list widget is extremely useful for creating a list of icons with optional links to sites or
                    pages that the icons represent. Examples include social media profiles, icon lists representing
                    payment options or download platforms or a quick summary of services.</p>
                <p>Each of the icons part of a list have a title, optional target URL and the icon itself can be a font
                    icon or an custom image. The title for the icon is displayed as a tooltip on mouse hover.</p>
               

                <p>Following options are available –</p>
                <ul>
                    <li><strong>Icon/Image size in pixels</strong> – Custom size of the icons displayed.</li>
                    <li><strong>Icon color</strong> – If the icons chosen are font icons, you may specify a custom color
                        for the icons.
                    </li>
                    <li><strong>Icon hover color</strong> – The color of the font icons on mouse hover.</li>
                    <li><strong>Open the links in new window</strong> – If a target URL is specified for a link, whether
                        the links should open in a new window.
                    </li>
                    <li><strong>Alignment</strong> – The icon list can be chosen to align at the center, left, right of
                        it’s position in a page.
                    </li>
                </ul>
                
				
                <hr>
				
				
				
                <h3 id="hero-header">Hero Header<a class="back-to-top" href="#panel"> Back to top</a></h3>
                

                <p>Hero Headers are popular way to drive across a message, market your products or work, create a call
                    to action for the user etc. Hero headers are often used at the top of a page. With the Hero Image
                    widget, you can display hero header content with option to set HTML5/YouTube video or parallax image
                    background.</p>

                <p>Header Type – The widget provides option of a built-in standard header content and a custom one where
                    you provide the HTML for the header and the required CSS to style the HTML of the header content.
                    While standard header should meet the requirements of most sites, the custom one is the one to
                    choose for creating more creative headlines.</p>
                <p>The standard header consists of following –</p>
                <ul>
                    <li><strong>Header text</strong> – The heading title for the hero header, displayed as a Heading tag
                        on the frontend.
                    </li>
                    
                    <li><strong>Sub-heading text(Optional)</strong> – A small sized subheading displayed above the main
                        heading.
                    </li>
					
                    <li><strong>Button text</strong> – If the hero header represents a call to action or simply want to
                        provide to another page with related content, you will need a button to be displayed below the
                        main heading. You can provide the text for the button. Examples include ‘Purchase Now’, ‘Contact
                        Us’ etc.
                    </li>
                    <li><strong>Button URL</strong> – The URL to which the button anchor points to.</li>
                    <li><strong>Open URL in a new window</strong> – Whether to open the link in a new window of the
                        browser.
                    </li>
                </ul>

                <p>The custom header lets you build a custom header of your own and requires input of the following
                    –</p>
                <ul>
                    <li><strong>Custom HTML</strong> – The custom HTML content with the header information for the hero
                        header.
                    </li>
                    <li><strong>Custom CSS</strong> – The custom CSS to be applied to the custom HTML header information
                        provided above. Will be embedded inline with the page.
                    </li>
                </ul>
              
                <p>Further options for Hero Image include –</p>
                <ul>
                    <li><strong>URL for Pointer Down</strong> – This option is used for the hero header displayed at the
                        top of a page. If an internal URL for the pointer down is specified, the hero image will sport a
                        pointer down indicator to help user scroll to the section indicated by this URL.
                    </li>
                    <li><strong>Background Type</strong> – The hero image’s power lies in its ability to display
                        multiple types of background – cover image, parallax image, YouTube video or HTML5 Video as
                        background.&nbsp;For both image as well as video backgrounds, a background image must be
                        specified. This image will be the background image for the hero header and if a video background
                        is specified, will act as a placeholder image for the background until the video is loaded or if
                        the video cannot be autoloaded as in the case of mobile devices.
                    </li>
                    <li><strong>Background Overlay</strong> – Specify a overlay color for the image/video background and
                        the opacity for the overlay applied to the image/video. The overlay is used to enhance the
                        visual impact of the hero header and help display the header content more prominently.
                    </li>
                    <li><strong>Top and Bottom Padding</strong> – The top and bottom padding specified in pixels decide
                        how big the hero image gets on the frontend. This is the padding applied on top and bottom of
                        the header content displayed. You can specific the padding for various device resolutions. The
                        height of the hero header is typically smaller in lower resolutions and in mobile devices.
                    </li>
                </ul>


                <hr>
				
				
                <h3 id="tabs-accordions">Tabs and Accordions<a class="back-to-top" href="#panel"> Back to top</a></h3>
                

                <p>
				A large of finely designed styles are supported by tabs function of the plugin. Tabs can be of two types – vertical and regular horizontal style tabs.
				</p>
                
                <p>
				There are a total of 10 tab styles to choose from. There is simply no another plugin or theme that supports so many elegant styles for tabs.</p>

                <p>Tabs required two attributes – a tab title and tab content. For styles that support icons, choice of displaying a font icon or an icon image along with the tab title is supported.</p>
                <p>
				Mobile Resolution – Indicate the device resolution in pixels for displaying the tab in responsive mobile mode. The tabs are designed to work well in all device resolutions without sacrificing usability.</p>
                
				<p><strong>Accordions</strong></p>

                <p>Accordions support panels that are collapsed by default. The panels can be opened by clicking on panel title bar.</p>

                <p>Each of the panels part of an accordion require the user to input a tab title and tab content.</p>
                <p>Option to allow multiple panels to be open is provided.</p>

				<hr>
				
				
                <h3 id="stretcher">Stretcher (posts and custom posts)<a class="back-to-top" href="#panel"> Back to top</a></h3>
				
				<p>
				Posts and custom post types <strong>stretcher</strong> displays post items in vertical panels, expandible on hover to display post title, and expands to full width on click to display post excerpt, button to read full post, or shopping buttons ("Add to cart", "Quick view", "Add to wishlist"), if products (WooCommerce) are selected as post type.
				</p>
				
				<hr>
				
				
                <h3 id="wc-categories">WooCommerce categories<a class="back-to-top" href="#panel"> Back to top</a></h3>
				<p>
				WooCommerce categories widget displays WC product categories in grid with category image / titles and products count for each item. Product category images are added in WP admin Products > Categories. If no category image is added, Custom Image field can be used to add image, independently.
				</p>
				
				<hr>
				
				
            </div>

            <!-- Updates panel -->
            <div id="plugins-panel" class="panel-left">
                <h4>Required/Recommended Plugins</h4>

                <p>Below is a list of required/recommended plugins to install that will help you get the most out of the plugin. Except for SiteOrigin Widgets Bundle, the rest of the plugins are optional but we recommend you install these plugin if you plan to replicate the plugin demo site by importing the sample data.</p>

                <hr/>

                <h4><?php _e('SiteOrigin Widgets Bundle', 'mm_sow'); ?>
                    <?php if (!class_exists('SiteOrigin_Widgets_Bundle')) { ?>
                        <a class="button button-secondary thickbox onclick" href="<?php echo esc_url($soWidgetsBundleUrl); ?>"
                           title="<?php esc_attr_e('Install SiteOrigin Widgets Bundle', 'mm_sow'); ?>"><span
                                class="dashicons dashicons-download"></span> <?php _e('Install Now', 'mm_sow'); ?></a>
                    <?php }
                    else { ?>
                        <span class="button button-secondary disabled"><span
                                class="dashicons dashicons-yes"></span> <?php _e('Installed', 'mm_sow'); ?></span>
                    <?php } ?>
                </h4>

                <p><strong>SiteOrigin Widgets Bundle</strong> is a powerful framework for building WordPress
                    widgets with support for advanced forms, unlimited colors and 1500+ icons. Widgets built using
                    this framework can be used in a page builder page or any widgetized area of your site like the
                    sidebar or footer.</p>
                <p>All of the widgets part of Micemade SO Widgets plugin were created using this
                    framework and hence this plugin must be installed and activated on the site for our plugin
                    to function.</p>

                <hr/>

                <h4><?php _e('SiteOrigin Page Builder', 'mm_sow'); ?>
                    <?php if (!defined( 'SITEORIGIN_PANELS_VERSION' ) ) { ?>
                        <a class="button button-secondary thickbox onclick" href="<?php echo esc_url($soPageBuilderUrl); ?>"
                           title="<?php esc_attr_e('Install SiteOrigin Page Builder', 'mm_sow'); ?>"><span
                                class="dashicons dashicons-download"></span> <?php _e('Install Now', 'mm_sow'); ?></a>
                    <?php }
                    else { ?>
                        <span class="button button-secondary disabled"><span
                                class="dashicons dashicons-yes"></span> <?php _e('Installed', 'mm_sow'); ?></span>
                    <?php } ?>
                </h4>

                <p><strong>SiteOrigin Page Builder</strong> is the most popular page builder plugin for WordPress.
                    It makes it easy to create responsive column based content, using WordPress widgets including
                    those created by Micemade SO Widgets plugin. All of the pages of our demo site for
                    the plugin have been built using this page builder. You should install and activate this plugin
                    if you plan to replicate the plugin demo site by importing the sample data provided.</p>

             
            </div><!-- .panel-left -->

            <!-- Support panel -->
            <div id="support-panel" class="panel-left">
                <ul id="top" class="anchor-nav">
                    <li>
                        <a href="#faq-compatibility"><strong>Does it work with the theme that I am using?</strong></a>
                    </li>
                    <li>
                        <a href="#faq-dark-version"><strong>How to enable the dark version for any widget?</strong></a>
                    </li>

                    <li>
                        <a href="#faq-missing-widget"><strong>Seeing 'Missing Widget' error upon import.</strong></a>
                    </li>
                   
                </ul>

                <h3 id="faq-compatibility">Does it work with the theme that I am using?</h3>

                <p>Our tests indicate that the widgets work well with most themes that are well coded. You may need some
                    minor custom CSS with themes that hijack the styling for heading tags by using !important
                    keyword.</p>

                <p>The demo site is best recreated with a theme that supports a full width page template without
                    sidebars. The widgets can still be used in the widgetized sidebars of pages of default template.</p>


                <hr/>

                <h3 id="faq-dark-version">How to enable the dark version for any widget?</h3>

                <p>In SiteOrigin page builder, add a row wrapper for the widget, edit row and check the option 'Dark
                    Background?' under 'Row Styles' &gt; Design.</p>

                <p>If not using a page builder, you can wrap the widget with a div of class 'mm_sow-dark-bg' to invoke
                    dark version. Make sure you set the appropriate dark background for the wrapper div.</p>

                <hr/>

                <h3 id="faq-missing-widget">Seeing 'Missing Widget' error upon import.</h3>

                <p>Please make sure the <a href="https://wordpress.org/plugins/so-widgets-bundle/" title="SiteOrigin Widgets Bundle">SiteOrigin Widgets Bundle</a> plugin is installed/activated and enable the widgets
                    from Plugins &gt; SiteOrigin Widgets in WordPress admin.
                </p>

                <hr/>
            </div><!-- .panel-left support -->

      
           
        </div><!-- .panel -->
    </div><!-- .panels -->
</div><!-- .micemade-doc -->
