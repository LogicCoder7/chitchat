DROP PROCEDURE IF EXISTS sp_message;
DELIMITER //

CREATE PROCEDURE sp_message (
    IN p_author INT UNSIGNED,
    IN p_recipent INT UNSIGNED,
    IN p_reply_to INT UNSIGNED,
    IN p_message VARCHAR(255),
    IN p_type ENUM('text', 'image', 'video')
)
BEGIN
    INSERT INTO message(author, recipent, reply_to, message, type) 
    VALUES(p_author, p_recipent, p_reply_to, p_message, p_type);
END//

DELIMITER ;
