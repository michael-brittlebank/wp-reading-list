<?php function renderImage()
{
    global $wprl_options;
    global $post;
    $worklink = get_post_meta($post->ID, "wprl_link", true);
    $includeHyperlink = $worklink && $wprl_options['show_url'];
    $image_src = $wprl_options['cover_image'];
    if (has_post_thumbnail()) {
        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    }
    if ($includeHyperlink) { ?>
        <a href="<?php echo esc_url($worklink) ?>" target="_blank">
            <img class="wprl-entry-image" src="<?php echo esc_url($image_src); ?>"/>
        </a>
    <?php } else { ?>
        <img class="wprl-entry-image" src="<?php echo esc_url($image_src); ?>"/>
    <?php }
}

function renderExcerpt()
{
    global $wprl_options;
    if ($wprl_options['show_list_excerpt']) { ?>
        <p><?php echo wprl_custom_excerpt(55); ?></p>
    <?php }
}

function renderTitle() {
    global $wprl_options;
    global $metapost;
    global $isArchive;
    $title = get_the_title($metapost->ID);
    $permalink = get_permalink($metapost->ID);
    if ($isArchive && $wprl_options['show_single_work']) { ?>
        <a href="<?php echo($permalink); ?>">
            <h2 class="wprl-entry-title">
                <?php echo($title); ?>
            </h2>
        </a>
    <?php } else { ?>
        <h2 class="wprl-entry-title">
            <?php echo($title); ?>
        </h2>
    <?php }
}

function renderAuthors() {
    global $wprl_options;
    global $metapost;
    $authorlist = get_the_terms($metapost->ID, 'work-author');
    if ($wprl_options['show_author'] && $authorlist) {
        $formattedAuthorlist = "";
        $j = 1;
        $k = 0;
        $numItems = count($authorlist);
        foreach ($authorlist as $author) {
            $authorName = trim($author->name);
            $name = str_replace(' ', '-', trim($author->name)) . '/';
            if (++$k === $numItems && $numItems != 1) {
                $formattedAuthorlist .= ', & ';
            } elseif ($j != 1) {
                $formattedAuthorlist .= ', ';
            }
            if ($wprl_options['show_author_link']) {
                $formattedAuthorlist .= '<a href="'.site_url().'/reading-list/author/'.$name.'">'.$authorName.'</a>';
            } else {
                $formattedAuthorlist.= $authorName;
            }
            $j++;
        }
        ?>
        <p class="wprl-work-author">
            By: <?php echo $formattedAuthorlist;?>
        </p>
    <?php }
}

function renderPageNumbers() {
    global $wprl_options;
    global $post;
    global $metapost;
    if ($wprl_options['show_page_nums'] && get_post_meta($post->ID, 'wprl_pages', true)) { ?>
        <p class="wprl-entry-pages">
            Pages: <?php echo(get_post_meta($metapost->ID, 'wprl_pages', true)); ?>
        </p>
    <?php }
}

function renderPostDate() {
    global $wprl_options;
    global $metapost;
    if ($wprl_options['show_post_date']) { ?>
        <p class="wprl-entry-date">
            Posted on: <?php echo(get_the_time(get_option('date_format'), $metapost->ID)); ?>
        </p>
    <?php }
}

function renderPostAuthor() {
    global $wprl_options;
    global $metapost;
    if ($wprl_options['post_author']) {
        $postAuthor = get_the_author_meta('user_nicename', $metapost->post_author);
        $postAuthorUrl = site_url().'/author/'.$postAuthor?>
        <p class="wprl-entry-author">
            Posted by: <a href="<?php echo($postAuthorUrl); ?>">
                <?php echo($postAuthor); ?>
            </a>
        </p>
    <?php }
}

function renderPostType () {
    global $wprl_options;
    global $metapost;
    if ($wprl_options['show_work_type']) {
        $typelist = get_the_terms($metapost->ID, 'work-type');
        if ($typelist) {
            $j = 1;
            $k = 0;
            $numItems = count($typelist);
            $formattedTypeList = "";
            foreach ($typelist as $type) {
                $name = str_replace(' ', '-', trim($type->name)) . '/';
                $typeName = trim($type->name);
                if (++$k === $numItems && $numItems != 1) {
                    $formattedTypeList .= ' & ';
                } elseif ($j != 1) {
                    $formattedTypeList .= ', ';
                }
                if ($wprl_options['show_type_link']) {
                    $formattedTypeList .= '<a href="' . site_url() . '/reading-list/type/' . $name . '">' . $typeName . '</a>';
                } else {
                    $formattedTypeList .= $typeName;
                }
                $j++;
            } ?>
            <p class="wprl-type">
                Type: <?php echo $formattedTypeList?>
            </p>
        <?php }
    }
}

function renderMetadata() {
    global $metapost;
    $metainfo[] = get_post();
    foreach ($metainfo as $metapost) { ?>
        <div class="wprl-entry-meta">
            <?php renderTitle();
            renderAuthors();
            renderPageNumbers();
            renderPostDate();
            renderPostAuthor();
            renderPostType();?>
        </div>
    <?php }
}

function renderContent(){
    ?>
    <p class="wprl-entry-content">
        <?php the_content(); ?>
    </p>
<?php }

function renderPost($isArchive = true)
{
    global $wprl_options;
    $width = $wprl_options['grid_width'];
    $columnClasses = ["wprl-entry-container"];
    if ($isArchive) {
        array_push($columnClasses, "wprl-col");
        if ($width == 2) {
            array_push($columnClasses, "wprl-col-sm-6");
        } else if($width == 3) {
            array_push($columnClasses, "wprl-col-sm-6", "wprl-col-md-4");
        } else if ($width == 4) {
            array_push($columnClasses, "wprl-col-sm-6", "wprl-col-md-3");
        }
    }
    ?>
    <article id="wprl-post-<?php the_ID(); ?>" class="<?php echo join(" ",$columnClasses);?>">
        <?php
        renderImage();
        renderMetadata();
        if ($isArchive) {
            renderExcerpt();
        } else {
            renderContent();
        }
        ?>
    </article><!-- #post-<?php the_ID(); ?> -->
<?php }

function renderNavigation() { ?>
    <nav class="navigation paging-navigation" role="navigation">
        <h1 class="wprl-screen-reader-text">Works navigation</h1>
        <div class="wprl-work-links nav-links">
            <?php posts_nav_link(); ?>
        </div><!-- .nav-links -->
    </nav>
<?php }

function renderNoResults() { ?>
    <h3 class="wprl-no-results">No Results</h3>
<?php }