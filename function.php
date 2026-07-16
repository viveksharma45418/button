// Button Click Tracking

add_action('wp_ajax_track_button_click', 'track_button_click');
add_action('wp_ajax_nopriv_track_button_click', 'track_button_click');

function track_button_click() {

    global $wpdb;

    $table = $wpdb->prefix . 'button_clicks';

    $button_name = sanitize_text_field($_POST['button_name'] ?? '');
    $page_url    = sanitize_text_field($_POST['page_url'] ?? '');
    $user_ip     = $_SERVER['REMOTE_ADDR'];

    $wpdb->insert(
        $table,
        array(
            'button_name' => $button_name,
            'page_url'    => $page_url,
            'user_ip'     => $user_ip,
            'created_at'  => current_time('mysql') // IST time save hoga
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%s'
        )
    );

    wp_send_json_success();
}