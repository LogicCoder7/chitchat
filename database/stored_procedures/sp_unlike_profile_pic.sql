DROP PROCEDURE IF EXISTS sp_unlike_profile_pic;
DELIMITER //

CREATE PROCEDURE sp_unlike_profile_pic (
    IN p_profile_pic_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    DELETE FROM profile_pic_like WHERE profile_pic_id = p_profile_pic_id AND user_id = p_user_id; 
END//

DELIMITER ;