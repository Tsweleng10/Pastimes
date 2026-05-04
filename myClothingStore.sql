-- Drop tables in reverse FK order
DROP TABLE IF EXISTS tbl_clothes;
DROP TABLE IF EXISTS tbl_user;

CREATE TABLE tbl_user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('buyer','seller','admin') DEFAULT 'buyer',
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tbl_clothes (
    clothes_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255),
    status ENUM('available','sold') DEFAULT 'available',
    FOREIGN KEY (seller_id) REFERENCES tbl_user(user_id) ON DELETE SET NULL
);

-- Insert 30 users 
INSERT INTO tbl_user (full_name, email, password_hash, role, is_verified) VALUES
('John Doe','j.doe@abc.co.za','29ef52e7563626a96cea7f4b4085c124','buyer',1),
('Jane Smith','jane.smith@xyz.co.za','5f4dcc3b5aa765d61d8327deb882cf99','buyer',1),
... up to 30 entries ...
;

-- Insert 30 clothes
INSERT INTO tbl_clothes (seller_id, title, description, price, image_path) VALUES
(1, 'Winter boots', 'women''s winter leather boots with Ziper', 289.00, 'winterBoots.jpeg'),


;