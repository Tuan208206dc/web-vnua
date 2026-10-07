CREATE DATABASE IF NOT EXISTS db_quanly_sanpham;

USE db_quanly_sanpham;

CREATE TABLE IF NOT EXISTS san_pham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_sp VARCHAR(255) NOT NULL,
    gia DECIMAL(10,2) NOT NULL,
    so_luong INT NOT NULL,
    mo_ta TEXT
);

INSERT INTO san_pham (ten_sp, gia, so_luong, mo_ta)
VALUES
('Bánh mì chà bông', 15000, 20, 'Bánh mì tươi nhân chà bông'),
('Sữa tươi trân châu', 30000, 15, 'Sữa tươi thêm trân châu'),
('Bánh Chocopie', 45000, 10, 'Hộp bánh socola'),
('Trứng gà ta', 28000, 50, 'Vỉ 10 quả'),
('Mỳ tôm', 50000, 10, 'Mỳ tôm Hảo Hảo chua cay');