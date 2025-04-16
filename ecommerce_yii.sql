-- USERS
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    middlename VARCHAR(50),
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('user','admin') DEFAULT 'user',
    
    address TEXT
);


INSERT INTO users (username, password, firstname, middlename, lastname, email, role) VALUES
('admin', '$2y$10$mTuOYYcmweU/AWLOKh/iC.5.AzUHCzlWtDT76NTS4rIszzAYZmc5i', 'admin', NULL, 'NULL', 'admin@example.com', 'admin'),
('user', '$2y$10$fUZ881.pbVvFRby1qOidZeMPeVBspfIl1v9j.vKmO0CiB2IuN3IeS', 'Keihle', 'L.', 'Pascual', 'user@example.com', 'user');

-- CATEGORIES
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

INSERT INTO categories (name) VALUES
('Keyboards'),
('Keycaps'),
('Switches'),
('Accessories');

-- PRODUCTS
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    category_id INT,
    image VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

INSERT INTO products (name, description, price, stock, category_id, image) VALUES
('GMMK Pro', 'Barebones 75% keyboard with aluminum case', 169.99, 20, 1, 'gmmk_pro.jpg'),
('Keychron Q1', 'Prebuilt keyboard with VIA support', 189.00, 15, 1, 'keychron_q1.jpg'),
('Akko Jelly Switches', 'Linear mechanical switches - 45pcs', 24.99, 50, 3, 'akko_jelly.jpg'),
('GMK Bento Keycap Set', 'High-quality keycap set with a Bento theme', 119.00, 10, 2, 'gmk_bento.jpg');

-- TAGS
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO tags (name) VALUES
('Hot-swappable'),
('Barebones'),
('Pre-built'),
('Wireless'),
('DIY Kit');

-- PRODUCT_TAGS
CREATE TABLE product_tags (
    product_id INT,
    tag_id INT,
    PRIMARY KEY (product_id, tag_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- Tagging: GMMK Pro → Barebones, Hot-swappable, DIY Kit
INSERT INTO product_tags (product_id, tag_id) VALUES
(1, 1), (1, 2), (1, 5);

-- Tagging: Keychron Q1 → Pre-built, Hot-swappable
INSERT INTO product_tags (product_id, tag_id) VALUES
(2, 1), (2, 3);

-- CART
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    status ENUM('active', 'ordered') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO cart (user_id, status) VALUES (2, 'active');

-- CART ITEMS
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    product_id INT,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO cart_items (cart_id, product_id, quantity) VALUES
(1, 1, 1),
(1, 3, 2);

-- ORDERS
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    cart_id INT,
    total DECIMAL(10,2),
    status ENUM('pending','paid','cancelled') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE CASCADE
);

INSERT INTO orders (user_id, cart_id, total, status) VALUES
(2, 1, 219.97, 'paid');

-- PAYMENTS
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    method VARCHAR(50),
    amount DECIMAL(10,2),
    payment_status ENUM('successful', 'failed') DEFAULT 'successful',
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

INSERT INTO payments (order_id, method, amount, payment_status) VALUES
(1, 'Credit Card', 219.97, 'successful');
