DROP PROCEDURE IF EXISTS sp_is_profile_pic_liked;
DELIMITER //

CREATE PROCEDURE sp_is_profile_pic_liked (
    IN p_profile_pic_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    SELECT 1 FROM profile_pic_like WHERE profile_pic_id = p_profile_pic_id AND user_id = p_user_id;
END//

DELIMITER ;