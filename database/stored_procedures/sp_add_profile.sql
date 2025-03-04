DROP PROCEDURE IF EXISTS sp_add_profile;
DELIMITER //

CREATE PROCEDURE sp_add_profile (
    IN p_user_id INT UNSIGNED,
    IN p_first_name VARCHAR(255),
    IN p_last_name VARCHAR(255),
    IN p_bio VARCHAR(50),
    IN p_dob DATE
) 
BEGIN
    INSERT INTO profile(user_id, first_name, last_name, bio, dob) 
    VALUES(p_user_id, p_first_name, p_last_name, p_bio, p_dob);
END//

DELIMITER ;
