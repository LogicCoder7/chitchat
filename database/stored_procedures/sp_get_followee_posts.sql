DROP PROCEDURE IF EXISTS sp_get_followee_posts;
DELIMITER //

CREATE PROCEDURE sp_get_followee_posts (IN p_user_id INT UNSIGNED)
BEGIN
    SELECT Po.id, Po.content, Po.content_type, Po.date_posted, Pr.first_name, Pr.last_name FROM post Po 
    JOIN profile Pr ON Pr.user_id = Po.author
    JOIN following F ON F.followee = Po.author
    WHERE F.follower = p_user_id
    ORDER BY Po.date_posted DESC;
END//

DELIMITER ;