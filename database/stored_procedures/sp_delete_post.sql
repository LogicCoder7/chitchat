DROP PROCEDURE IF EXISTS sp_delete_post;
DELIMITER //

CREATE PROCEDURE sp_delete_post (
    IN p_id INT UNSIGNED,
    IN p_author INT UNSIGNED
)
BEGIN
    SELECT post AS file_name FROM post WHERE id = p_id AND author = p_author AND type != 'text';
    DELETE FROM post WHERE id = p_id AND author = p_author;
END//

DELIMITER ;