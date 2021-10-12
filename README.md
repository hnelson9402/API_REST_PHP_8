## AUTH
---
>GET auth/:email/:password/

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
>GET user/

>GET user/:dni/

>POST user/

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
>PATCH user/password/

```JSON
{
 "oldPassword": "123456789",
 "newPassword": "12345678",
 "confirmNewPassword": "12345678"
}
```
>DELETE user/

```JSON
{
  "IDToken":"5a2f8e6e553815d253e40fa7da9e2d4985814d7a8914d75677d2d06c6fbf9d267657106109c3f76c4e86a7b1914cfdfe7743e741700f4940f070e891530c49be"
}
```
## PRODUCTO

>GET product/

>POST product/

**Nota:** Para registrar el producto, debe enviar los datos atraves de la clase **FormData** de Javascript 

```html
<form enctype="multipart/form-data" id="saveProduct">
  <input type="text" name="name"/>
  <input type="text" name="description"/>
  <input type="number" name="stock"/>  
  <input type="file" name="product"/>
  <input type="submit" value="upload"/>
</form>
```

```javascript
let body = new FormData(document.getElementById("saveProduct"));

fetch('Ruta de la API',{
      headers: {
        Authorization: `Bearer Dirección del token`
      },
      method: 'POST',
      body: body
});
```