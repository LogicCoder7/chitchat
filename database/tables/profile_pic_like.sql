CREATE TABLE profile_pic_like (
    profile_pic_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    UNIQUE(profile_pic_id, user_id),
    FOREIGN KEY(profile_pic_id) REFERENCES profile_pic(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE
);
