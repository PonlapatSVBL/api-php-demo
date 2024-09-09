# ใช้ PHP เป็นพื้นฐาน
FROM php:8.2-apache

# ตั้งค่า Directory
WORKDIR /var/www/html

# คัดลอกโค้ด PHP ไปที่ Docker image
COPY . /var/www/html/

# ติดตั้ง dependencies ที่จำเป็น (ถ้ามี)
RUN docker-php-ext-install mysqli

# เปิดใช้งาน Apache mod_rewrite
RUN a2enmod rewrite
