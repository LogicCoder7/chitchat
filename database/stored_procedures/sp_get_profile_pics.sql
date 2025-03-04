DROP PROCEDURE IF EXISTS sp_get_profile_pics;
DELIMITER //

CREATE PROCEDURE sp_get_profile_pics (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT id, image_name, date_uploaded FROM profile_pic P 
    WHERE user_id = p_user_id ORDER BY date_uploaded DESC;
END//

DELIMITER ;