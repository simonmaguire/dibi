IF OBJECT_ID('orders', 'U') IS NOT NULL DROP TABLE orders;
IF OBJECT_ID('products', 'U') IS NOT NULL DROP TABLE products;
IF OBJECT_ID('customers', 'U') IS NOT NULL DROP TABLE customers;


CREATE TABLE products (
	product_id int NOT NULL IDENTITY(11,1),
	title varchar(50) NOT NULL,
	PRIMARY KEY(product_id)
);
CREATE INDEX [title] ON [dbo].[products] ([title]);

SET IDENTITY_INSERT products ON;
INSERT INTO products (product_id, title) VALUES (1, 'Chair');
INSERT INTO products (product_id, title) VALUES (2, 'Table');
INSERT INTO products (product_id, title) VALUES (3, 'Computer');
SET IDENTITY_INSERT products OFF;

CREATE TABLE customers (
	customer_id int NOT NULL IDENTITY(11,1),
	name varchar(50) NOT NULL,
	PRIMARY KEY(customer_id)
);

SET IDENTITY_INSERT customers ON;
INSERT INTO customers (customer_id, name) VALUES (1, 'Dave Lister');
INSERT INTO customers (customer_id, name) VALUES (2, 'Arnold Rimmer');
INSERT INTO customers (customer_id, name) VALUES (3, 'The Cat');
INSERT INTO customers (customer_id, name) VALUES (4, 'Holly');
INSERT INTO customers (customer_id, name) VALUES (5, 'Kryten');
INSERT INTO customers (customer_id, name) VALUES (6, 'Kristine Kochanski');
SET IDENTITY_INSERT customers OFF;

CREATE TABLE orders (
	order_id int NOT NULL IDENTITY(11,1),
	customer_id int NOT NULL,
	product_id int NOT NULL,
	amount float NOT NULL,
	order_date DATE NOT NULL,
	PRIMARY KEY(order_id)
);

SET IDENTITY_INSERT orders ON;
INSERT INTO orders (order_id, customer_id, product_id, amount, order_date) VALUES (1, 2, 1, 7, '2020-01-01');
INSERT INTO orders (order_id, customer_id, product_id, amount, order_date) VALUES (2, 2, 3, 2, '2020-02-01');
INSERT INTO orders (order_id, customer_id, product_id, amount, order_date) VALUES (3, 1, 2, 3, '2020-03-01');
INSERT INTO orders (order_id, customer_id, product_id, amount, order_date) VALUES (4, 6, 3, 5, '2020-04-01');
SET IDENTITY_INSERT orders OFF;
