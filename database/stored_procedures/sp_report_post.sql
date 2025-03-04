DROP PROCEDURE IF EXISTS sp_report_post;
DELIMITER //

CREATE PROCEDURE sp_report_post (
    IN p_post_id INT UNSIGNED,
    IN p_reporter INT UNSIGNED
)
BEGIN
    INSERT INTO post_report(post_id, reporter) VALUES(p_post_id, p_reporter);
END//

DELIMITER ;