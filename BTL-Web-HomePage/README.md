# Hướng Dẫn Chạy Dự Án

Dự án này sử dụng máy chủ tích hợp sẵn của PHP để chạy trực tiếp mà không cần cấu hình phức tạp qua Apache hay Nginx. Vui lòng làm theo các bước dưới đây để khởi chạy trang web.

### Bước 1: Khởi động Server PHP
Mở Terminal (PowerShell hoặc Command Prompt) tại thư mục gốc của dự án và chạy dòng lệnh sau:

```bash
C:\xampp\php\php.exe -S localhost:8000 -t public
```

### Bước 2: Truy cập giao diện web
Sau khi server đã chạy thành công, bạn hãy mở trình duyệt web (Chrome, Edge, Firefox,...) và truy cập vào đường dẫn sau để xem trang chủ:

[http://localhost:8000/public_entry.php](http://localhost:8000/public_entry.php)
