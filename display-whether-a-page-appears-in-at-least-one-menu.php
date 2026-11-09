add_filter('manage_pages_columns', function ($columns) {
    $columns['in_menu'] = 'In Menu';
    return $columns;
});

add_action('manage_pages_custom_column', function ($column, $post_id) {

    if ($column !== 'in_menu') {
        return;
    }

    $is_in_menu = false;

    $menus = wp_get_nav_menus();

    foreach ($menus as $menu) {

        $menu_items = wp_get_nav_menu_items($menu->term_id);

        if (!$menu_items) {
            continue;
        }

        foreach ($menu_items as $item) {

            if (
                $item->object === 'page' &&
                (int) $item->object_id === (int) $post_id
            ) {
                $is_in_menu = true;
                break 2;
            }
        }
    }

    if ($is_in_menu) {
        echo '<span style="color: #16a34a; font-size: 20px; font-weight: bold;">&#10003;</span>';
    } else {
        echo '<span style="color: #dc2626; font-size: 20px; font-weight: bold;">&#10005;</span>';
    }

}, 10, 2);