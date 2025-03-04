CREATE TABLE follow (
    follower INT UNSIGNED NOT NULL,
    followee INT UNSIGNED NOT NULL,
    UNIQUE(followee, follower),
    CONSTRAINT no_self_follow CHECK(follower != followee),
    FOREIGN KEY(followee) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY(follower) REFERENCES user(id) ON DELETE CASCADE
);