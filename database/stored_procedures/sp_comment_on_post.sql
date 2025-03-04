DROP PROCEDURE IF EXISTS sp_comment_on_post;
DELIMITER //

CREATE PROCEDURE sp_comment_on_post (
    IN p_post_id INT UNSIGNED,
    IN p_author INT UNSIGNED,
    IN p_reply_to INT UNSIGNED,
    IN p_comment VARCHAR(255)
)
BEGIN
    INSERT INTO post_comment(post_id, author, reply_to, comment) 
    VALUES(p_post_id, p_author, p_reply_to, p_comment);
END//

DELIMITER ;
