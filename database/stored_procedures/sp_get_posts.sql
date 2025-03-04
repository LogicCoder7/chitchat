DROP PROCEDURE IF EXISTS sp_get_posts;
DELIMITER //

CREATE PROCEDURE sp_get_posts (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT id, post, type, date_posted FROM post P 
    WHERE author = p_user_id ORDER BY date_posted DESC;
END//

DELIMITER ;