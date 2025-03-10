DROP PROCEDURE IF EXISTS sp_get_profile_pic_comments;
DELIMITER //

CREATE PROCEDURE sp_get_profile_pic_comments (IN p_profile_pic_id INT UNSIGNED)
BEGIN
    SELECT C.id, C.author, C.reply_to, C.content, C.date_commented, P.first_name, P.last_name
    FROM profile_pic_comment C
    JOIN profile P ON P.user_id = C.author
    WHERE C.profile_pic_id = p_profile_pic_id;
END//

DELIMITER ;