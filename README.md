### Cách chạy dự án 

1. Cài đặt các dependency của Laravel: `composer install`
2. Tạo file môi trường: `cp .env.example .env`
3. Tạo key cho ứng dụng: `php artisan key:generate`
4. Chạy các migration: `php artisan migrate`
5. Chạy server Laravel: `php artisan serve`

### Cài đặt và chạy NPM

1. Cài đặt các package JavaScript: `npm install`
2. Chạy: `npm run` 

### Cài đặt XAMPP và kết nối database 

1. Tải và cài đặt XAMPP từ [đây](https://www.apachefriends.org/index.html).
2. Mở XAMPP Control Panel và bắt đầu các dịch vụ.

### Kết nối database trong Laravel

1. Mở file `.env` và cấu hình thông tin database.
2. Sử dụng Laravel Eloquent ORM hoặc Laravel Query Builder để tương tác với database.

Lưu ý: Cài đặt Composer, PHP, và Node.js trước khi thực hiện các bước trên.

### Import Database qua PHPMyAdmin

1. Mở PHPMyAdmin, chọn database cần import.
2. Chọn tab "Import".
3. Chọn "Choose File" và tải file `php2.sql` từ [đây](https://github.com/beovan/PHP2/blob/main/php2.sql).
4. Nhấn "Go" để bắt đầu import.