DROP PROCEDURE IF EXISTS sp_get_message;
DELIMITER //

CREATE PROCEDURE sp_get_message (IN p_id INT UNSIGNED)
BEGIN
    SELECT M.id, M.message, M.type, M.date_messaged, P.first_name, P.last_name
    FROM message M 
    JOIN profile P ON P.user_id = M.author
    WHERE M.id = p_id;
END//

DELIMITER ;