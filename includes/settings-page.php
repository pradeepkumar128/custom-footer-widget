<?php
// Add settings page
function cfw_add_settings_page() {
    add_menu_page(
        'Custom Footer Widget Settings',
        'Footer Widget Settings',
        'manage_options',
        'cfw-settings',
        'cfw_render_settings_page'
    );
}
add_action('admin_menu', 'cfw_add_settings_page');

// Register settings
function cfw_register_settings() {
    register_setting('cfw_settings_group', 'cfw_settings', 'cfw_validate_settings');
}
add_action('admin_init', 'cfw_register_settings');

// Validate settings
function cfw_validate_settings($input) {
    // Perform validation for two fields
    if (empty($input['title'])) {
        add_settings_error('cfw_settings', 'title_error', 'Title is required', 'error');
    }
    if (empty($input['description'])) {
        add_settings_error('cfw_settings', 'description_error', 'Description is required', 'error');
    }
    return $input;
}

// Render settings page
function cfw_render_settings_page() {
    $options = get_option('cfw_settings');
    ?>
    <div class="wrap">
        <h1>Custom Footer Widget Settings</h1>
        <?php settings_errors(); ?>
        <form method="post" action="options.php">
            <?php settings_fields('cfw_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="cfw_title">Title</label></th>
                    <td>
                        <input type="text" id="cfw_title" name="cfw_settings[title]" value="<?php echo esc_attr($options['title'] ?? ''); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="cfw_description">Description</label></th>
                    <td>
                        <textarea id="cfw_description" name="cfw_settings[description]" rows="5" cols="50"><?php echo esc_textarea($options['description'] ?? ''); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="cfw_editor_content">Editor Content</label></th>
                    <td>
                        <?php
                        $editor_settings = array(
                            'textarea_name' => 'cfw_settings[editor_content]',
                            'media_buttons' => true,
                        );
                        wp_editor($options['editor_content'] ?? '', 'cfw_editor_content', $editor_settings);
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="cfw_date">Date</label></th>
                    <td>
                        <input type="date" id="cfw_date" name="cfw_settings[date]" value="<?php echo esc_attr($options['date'] ?? ''); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Image</th>
                    <td>
                        <button class="button" id="cfw_upload_image_button">Upload Image</button>
                        <input type="hidden" id="cfw_image" name="cfw_settings[image]" value="<?php echo esc_attr($options['image'] ?? ''); ?>" />
                        <div id="cfw_image_preview">
                            <?php if (!empty($options['image'])): ?>
                                <img src="<?php echo esc_url($options['image']); ?>" style="max-width:200px;" />
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="cfw_color">Color Picker</label></th>
                    <td>
                        <input type="text" id="cfw_color" name="cfw_settings[color]" value="<?php echo esc_attr($options['color'] ?? ''); ?>" class="cfw-color-field" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
