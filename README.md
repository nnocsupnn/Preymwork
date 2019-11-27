# Preymwork 1.1

_**Preymwork**_ is a hubby project of mine. built on **illuminate/laravel, maximef/debugbar and Twig**.
this project is for custom static websites.

![Sample](https://i.ibb.co/TcJz8L6/preymwork-sample.png)

### Environment Settings
* **DEBUG** set true if you want to use the debuging bar.
* **TWIG_CACHING** set true if you want to cache the templates.
```$xslt
DEBUG=true
TWIG_CACHING=false
```

## Make
* **controller** for making controller class.
* **model** for making model class.
```$xslt
php make controller ControllerName:methodName

php make model ModelName:table
```


