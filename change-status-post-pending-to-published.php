/*  CHANGE PENDING POSTS TO PUBLISHED POSTS */ 
function change_post_status($post_id, $status, $change_date){
    $current_post['ID']             = $post_id;
    $current_post['post_status']    = $status;
    $current_post['post_date']      = $change_date;
    $current_post['post_date_gmt']  = $change_date;  // ADDED THIS LINE
    wp_update_post($current_post);
}

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'future',
    'orderby'        => 'date',
    'order'          => 'ASC',
);
$the_query = new WP_Query($args);

if ($the_query->have_posts()) {
    $counter = 1;
    while ($the_query->have_posts()) {
        $the_query->the_post();

        $pid        = get_the_ID();
        $newdate    = date('Y-m-d H:i:s', time() - (3600 * $counter));

        change_post_status($pid, 'publish', $newdate);

        // echo 'TITLE: '.get_the_title() .' TIME:'.date('Y-m-d H:i:s', time()-(3600 * $counter)).'<br/>';
        $counter++;
    }
}