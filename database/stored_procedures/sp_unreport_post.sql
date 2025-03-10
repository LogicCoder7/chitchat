DROP PROCEDURE IF EXISTS sp_unreport_post;
DELIMITER //

CREATE PROCEDURE sp_unreport_post (
    IN p_post_id INT UNSIGNED,
    IN p_reporter INT UNSIGNED
)
BEGIN
    DELETE FROM post_report WHERE post_id = p_post_id AND reporter = p_reporter;
END//

DELIMITER ;