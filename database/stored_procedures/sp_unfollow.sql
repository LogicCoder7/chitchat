DROP PROCEDURE IF EXISTS sp_unfollow;
DELIMITER //

CREATE PROCEDURE sp_unfollow (
    IN p_follower INT UNSIGNED,
    IN p_followee INT UNSIGNED
)
BEGIN
    DELETE FROM follow WHERE follower = p_follower AND followee = p_followee;
END//

DELIMITER ;