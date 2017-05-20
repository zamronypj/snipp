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
    country VARCHAR(2) NOT NULL DEFAULT '',
    created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY userid_idx (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE groups (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    display_name VARCHAR(50) NOT NULL,
    UNIQUE KEY name_idx (name)
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

CREATE TABLE categories (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    display_name VARCHAR(50) NOT NULL,
    UNIQUE KEY name_idx (name)
);

CREATE TABLE snippets (
    id VARCHAR(7) PRIMARY KEY NOT NULL,
    title VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    user_id INT,  /* snippet can be created by non-user so user_id allow NULL and do not maintain integrity with users table */
    download_count INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY userid_idx (user_id, updated_at),
    KEY updated_at_idx (updated_at)
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

CREATE TABLE snippet_categories (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    snippet_id VARCHAR(7) NOT NULL,
    category_id INT NOT NULL,
    KEY categoryid_snippetid_idx (category_id, snippet_id),
    KEY snippetid_idx (snippet_id),
    FOREIGN KEY (snippet_id) REFERENCES snippets(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

