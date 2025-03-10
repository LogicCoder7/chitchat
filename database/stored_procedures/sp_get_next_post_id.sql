DROP PROCEDURE IF EXISTS sp_get_next_post_id;
DELIMITER //

CREATE PROCEDURE sp_get_next_post_id ()
BEGIN
    SELECT id + 1 FROM post WHERE content_type != 'text' ORDER BY id DESC LIMIT 1;
END//

DELIMITER ;