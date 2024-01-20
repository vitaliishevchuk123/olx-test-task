<div align="center" style="margin-top: 50px; margin-bottom: 50px">
<span style="border-top-left-radius: 5px; border-bottom-left-radius: 5px; background-color: #ba363f; font-size: 40px; width: 100px; padding-left: 10px; padding-right: 10px; color: white">
OLX
</span>
<span style="border-top-right-radius: 5px; border-bottom-right-radius: 5px; background-color: white; font-size: 40px; width: 100px; padding-left: 10px; padding-right: 10px; color: black">
Price checker
</span>
</div>

## <h2 style="color:#ba363f">Installation</h2>
``` 
    composer install
    php migrate
```

## <h2 style="color:#ba363f">About framework</h2>

### Debugging
Для налагодження використовується `symfony/var-dumper` компонент. Він забезпечує кращу функцію dump() або dd(), яку можна використовувати замість var_dump().

### Request
У PHP запит представлено деякими глобальними змінними ($_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, ...), а відповідь генерується деякими функціями (echo, header(), setcookie(), ...).
<br> Для оброки запиту клієнта напишемо свій власний клас Request.

### Whoops
Інтерфейс локальних помилок - пакет `filp/whoops`. Whoops — це платформа обробки помилок для PHP. Готовий до роботи, він надає гарний інтерфейс помилок, який допоможе вам налагодити ваші веб-проекти.

### Dotenv Component
Використали пакет `symfony/dotenv` для використання ENV файлів.

### Whoops
Інтерфейс локальних помилок - пакет `filp/whoops`. Whoops — це платформа обробки помилок для PHP. Готовий до роботи, він надає гарний інтерфейс помилок.