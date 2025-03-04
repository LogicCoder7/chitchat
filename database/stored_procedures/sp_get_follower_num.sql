DROP PROCEDURE IF EXISTS sp_get_follower_num;
DELIMITER //

CREATE PROCEDURE sp_get_follower_num (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT COUNT(*) FROM follow WHERE followee = p_user_id;
END//

DELIMITER ;