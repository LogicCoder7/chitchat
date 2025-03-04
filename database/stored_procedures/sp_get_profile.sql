DROP PROCEDURE IF EXISTS sp_get_profile;
DELIMITER //

CREATE PROCEDURE sp_get_profile (
    IN p_user_id INT UNSIGNED
)
BEGIN
    SELECT P.first_name, P.last_name, P.bio, P.dob, U.username
    FROM profile P
    JOIN user U ON U.id = P.user_id
    WHERE P.user_id = p_user_id;
END//

DELIMITER ;
