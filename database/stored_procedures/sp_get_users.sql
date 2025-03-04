DROP PROCEDURE IF EXISTS sp_get_users;
DELIMITER //

CREATE PROCEDURE sp_get_users ()
BEGIN
    SELECT U.id, U.username, P.first_name, P.last_name 
    FROM user U JOIN profile P ON U.id = P.user_id 
    WHERE U.role = "user"; 
END//

DELIMITER ;