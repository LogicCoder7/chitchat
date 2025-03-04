DROP PROCEDURE IF EXISTS sp_get_messages_involving_user;
DELIMITER //

CREATE PROCEDURE sp_get_messages_involving_user (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT id, author FROM message WHERE author = p_user_id OR recipent = p_user_id;
END//

DELIMITER ;