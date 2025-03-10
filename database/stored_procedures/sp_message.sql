DROP PROCEDURE IF EXISTS sp_message;
DELIMITER //

CREATE PROCEDURE sp_message (
    IN p_author INT UNSIGNED,
    IN p_recipent INT UNSIGNED,
    IN p_reply_to INT UNSIGNED,
    IN p_content VARCHAR(255),
    IN p_content_type ENUM('TEXT', 'IMAGE', 'VIDEO')
)
BEGIN
    INSERT INTO message(author, recipent, reply_to, content, content_type) 
    VALUES(p_author, p_recipent, p_reply_to, p_content, p_content_type);
END//

DELIMITER ;
