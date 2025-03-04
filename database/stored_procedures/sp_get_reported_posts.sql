DROP PROCEDURE IF EXISTS sp_get_reported_posts;
DELIMITER //

CREATE PROCEDURE sp_get_reported_posts ()
BEGIN
    SELECT U.id AS post_author, U.username AS post_author_username, P.id AS post_id, P.post, P.type AS post_type,
            P.date_posted AS post_date, COUNT(*) AS report_num
    FROM user U
    JOIN post P ON P.author = U.id
    JOIN post_report R ON R.post_id = P.id
    GROUP BY R.post_id 
    ORDER BY report_num DESC;
END//

DELIMITER ;