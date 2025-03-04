DROP PROCEDURE IF EXISTS sp_is_post_liked;
DELIMITER //

CREATE PROCEDURE sp_is_post_liked (
    IN p_post_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    SELECT 1 FROM post_like WHERE post_id = p_post_id AND user_id = p_user_id;
END//

DELIMITER ;