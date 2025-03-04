DROP PROCEDURE IF EXISTS sp_follow;
DELIMITER //

CREATE PROCEDURE sp_follow (
    IN p_follower INT UNSIGNED,
    IN p_followee INT UNSIGNED
)
BEGIN
    INSERT INTO follow(follower, followee) VALUES(p_follower, p_followee);
END//

DELIMITER ;