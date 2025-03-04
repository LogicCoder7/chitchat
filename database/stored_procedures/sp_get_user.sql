DROP PROCEDURE IF EXISTS sp_get_user;
DELIMITER //

CREATE PROCEDURE sp_get_user (
    IN p_username VARCHAR(16),
    IN p_password VARCHAR(255)
)
BEGIN
    SELECT id, role FROM user WHERE username = p_username AND password = p_password;
END//

DELIMITER ;