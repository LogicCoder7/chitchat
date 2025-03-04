DROP PROCEDURE IF EXISTS sp_is_post_reported;
DELIMITER //

CREATE PROCEDURE sp_is_post_reported (
    IN p_post_id INT UNSIGNED,
    IN p_user_id INT UNSIGNED
)
BEGIN
    SELECT 1 FROM post_report WHERE post_id = p_post_id AND reporter = p_user_id; 
END//

DELIMITER ;