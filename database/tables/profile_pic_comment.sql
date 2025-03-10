CREATE TABLE profile_pic_comment (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_pic_id INT UNSIGNED NOT NULL,
    author INT UNSIGNED NOT NULL,
    reply_to INT UNSIGNED,
    content VARCHAR(255) NOT NULL,
    date_commented DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(profile_pic_id) REFERENCES profile_pic(id) ON DELETE CASCADE,
    FOREIGN KEY(author) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY(reply_to) REFERENCES profile_pic_comment(id) ON DELETE CASCADE
);
