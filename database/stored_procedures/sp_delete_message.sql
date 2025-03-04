DROP PROCEDURE IF EXISTS sp_delete_message;
DELIMITER //

CREATE PROCEDURE sp_delete_message (
    IN p_id INT UNSIGNED,
    IN p_author INT UNSIGNED
)
BEGIN
    SELECT message AS file_name FROM message WHERE id = p_id AND author = p_author AND type != "text";
    DELETE FROM message WHERE id = p_id AND author = p_author; 
END//

DELIMITER ;