<?php
class Custom_Footer_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'custom_footer_widget',
            'Custom Footer Widget',
            array('description' => 'A custom footer widget with a form.')
        );
    }
    

    // Save form data in the widget options with validation
    public function update($new_instance, $old_instance) {
        $instance = array();
        
        // Validate title
        if (!empty($new_instance['title'])) {
            $instance['title'] = sanitize_text_field($new_instance['title']);
        } else {
            $instance['title'] = ''; // Handle empty title
        }
        
        // Validate firstname
        if (!empty($new_instance['firstname'])) {
            $instance['firstname'] = sanitize_text_field($new_instance['firstname']);
        } else {
            $instance['firstname'] = ''; // Handle empty firstname
        }

        // Validate lastname
        if (!empty($new_instance['lastname'])) {
            $instance['lastname'] = sanitize_text_field($new_instance['lastname']);
        } else {
            $instance['lastname'] = ''; // Handle empty lastname
        }

        // Validate gender
        if (!empty($new_instance['gender'])) {
            $instance['gender'] = sanitize_text_field($new_instance['gender']);
        } else {
            $instance['gender'] = ''; // Handle empty gender
        }

        return $instance;
    }

    // Widget backend (admin form)
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $firstname = !empty($instance['firstname']) ? $instance['firstname'] : '';
        $lastname = !empty($instance['lastname']) ? $instance['lastname'] : '';
        $gender = !empty($instance['gender']) ? $instance['gender'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" required>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('firstname')); ?>">First Name:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('firstname')); ?>" name="<?php echo esc_attr($this->get_field_name('firstname')); ?>" type="text" value="<?php echo esc_attr($firstname); ?>" required>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('lastname')); ?>">Last Name:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('lastname')); ?>" name="<?php echo esc_attr($this->get_field_name('lastname')); ?>" type="text" value="<?php echo esc_attr($lastname); ?>" required>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('gender')); ?>">Gender:</label>
            <select id="<?php echo esc_attr($this->get_field_id('gender')); ?>" name="<?php echo esc_attr($this->get_field_name('gender')); ?>" class="widefat">
                <option value="" <?php selected($gender, ''); ?>>Select Gender</option>
                <option value="Male" <?php selected($gender, 'Male'); ?>>Male</option>
                <option value="Female" <?php selected($gender, 'Female'); ?>>Female</option>
                <option value="Other" <?php selected($gender, 'Other'); ?>>Other</option>
            </select>
        </p>
        <?php
    }

    // Front-end display of widget
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        // Check and display only filled fields
        if (!empty($instance['firstname'])) {
            echo '<p><strong>First Name:</strong> ' . esc_html($instance['firstname']) . '</p>';
        }
        if (!empty($instance['lastname'])) {
            echo '<p><strong>Last Name:</strong> ' . esc_html($instance['lastname']) . '</p>';
        }
        if (!empty($instance['gender'])) {
            echo '<p><strong>Gender:</strong> ' . esc_html($instance['gender']) . '</p>';
        }

        // Handle form submission
        if (isset($_POST['cfw_form_submit'])) {
            // Validate form fields
            if (!empty($_POST['cfw_form_firstname']) && !empty($_POST['cfw_form_lastname']) && !empty($_POST['cfw_form_gender'])) {
                // Update instance with form data
                $instance['firstname'] = sanitize_text_field($_POST['cfw_form_firstname']);
                $instance['lastname'] = sanitize_text_field($_POST['cfw_form_lastname']);
                $instance['gender'] = sanitize_text_field($_POST['cfw_form_gender']);
                // Update widget options
                $this->update($instance, $instance);
                echo '<div class="cfw-success-message">Data submitted successfully!</div>';
            } else {
                echo '<div class="cfw-error-message">Please fill in all fields before submitting!</div>';
            }
        }

        // Commented out form display logic
        /*
        // Display form if data is not yet submitted
        ?>
        <form method="post">
            <p>
                <label for="cfw_form_title">Title:</label>
                <input type="text" id="cfw_form_title" name="cfw_form_title" value="<?php echo esc_attr($instance['title']); ?>" required>
            </p>
            <p>
                <label for="cfw_form_firstname">First Name:</label>
                <input type="text" id="cfw_form_firstname" name="cfw_form_firstname" value="<?php echo esc_attr($instance['firstname']); ?>" required>
            </p>
            <p>
                <label for="cfw_form_lastname">Last Name:</label>
                <input type="text" id="cfw_form_lastname" name="cfw_form_lastname" value="<?php echo esc_attr($instance['lastname']); ?>" required>
            </p>
            <p>
                <label for="cfw_form_gender">Gender:</label>
                <select id="cfw_form_gender" name="cfw_form_gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php selected($instance['gender'], 'Male'); ?>>Male</option>
                    <option value="Female" <?php selected($instance['gender'], 'Female'); ?>>Female</option>
                    <option value="Other" <?php selected($instance['gender'], 'Other'); ?>>Other</option>
                </select>
            </p>
            <p>
                <input type="submit" name="cfw_form_submit" value="Submit">
            </p>
        </form>
        <?php
        */
        
        echo $args['after_widget'];
    }
}

// Register the widget
add_action('widgets_init', function() {
    register_widget('Custom_Footer_Widget');
});
