## Token install

- branch name is 'master'
- postman screen shot added
- api_token migration field also add

##### storage command file link
```
php artisan storage:link
<domain>/<under public folder, folder name>/AE/DU.png
like 'public/country' should 'domain/country/AE/DU.png'
```
##### command run to run project

```
composer update
php artisan migrate
```



##### auth API ajax code

```
var settings = {
  "async": true,
  "crossDomain": true,
  "url": "http://localhost:8000/api/user",
  "method": "GET",
  "headers": {
    "authorization": "Bearer c2bca4367022daf236293e1e98964a60",
    "cache-control": "no-cache",
    "postman-token": "907b4be9-77a5-01c0-49fa-1e629da387d4"
  }
}

$.ajax(settings).done(function (response) {
  console.log(response);
});
```

![Alt text](/postman.png?raw=true "Permission change to write read")# extra-core
