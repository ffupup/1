CREATE TABLE `users` (
    `id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT, -- 主键，自增
    `username` VARCHAR(20) NOT NULL, -- 用户名，最大长度为 20，不能为空
    `password` VARCHAR(255) NOT NULL, -- 密码，最大长度为 255，不能为空（用于存储哈希后的密码）
    `user_type` ENUM('Customer', 'Business', 'Admin') NOT NULL, -- 用户类型，只能是三者之一

    PRIMARY KEY (`id`) -- 设置主键
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `menu` (
    `item_id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT, -- 主键，自增
    `item_name` VARCHAR(50) NOT NULL, -- 菜品名称，最大长度为50
    `item_category` VARCHAR(10) NOT NULL, -- 菜品分类，最大长度为10
    `item_price` DECIMAL(10,2) NOT NULL, -- 菜品价格，小数类型，精度为10，保留2位小数
    `user_id` INT(20) UNSIGNED NOT NULL, -- 用户ID，关联菜单项与用户
    `image_url` VARCHAR(255) NULL, -- 图片URL，允许为空，最大长度为255

    PRIMARY KEY (`item_id`) -- 设置主键
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `qrcode` (
    `qr_id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT, -- 主键，自增
    `qr_link` VARCHAR(255) NOT NULL, -- QR码对应的链接，最大长度255
    `user_id` INT(20) UNSIGNED NOT NULL, -- 用户ID，关联用户，最大长度20
    `table_name` VARCHAR(10) NOT NULL, -- 餐桌名称，最大长度10
    
    PRIMARY KEY (`qr_id`) -- 设置主键
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders` (
    `order_id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT, -- 主键，自增
    `user_id` INT(20) UNSIGNED NOT NULL, -- 用户ID
    `business_id` INT(20) UNSIGNED NOT NULL, -- 商家ID
    `customer_ordering_id` INT(20) UNSIGNED NOT NULL, -- 顾客订单ID
    `table_name` VARCHAR(10) NOT NULL, -- 餐桌名称，最大长度10
    `order_status` ENUM('Active', 'Complete') NOT NULL, -- 订单状态：'Active' 或 'Complete'
    
    PRIMARY KEY (`order_id`) -- 设置主键
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `order_items` (
    `order_items_id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT, -- 主键，自增
    `order_id` INT(20) UNSIGNED NOT NULL, -- 外键，引用 orders 表中的 order_id
    `item_id` INT(20) NOT NULL, -- 商品 ID
    `item_price` DECIMAL(10, 2) NOT NULL, -- 商品价格，10 位数，2 位小数
    `order_quantity` INT(10) NOT NULL, -- 订单商品数量，最大长度 10
    
    PRIMARY KEY (`order_items_id`), -- 设置主键
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`) ON DELETE CASCADE -- 设置外键，删除时级联
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
