CREATE TABLE post_like (
    post_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    PRIMARY KEY(post_id, user_id),
    FOREIGN KEY(post_id) REFERENCES post(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE
);
