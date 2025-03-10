DROP PROCEDURE IF EXISTS sp_add_user;
DELIMITER //

CREATE PROCEDURE sp_add_user (
    IN p_username VARCHAR(16), 
    IN p_password VARCHAR(255), 
    IN p_role ENUM('USER', 'ADMIN', 'CONTENT_MODERATOR')
) 
BEGIN
    INSERT INTO user(username, password, role) VALUES(p_username, p_password, p_role);
    SELECT LAST_INSERT_ID() AS id;
END//

DELIMITER ;
