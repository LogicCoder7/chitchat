DROP PROCEDURE IF EXISTS sp_comment_on_profile_pic;
DELIMITER //

CREATE PROCEDURE sp_comment_on_profile_pic (
    IN p_profile_pic_id INT UNSIGNED,
    IN p_author INT UNSIGNED,
    IN p_reply_to INT UNSIGNED,
    IN p_comment VARCHAR(255)
)
BEGIN
    INSERT INTO profile_pic_comment(profile_pic_id, author, reply_to, comment) 
    VALUES(p_profile_pic_id, p_author, p_reply_to, p_comment);
END//

DELIMITER ;
