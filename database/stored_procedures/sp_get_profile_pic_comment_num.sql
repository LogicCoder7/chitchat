DROP PROCEDURE IF EXISTS sp_get_profile_pic_comment_num;
DELIMITER //

CREATE PROCEDURE sp_get_profile_pic_comment_num (IN p_profile_pic_id INT UNSIGNED)
BEGIN
    SELECT COUNT(id) FROM profile_pic_comment WHERE profile_pic_id = p_profile_pic_id;
END//

DELIMITER ;