DROP PROCEDURE IF EXISTS sp_get_next_message_id;
DELIMITER //

CREATE PROCEDURE sp_get_next_message_id ()
BEGIN
    SELECT id + 1 FROM message WHERE type!='text' ORDER BY id DESC LIMIT 1;
END//

DELIMITER ;