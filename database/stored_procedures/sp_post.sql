DROP PROCEDURE IF EXISTS sp_post;
DELIMITER //

CREATE PROCEDURE sp_post (
    IN p_author INT UNSIGNED,
    IN p_post VARCHAR(255),
    IN p_type ENUM('text', 'image', 'video')
)
BEGIN
    INSERT INTO post(author, post, type) VALUES(p_author, p_post, p_type);
END//

DELIMITER ;
