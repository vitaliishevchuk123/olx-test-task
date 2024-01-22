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

## <h2 style="color:#ba363f">About project</h2>

### Файл [cron_task.php](cron_task.php) 
Запускає перевірку цін всіх оголошень з подальшим оповіщенням користувачів про зміну.
Для запуску:
``` 
    php cron_task.php
```
За бажання можна налаштувати крон файл сервера щоб команда виконувалась періодично.

### Debugging
Для налагодження використовується `symfony/var-dumper` компонент. Він забезпечує кращу функцію dump() або dd(), яку можна використовувати замість var_dump().

### Request
У PHP запит представлено деякими глобальними змінними ($_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, ...), а відповідь генерується деякими функціями (echo, header(), setcookie(), ...).
<br> Для оброки запиту клієнта напишемо свій власний клас Request.

### Whoops
Інтерфейс локальних помилок - пакет `filp/whoops`. Whoops — це платформа обробки помилок для PHP. Готовий до роботи, він надає гарний інтерфейс помилок, який допоможе вам налагодити ваші веб-проекти.

### Dotenv Component
Використали пакет `symfony/dotenv` для використання ENV файлів.

### Send mails
Для відправки листів використали бібліотеку PHPMailer `phpmailer/phpmailer` і Mailhog.
MailHog - це інструмент для перехоплення та перегляду електронної пошти в розробці. Він надає спрощений SMTP-сервер, який можна використовувати для відправлення електронної пошти з вашого додатка або веб-сайту під час розробки та тестування.

### Testing
Для тестування використано PHPUnit тести. Створено тестову БД. Тести написані так, щоб абстрагуватись від логіки виконання і її можна було легко підміняти.
Для запуску тестів `./vendor/bin/phpunit tests`

### Scraping
Для відслідковування зміни ціни використали пакет `weidner/goutte` для парсингу веб сторінок. Також зробили можливість замінити реалізацію на пакет `symfony/panther`, який дозволяє дочекатись поки завантажиться js сторінці. Корисно для сайтів SPA де основне дерево загружається не за допомогою пхп зразу, а через js пізніше (Vue JS, React...)