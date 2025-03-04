DROP PROCEDURE IF EXISTS sp_delete_post_reports;
DELIMITER //

CREATE PROCEDURE sp_delete_post_reports (
    IN p_post_id INT UNSIGNED
)
BEGIN
    DELETE FROM post_report WHERE post_id = p_post_id;
END//

DELIMITER ;