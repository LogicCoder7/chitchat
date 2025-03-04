DROP PROCEDURE IF EXISTS sp_unlike_post;
DELIMITER //

CREATE PROCEDURE sp_unlike_post (
    IN p_post_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    DELETE FROM post_like WHERE post_id = p_post_id AND user_id = p_user_id;
END//

DELIMITER ;