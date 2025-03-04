DROP PROCEDURE IF EXISTS sp_delete_profile_pic_comment;
DELIMITER //

CREATE PROCEDURE sp_delete_profile_pic_comment (
    IN p_id INT UNSIGNED,
    IN p_author INT UNSIGNED
)
BEGIN
    DELETE FROM profile_pic_comment WHERE id = p_id AND author = p_author;
END//

DELIMITER ;