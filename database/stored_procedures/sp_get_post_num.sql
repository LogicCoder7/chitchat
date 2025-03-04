DROP PROCEDURE IF EXISTS sp_get_post_num;
DELIMITER //

CREATE PROCEDURE sp_get_post_num (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT COUNT(id) FROM post WHERE author = p_user_id;
END//

DELIMITER ;