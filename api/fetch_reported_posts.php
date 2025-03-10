<?php
session_start();
require '../includes/request_guard_moderator.php';
require_once '../includes/database_access.php';

if (isset($_POST['post_id']) && isset($_POST['author_id']) && isset($_POST['action'])) {
    $postId = sanitize($_POST['post_id']);
    $authorId = sanitize($_POST['author_id']);
    $action = sanitize($_POST['action']);

    if ($action === "ignore") {
        delete_post_reports($postId);
    } else if ($action === "takedown") {
        delete_post($postId, $authorId);
        delete_post_reports($postId);
    }
}


$reported_posts = get_reported_posts();

foreach ($reported_posts as $reported_post) {
    echo "<section class='reported-post'>";
    echo "<div class='post-content'>";
    $postUrl = $reported_post['content_type'] !== 'TEXT' ? "/chitchat/uploads/posts/$reported_post[content]" : null;

    switch ($reported_post['content_type']) {
        case "IMAGE":
            echo "<a href='$postUrl' target='_blank'><img src='$postUrl'></a>";
            break;
        case "VIDEO":
            echo "<video src='$postUrl' controls>";
            break;
        case "TEXT":
            echo "<p>$reported_post[content]</p>";
            break;
    }
    echo "</div>";

    echo "<p class='post-info'>"
        . "<span class='author'>$reported_post[author_username]</span> | "
        . "<span class='likes'>Likes: " . get_post_like_num($reported_post['id']) . "</span> | "
        . "<span class='comments'>Comments: " . get_post_comment_num($reported_post['id']) . "</span> | "
        . "<span class='date'>" . date("d/M/y g:iA", strtotime($reported_post['date_posted'])) . "</span>"
        . "</p>";

    echo "<p class='report-info'>"
        . "<span class='report-num'>Reported by $reported_post[report_num] user/s</span>"
        . "</p>";

    echo "<div class='report-action'>"
        . "<button onclick='post(\"/chitchat/api/fetch_reported_posts.php\", \"post_id=$reported_post[id]&author_id=$reported_post[author]&action=ignore\", \"reportedPostContainer\")'>Ignore</button>"
        . "<button onclick='post(\"/chitchat/api/fetch_reported_posts.php\", \"post_id=$reported_post[id]&author_id=$reported_post[author]&action=takedown\", \"reportedPostContainer\")'>Takedown</button>"
        . "</div>";

    echo "</section>";
}
