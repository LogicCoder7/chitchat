DROP PROCEDURE IF EXISTS sp_delete_profile_pic;
DELIMITER //

CREATE PROCEDURE sp_delete_profile_pic (
    IN p_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    SELECT image_name FROM profile_pic WHERE id = p_id AND user_id = p_user_id;
    DELETE FROM profile_pic WHERE id = p_id AND user_id = p_user_id;
END//

DELIMITER ;