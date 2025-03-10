CREATE TABLE post_report (
    post_id INT UNSIGNED NOT NULL,
    reporter INT UNSIGNED NOT NULL,
    PRIMARY KEY(post_id, reporter),
    FOREIGN KEY(post_id) REFERENCES post(id) ON DELETE CASCADE,
    FOREIGN KEY(reporter) REFERENCES user(id) ON DELETE CASCADE
);