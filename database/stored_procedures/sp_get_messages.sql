DROP PROCEDURE IF EXISTS sp_get_messages;
DELIMITER //

CREATE PROCEDURE sp_get_messages (
    IN p_user1_id INT UNSIGNED,
    IN p_user2_id INT UNSIGNED
)
BEGIN
    SELECT M.id, M.author, M.reply_to, M.message, M.type, M.date_messaged, P.first_name, P.last_name
    FROM message M
    JOIN profile P ON P.user_id = M.author
    WHERE (M.author = p_user1_id AND M.recipent = p_user2_id) OR (M.author = p_user2_id AND M.recipent = p_user1_id);
END//

DELIMITER ;