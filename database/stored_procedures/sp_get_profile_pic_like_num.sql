DROP PROCEDURE IF EXISTS  sp_get_profile_pic_like_num;
DELIMITER //

CREATE PROCEDURE sp_get_profile_pic_like_num (IN p_profile_pic_id INT UNSIGNED)
BEGIN
    SELECT COUNT(*) FROM profile_pic_like WHERE profile_pic_id = p_profile_pic_id;
END//

DELIMITER ;