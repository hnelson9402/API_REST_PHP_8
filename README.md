## AUTH
---
>GET public/auth/:email/:password/

Este **EndPoint** devuelve la siguiente información:

```JSON
{
  "status": "ok",
  "message": {
    "name": "hugo",
    "rol": "3",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzA4NTc1NDUsImV4cCI6MTYzMDg3OTE0NSwiZGF0YSI6eyJJRFRva2VuIjoiODQyNGQ0YTZlNDQyNDAxYzMyNzA3YWJkYmI0MWQ0OTBlZGUwMjc2YjczYzQyZGVkNTQxMzA0MDM3MmM1ZWZiZDg2OWM4Nzk3YTg1YmE4MzFjYTZiNWM5YTdhNzY2YjU2MzE1NmIxNDg5OTM2MmY2ZTZjN2JlYzJiN2ZkYjlhMTkifX0.PgnNsqC0VjnMkoD6itROxGP882GH1kBb-xdTwvaejbU"
  }
}
```
***Nota:*** El **Token** lo deben almacenar para realizar las peticiones a la API, y enviarlo en la cabezera(**Header**), con la **key**: Authorization y **value**: Bearer token, más información en: https://jwt.io/ , El **Token** tiene una duración de 6 horas, despues de ese tiempo debes iniciar sesión nuevamente.

## USUARIO
---
>GET public/user/

>GET public/user/:dni/

>POST public/user/

**Nota:** Los siguientes datos son necesarios para registrar un nuevo usuario.

```JSON
{
  "name":"pablo",
  "dni":"11433",
  "email":"prueba1@prueba.com",
  "rol":"2",
  "password":"12345678",
  "confirmPassword":"12345678"
}
```
>PATCH public/user/password/

```JSON
{
 "oldPassword": "123456789",
 "newPassword": "12345678",
 "confirmNewPassword": "12345678"
}
```