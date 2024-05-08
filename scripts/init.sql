-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
	is_admin TINYINT(1) NOT NULL,
	CONSTRAINT unique_username UNIQUE (username)
);

-- Insert default admin user, From https://stackoverflow.com/questions/5903702/md5-and-salt-in-mysql, how to use MD5 and salt
INSERT INTO users (username, password, is_admin) VALUES ('admin', SHA2(CONCAT("admin",'password'), 512), 1);
INSERT INTO users (username, password, is_admin) VALUES ('admin2', SHA2(CONCAT("admin2",'password2'), 512), 1);

