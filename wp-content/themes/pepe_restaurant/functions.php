<?php

add_filter('site_url',  'wpadmin_filter', 10, 3);
function wpadmin_filter( $url, $path, $orig_scheme ) {
    $old  = array( "/(wp-admin)/");
    $admin_dir = WP_ADMIN_DIR;
    $new  = array($admin_dir);
    return preg_replace( $old, $new, $url, 1);
}

add_action('login_head', 'customize_login_r');

function customize_login_r() {
    ?>
    <style>
        body.login {
            background-image: url("<?= get_stylesheet_directory_uri() ?>/screenshot.jpg");
            background-size: cover;
        }
        .login h1 a {
            background-image: url("<?= get_stylesheet_directory_uri() ?>/logo.png");
        }
    </style>
    <?php
}

add_action('admin_menu', 'add_book_list_page');

function add_book_list_page() {
    add_menu_page('Book List', 'Book List', 'manage_options', 'book_list', 'book_list_page');
    add_submenu_page(null, 'Reservation', 'Reservation', 'manage_options', 'book_item', 'book_item_page');
}

function book_list_page() {
    global $wpdb;
    $base = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
    $orders = [
        'name' => @$_REQUEST['orderby'] == 'name' ? @$_REQUEST['order'] : '',
        'email' => @$_REQUEST['orderby'] == 'email' ? @$_REQUEST['order'] : '',
        'date' => @$_REQUEST['orderby'] == 'date' ? @$_REQUEST['order'] : '',
        'time' => @$_REQUEST['orderby'] == 'time' ? @$_REQUEST['order'] : '',
        'visitors_count' => @$_REQUEST['orderby'] == 'visitors_count' ? @$_REQUEST['order'] : '',
        'ip' => @$_REQUEST['orderby'] == 'name' ? @$_REQUEST['ip'] : '',
        'status' => @$_REQUEST['orderby'] == 'name' ? @$_REQUEST['status'] : '',
    ];
    $order = @$_REQUEST['orderby'] ? ('ORDER BY ' . @$_REQUEST['orderby'] . ' ' . @$_REQUEST['order']) : '';
    $rows = $wpdb->get_results("SELECT * FROM reservations $order", ARRAY_A);
    ?>
    <div class="wrap">
        <h1 class="wp-heading">Book List</h1>
        <br>
        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <thead>
            <tr>
                <th>ID</th>
                <th class="manage-column column-primary sortable <?= $orders['name'] ?>">
                    <a href="<?= $base . '?' . http_build_query(array_merge($_GET, ['orderby' => 'name', 'order' => $orders['name'] == 'asc' ? 'desc' : 'asc'])) ?>">
                        <span>Name</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th class="manage-column column-primary sortable <?= @$_REQUEST['orderby'] == 'email' ? @$_REQUEST['order'] : '' ?>">
                    <a href="<?= $base . '?' . http_build_query(array_merge($_GET, ['orderby' => 'email', 'order' => $orders['email'] == 'asc' ? 'desc' : 'asc'])) ?>">
                        <span>Email</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th class="manage-column column-primary sortable <?= @$_REQUEST['orderby'] == 'date' ? @$_REQUEST['order'] : '' ?>">
                    <a href="<?= $base . '?' . http_build_query(array_merge($_GET, ['orderby' => 'date', 'order' => $orders['date'] == 'asc' ? 'desc' : 'asc'])) ?>">
                        <span>Date</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th class="manage-column column-primary sortable <?= @$_REQUEST['orderby'] == 'time' ? @$_REQUEST['order'] : '' ?>">
                    <a href="<?= $base . '?' . http_build_query(array_merge($_GET, ['orderby' => 'time', 'order' => $orders['time'] == 'asc' ? 'desc' : 'asc'])) ?>">
                        <span>Time</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th class="manage-column column-primary sortable <?= @$_REQUEST['orderby'] == 'visitors_count' ? @$_REQUEST['order'] : '' ?>">
                    <a href="<?= $base . '?' . http_build_query(array_merge($_GET, ['orderby' => 'visitors_count', 'order' => $orders['visitors_count'] == 'asc' ? 'desc' : 'asc'])) ?>">
                        <span>Number of visitors</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th class="manage-column column-primary sortable <?= @$_REQUEST['orderby'] == 'ip' ? @$_REQUEST['order'] : '' ?>">
                    <a href="<?= $base . '?' . http_build_query(array_merge($_GET, ['orderby' => 'ip', 'order' => $orders['ip'] == 'asc' ? 'desc' : 'asc'])) ?>">
                        <span>IP</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th class="manage-column column-primary sortable <?= @$_REQUEST['orderby'] == 'status' ? @$_REQUEST['order'] : '' ?>">
                    <a href="<?= $base . '?' . http_build_query(array_merge($_GET, ['orderby' => 'status', 'order' => $orders['status'] == 'asc' ? 'desc' : 'asc'])) ?>">
                        <span>Status</span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($rows as $row) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                        <a href="<?= admin_url('reservation/' . $row['id']) ?>">
                            <?= $row['name'] ?>
                        </a>
                    </td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['time'] ?></td>
                    <td><?= $row['visitors_count'] ?></td>
                    <td><?= $row['ip'] ?></td>
                    <td><?= $row['status'] ? 'Confirmed' : 'Not confirmed' ?></td>
                    <td>
                        <?php if (!$row['status']) : ?>
                            <a href="<?= admin_url('admin-post.php?action=confirm_reservation&id=' . $row['id']) ?>" class="button-primary">Confirm</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function book_item_page()
{
    global $wpdb;
    $id = @$_REQUEST['id'];
    $row = $wpdb->get_row("SELECT * FROM reservations WHERE id = $id", ARRAY_A)
    ?>
    <div class="wrap">
        <h1 class="wp-heading">Reservation</h1>
        <br>
        <p>
            <b>Name:</b> <?= @$row['name'] ?>
        </p>
        <p>
            <b>Email:</b> <?= @$row['email'] ?>
        </p>
        <p>
            <b>Date:</b> <?= @$row['date'] ?>
        </p>
        <p>
            <b>Time:</b> <?= @$row['time'] ?>
        </p>
        <p>
            <b>Visitors count:</b> <?= @$row['visitors_count'] ?>
        </p>
        <p>
            <b>IP:</b> <?= @$row['ip'] ?>
        </p>
        <p>
            <b>Status:</b> <?= @$row['status'] ? 'Confirmed' : 'Not confirmed' ?>
        </p>
        <?php if (!@$row['status']) : ?>
            <a href="<?= admin_url('admin-post.php?action=confirm_reservation&id=' . @$row['id']) ?>" class="button-primary">Confirm</a>
        <?php endif; ?>
    </div>
<?php
}

add_action('init', 'create_table_reservations');

function create_table_reservations() {
    $sql = "CREATE TABLE IF NOT EXISTS reservations (
    `id` int not null auto_increment, 
    `name` varchar(255) null,
    `email` varchar(255) null,
    `date` date null,
    `time` time null,
    `visitors_count` int null,
    `ip` varchar(255) null,
    `status` tinyint null,
    PRIMARY KEY id (id)
    );";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

add_action('admin_post_save_reservation', 'save_reservation');
add_action('admin_post_nopriv_save_reservation', 'save_reservation');

function save_reservation()
{
    print_r($_REQUEST);
    global $wpdb;
    $wpdb->insert('reservations', [
        'name' => @$_REQUEST['name'],
        'email' => @$_REQUEST['email'],
        'date' => @$_REQUEST['date'],
        'time' => @$_REQUEST['time'],
        'visitors_count' => @$_REQUEST['visitors_count'] ?? 0,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'status' => 0,
    ]);
}


add_action('admin_post_confirm_reservation', 'confirm_reservation');
add_action('admin_post_nopriv_confirm_reservation', 'confirm_reservation');

function confirm_reservation()
{
    global $wpdb;
    $wpdb->update('reservations', [
        'status' => 1,
    ], ['id' => @$_REQUEST['id']]);
    wp_redirect(wp_get_referer());
}

add_action('wp_enqueue_scripts', 'add_scripts_my');
function add_scripts_my() {
    wp_enqueue_script('my', get_stylesheet_directory_uri() . '/js/script.js', [], '1.0', true);
}