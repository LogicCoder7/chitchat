DROP PROCEDURE IF EXISTS sp_post;
DELIMITER //

CREATE PROCEDURE sp_post (
    IN p_author INT UNSIGNED,
    IN p_content VARCHAR(255),
    IN p_content_type ENUM('TEXT', 'IMAGE', 'VIDEO')
)
BEGIN
    INSERT INTO post(author, content, content_type) VALUES(p_author, p_content, p_content_type);
END//

DELIMITER ;
