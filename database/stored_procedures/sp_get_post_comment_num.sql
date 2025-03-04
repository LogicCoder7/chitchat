DROP PROCEDURE IF EXISTS sp_get_post_comment_num;
DELIMITER //

CREATE PROCEDURE sp_get_post_comment_num (IN p_post_id INT UNSIGNED)
BEGIN
    SELECT COUNT(id) FROM post_comment WHERE post_id = p_post_id;
END//

DELIMITER ;