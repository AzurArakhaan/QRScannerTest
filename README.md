# Тестовое задание QR Scanner
## Задача
Реализовать сканнер заранее известных QR-кодов, для отметок Агентов на различных Мероприятиях Администратором

## Что выполнено
- Реализован проект на PHP, используя методологию MVC,
- Авторизация/Выход из системы,
- Вывод списка мероприятий,
- Сканирование QR-Кодов,
- И другое

## Что нужно знать
- Для развертывания проекта, в репозиторий была добавлена папка **Essentials**, в которой лежат все необходимые для тестов файлы. А именно - два изображения к QR-кодами Агентов и последний дамп базы данных проекта.
- Перед началом тестирования, в файле **config.php** нужно прописать верные данные базы данных, иначе все запросы к API будут возвращать ошибку **404**
- Авторизация происходит по статичным данным. Пара логин|пароль: **admin | testpassword**
- Также отредактируйте файл manifest.json и manifest.webmanifest, а именно URL и START_URL

## Другая информация
- Проект был реализован приблизительно за 6 часов рабочего времени.

## Credit
Проект выполнен с помощью следующих библиотек:
- [Axios](https://github.com/axios/axios)
- [Bootstrap](https://getbootstrap.com/)
- [JQuery](https://jquery.com/)
- [VueJS 2](https://v2.vuejs.org/)
- [Vue QRCode Reader](https://gruhn.github.io/vue-qrcode-reader/)
