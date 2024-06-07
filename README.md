### Simple Monitoring App

To install this application, you need to have installed php +8.3

```
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ php artisan serve
```

You can have fake data with:
```
$ php artisan db:seed
```

You can start monitoring with:
```
$ php artisan schedule:work
$ php artisan queue:work
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
