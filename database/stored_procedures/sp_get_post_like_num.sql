DROP PROCEDURE IF EXISTS sp_get_post_like_num;
DELIMITER //

CREATE PROCEDURE sp_get_post_like_num (IN p_post_id INT UNSIGNED)
BEGIN
    SELECT COUNT(*) FROM post_like WHERE post_id = p_post_id;
END//

DELIMITER ;