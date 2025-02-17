const commentSection = document.getElementById('commentSection');
const closeCommentBtn = document.getElementById('closeCommentBtn');
const commentForm = document.getElementById('commentForm');
const replyToContainer = document.getElementById('replyToContainer');
const cancelReplyBtn = document.getElementById('cancelReplyBtn');
let comment = null;
let isPostComment = null;

closeCommentBtn.addEventListener('click', closeComment);
cancelReplyBtn.addEventListener('click', clearReply);
commentForm.addEventListener('submit', sendComment);

function openComment(id, _isPostComment = true) {
    isPostComment = _isPostComment;
    if (isPostComment) {
        post('/chitchat/api/fetch_post_comments.php', `post_id=${id}`, 'commentContainer');
        commentForm['post_id'].value = id;
    }
    else {
        post('/chitchat/api/fetch_profile_pic_comments.php', `profile_pic_id=${id}`, 'commentContainer');
        commentForm['profile_pic_id'].value = id;
    }
    commentSection.style.visibility = 'visible';
}

function closeComment() {
    commentSection.style.visibility = "hidden";
    commentForm['comment'].value = null;
    if (isPostComment)
        commentForm['post_id'].value = null;
    else
        commentForm['profile_pic_id'].value = null;
    clearReply();
}

function sendComment(event) {
    event.preventDefault();
    const replyToId = commentForm['reply_to_id'].value;
    const comment = commentForm['comment'].value;
    if (isPostComment) {
        const postId = commentForm['post_id'].value;
        post('/chitchat/api/fetch_post_comments.php', `post_id=${postId}&reply_to_id=${replyToId}&comment=${comment}`, 'commentContainer');
    }
    else {
        const profilePicId = commentForm['profile_pic_id'].value;
        post('/chitchat/api/fetch_profile_pic_comments.php', `profile_pic_id=${profilePicId}&reply_to_id=${replyToId}&comment=${comment}`, 'commentContainer');
    }
    commentForm['comment'].value = null;
    clearReply();
}

function replyToComment(commentId) {
    if (comment) {
        replyToContainer.removeChild(comment);
        comment = null;
    }
    comment = document.getElementById(commentId).cloneNode(true);
    comment.querySelector('.comment-action').remove();
    replyToContainer.append(comment);
    replyToContainer.style.display = 'flex';
    commentForm['reply_to_id'].value = commentId;
}

function clearReply() {
    if (comment) {
        replyToContainer.removeChild(comment);
        comment = null;
    }
    replyToContainer.style.display = 'none';
    commentForm['reply_to_id'].value = null;
}