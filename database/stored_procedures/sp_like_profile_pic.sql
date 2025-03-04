DROP PROCEDURE IF EXISTS sp_like_profile_pic;
DELIMITER //

CREATE PROCEDURE sp_like_profile_pic (
    IN p_profile_pic_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    INSERT INTO profile_pic_like(profile_pic_id, user_id) VALUES(p_profile_pic_id, p_user_id);
END//

DELIMITER ;
