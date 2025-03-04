DROP PROCEDURE IF EXISTS sp_get_post_comments;
DELIMITER //

CREATE PROCEDURE sp_get_post_comments (IN p_post_id INT UNSIGNED)
BEGIN
    SELECT C.id, C.author, C.reply_to, C.comment, C.date_commented, P.first_name, P.last_name 
    FROM post_comment C
    JOIN profile P ON P.user_id = C.author
    WHERE C.post_id = p_post_id;
END//

DELIMITER ;