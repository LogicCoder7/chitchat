DROP PROCEDURE IF EXISTS sp_get_followers;
DELIMITER //

CREATE PROCEDURE sp_get_followers (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT follower FROM following WHERE followee = p_user_id;
END//

DELIMITER ;