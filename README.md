## API Документация

### Описание

Этот API предоставляет функционал для работы с гостями. 

### Методы

#### GET

Описание:

* Возвращает список всех гостей.
* Если в запросе указан параметр id, то возвращает информацию о госте с заданным id.

Параметры:

* id: (необязательно) ID гостя.

Пример запроса:
GET /guests 
Пример ответа:
```ruby
[
  {
    "id": 1,
    "first_name": "Иван",
    "last_name": "Иванов",
    "phone": "+79123456789",
    "email": "ivan.ivanov@example.com",
    "country": "Россия"
 },
 {
   "id": 2,
   "first_name": "Петр",
   "last_name": "Петров",
   "phone": "+79123456790",
   "email": "petr.petrov@example.com",
   "country": "Россия"
 }
]
```
Пример запроса с id:
GET /guests?id=1
Пример ответа:
```ruby
{
  "id": 1,
  "first_name": "Иван",
  "last_name": "Иванов",
  "phone": "+79123456789",
  "email": "ivan.ivanov@example.com",
  "country": "Россия"
}
```
#### POST

Описание:

* Добавляет нового гостя.

Параметры:

* first_name: Имя гостя.
* last_name: Фамилия гостя.
* phone: Номер телефона гостя.
* email: Email гостя.
* country: Страна гостя.

Пример запроса:
POST /guests
Тело запроса:
```ruby
{
  "first_name": "Сергей",
  "last_name": "Сергеев",
  "phone": "+79123456791",
  "email": "sergey.sergeev@example.com",
  "country": "Россия"
}
Пример ответа:
{
    "status": "Гость успешно создан"
}
```
#### PATCH

Описание:

* Обновляет информацию о госте с заданным id.

Параметры:

* id: ID гостя.
* first_name: (необязательно) Новое имя гостя.
* last_name: (необязательно) Новая фамилия гостя.
* phone: (необязательно) Новый номер телефона гостя.
* email: (необязательно) Новый email гостя.
* country: (необязательно) Новая страна гостя.

Пример запроса:
PATCH /guests/
Тело запроса:
```ruby
{
  "phone": "+79123456792",
  "email": "ivan.ivanov.new@example.com"
}
```
Пример ответа:
```ruby
{
    "status": "Гость успешно Обновлен"
}
```
#### DELETE

Описание:

* Удаляет гостя с заданным id.

Параметры:

* id: ID гостя.

Пример запроса:
DELETE /guests/1
Пример ответа:
```ruby
{
    "status": "Гость успешно удален"
}
```
### Ошибки

Статусные коды:

* 200 - Успешный запрос.
* 400 - Ошибка в запросе (неверные данные, отсутствующие параметры).
* 404 - Запрашиваемый ресурс не найден.
* 500 - Внутренняя ошибка сервера.

Пример ответа с ошибкой:
{
  "error": "Неверные данные."
}
