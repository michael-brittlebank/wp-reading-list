<p class="wprl-link-p-admin">
    <label for="wprl-link">
        <?php _e("Add a link to the work", 'wp-readinglist'); ?>
    </label>
</p>
<p>
    <input class="wprl-link-input" type="text" name="wprl-link" id="wprl-link" value="<?php echo esc_attr(get_post_meta($object->ID, 'wprl_link', true)); ?>" size="30" />
</p>