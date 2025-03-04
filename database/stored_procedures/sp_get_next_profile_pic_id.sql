DROP PROCEDURE IF EXISTS sp_get_next_profile_pic_id;
DELIMITER //

CREATE PROCEDURE sp_get_next_profile_pic_id ()
BEGIN
    SELECT id + 1 FROM profile_pic ORDER BY id DESC LIMIT 1;
END//

DELIMITER ;