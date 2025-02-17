<?php
session_start();
require '../includes/request_guard_moderator.php';
require_once '../includes/functions.php';

if (isset($_POST['post_id']) && isset($_POST['post_author']) && isset($_POST['action'])) {
    $postId = sanitize($_POST['post_id']);
    $postAuthor = sanitize($_POST['post_author']);
    $action = sanitize($_POST['action']);

    if ($action === "ignore") {
        delete_post_reports($postId);
    } else if ($action === "takedown") {
        delete_post($postId, $postAuthor);
        delete_post_reports($postId);
    }
}


$reports = get_post_reports();

foreach ($reports as $report) {
    echo "<section class='report'>";
    echo "<div class='post-content'>";
    $postUrl = "/chitchat/uploads/posts/$report[post]";

    switch ($report['post_type']) {
        case "image":
            echo "<a href='$postUrl' target='_blank'><img src='$postUrl'></a>";
            break;
        case "video":
            echo "<video src='$postUrl' controls>";
            break;
        case "text":
            echo "<p>$report[post]</p>";
            break;
    }
    echo "</div>";

    echo "<p class='post-info'>"
        . "<span class='author'>$report[post_author]</span> | "
        . "<span class='likes'>Likes: " . post_like_num($report['post_id']) . "</span> | "
        . "<span class='comments'>Comments: " . post_comment_num($report['post_id']) . "</span> | "
        . "<span class='date'>" . date("d/M/y g:iA", strtotime($report['post_date'])) . "</span>"
        . "</p>";

    echo "<p class='report-info'>"
        . "<span class='report-num'>Reported by $report[report_num] users</span>"
        . "</p>";

    echo "<div class='report-action'>"
        . "<button onclick='post(\"/chitchat/api/fetch_post_reports.php\", \"post_id=$report[post_id]&post_author=$report[post_author]&action=ignore\", \"reportContainer\")'>Ignore</button>"
        . "<button onclick='post(\"/chitchat/api/fetch_post_reports.php\", \"post_id=$report[post_id]&post_author=$report[post_author]&action=takedown\", \"reportContainer\")'>Takedown</button>"
        . "</div>";

    echo "</section>";
}
