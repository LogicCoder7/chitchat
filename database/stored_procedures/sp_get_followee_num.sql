DROP PROCEDURE IF EXISTS sp_get_followee_num;
DELIMITER //

CREATE PROCEDURE sp_get_followee_num (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT COUNT(*) FROM following WHERE follower = p_user_id;
END//

DELIMITER ;