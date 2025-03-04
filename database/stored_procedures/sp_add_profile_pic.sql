DROP PROCEDURE IF EXISTS sp_add_profile_pic;
DELIMITER //

CREATE PROCEDURE sp_add_profile_pic (
    IN p_user_id INT UNSIGNED,
    IN p_image_name VARCHAR(255)
)
BEGIN
    INSERT INTO profile_pic(user_id, image_name) VALUES(p_user_id, p_image_name);
END//

DELIMITER ;
