DROP PROCEDURE IF EXISTS sp_get_followees;
DELIMITER //

CREATE PROCEDURE sp_get_followees (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT followee FROM following WHERE follower = p_user_id;
END//

DELIMITER ;