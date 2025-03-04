DROP PROCEDURE IF EXISTS sp_delete_post_report;
DELIMITER //

CREATE PROCEDURE sp_delete_post_report (
    IN p_post_id INT UNSIGNED,
    IN p_reporter INT UNSIGNED
)
BEGIN
    DELETE FROM post_report WHERE post_id = p_post_id AND reporter = p_reporter;
END//

DELIMITER ;