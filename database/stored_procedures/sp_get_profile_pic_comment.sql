DROP PROCEDURE IF EXISTS sp_get_profile_pic_comment;
DELIMITER //

CREATE PROCEDURE sp_get_profile_pic_comment (IN p_id INT UNSIGNED)
BEGIN
    SELECT C.id, C.comment, C.date_commented, P.first_name, P.last_name 
    FROM profile_pic_comment C
    JOIN profile P ON P.user_id = C.author
    WHERE C.id = p_id;
END//

DELIMITER ;