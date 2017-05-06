CREATE TABLE users (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(16) NOT NULL,
    userpswd CHAR(255) NOT NULL,
    email VARCHAR(320) NOT NULL,
    UNIQUE KEY usernamepaswd_idx (username, userpswd),
    UNIQUE KEY emailpaswd_idx (email, userpswd)
);

CREATE TABLE user_details (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    country VARCHAR(2) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP NOT NULL,
    UNIQUE KEY userid_idx (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE groups (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL
);

CREATE TABLE user_groups (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    group_id INT NOT NULL,
    user_id INT NOT NULL,
    KEY groupuserid_idx (group_id, user_id),
    KEY userid_idx (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (group_id) REFERENCES groups(id)
);

CREATE TABLE snippets (
    id VARCHAR(7) PRIMARY KEY NOT NULL,
    snippet TEXT NOT NULL,
    user_id INT,  /* snippet can be created by non-user so user_id allow NULL and do not maintain integrity with users table */
    download_count INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP NOT NULL,
    KEY userid_idx (user_id)
);

CREATE TABLE acls (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    snippet_id VARCHAR(7) NOT NULL,
    group_id INT NOT NULL,
    KEY groupid_snippetid_idx (group_id, snippet_id),
    KEY snippetid_idx (snippet_id),
    FOREIGN KEY (snippet_id) REFERENCES snippets(id),
    FOREIGN KEY (group_id) REFERENCES groups(id)
);