# [PHP Backend] Passwordless Login System
![Image](https://lh3.googleusercontent.com/drive-viewer/AFDK6gOjH28LbN9UjHTaZkw1eImI4sUEYxRNzSmujA_BEn1E1Z2IIj0pqqzeOrmb9daNW1KanW6YwJqk3pzI5SzzGMc32xJSow=w1715-h932)
#
* Simple & flexible
* Error algorithms
* Integrated email library (PHPMailer)
* Integrated json web token library (Firebase/PHP-JWT)
* Random avatars for new members (Dicebear)
* Compatible with js frameworks (React,Angular,Vue etc...)
* Compatible with every router
* Configurable
* Put & use
#
### How to use;
##### 1) Import sql scripts to your database.
##### 2) Set up database credentials in `Backend.php`.
##### 3) Change your email server settings in `Extras/EMAIL.php`.
##### 4) Upload everything to your hosting.
##### 4) Ready.
#
### Endpoint;
##### 1) newAuth (Create new login key)
Example: `https://yourdomain.com/Backend.php?newAuth&e=loginme@gmail.com`
##### 2) userLogin (Create new session)
Example: `https://yourdomain.com/Backend.php?userLogin&p=f57d0eeaab00888cc090e3589ac30780`
##### 3) userLogout (Remove session)
Example: `https://yourdomain.com/Backend.php?userLogout&t=eyJhbciO.eyJzdWOiIxMD.SflKxw6yJV_adc`
##### 4) getMyData (Get user's data)
Example: `https://yourdomain.com/Backend.php?getMyData&t=eyJhbciO.eyJzdWOiIxMD.SflKxw6yJV_adc`
#
:warning:For more safety, it is recommended to translate the $_GET methods to $_POST.