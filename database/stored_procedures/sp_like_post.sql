DROP PROCEDURE IF EXISTS sp_like_post;
DELIMITER //

CREATE PROCEDURE sp_like_post (
    IN p_post_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    INSERT INTO post_like(post_id, user_id) VALUES(p_post_id, p_user_id);
END//

DELIMITER ;