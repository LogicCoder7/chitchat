DROP PROCEDURE IF EXISTS sp_get_reported_posts;
DELIMITER //

CREATE PROCEDURE sp_get_reported_posts ()
BEGIN
    SELECT P.id, P.author, P.content, P.content_type, P.date_posted, U.username AS author_username,
           COUNT(*) AS report_num
    FROM post P
    JOIN user U ON U.id = P.author
    JOIN post_report R ON R.post_id = P.id
    GROUP BY R.post_id 
    ORDER BY report_num DESC;
END//

DELIMITER ;