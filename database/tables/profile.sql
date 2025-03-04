CREATE TABLE profile (
    user_id INT UNSIGNED PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    bio VARCHAR(50),
    dob DATE,
    FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE
);
