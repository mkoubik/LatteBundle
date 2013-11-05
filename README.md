LatteBundle
===========

Installation
------------

- `composer require mkoubik/latte-bundle`
- register `App\FrontBundle\AppFrontBundle` in your `AppKernel`
- add `'latte'` to `framework.templating.engine` in `app/config/config.yml`
- (if you are using `@Template` annotation, change it to `@Template(engine="latte")`

ToDo
----
- assetic support
- template cache warmer
- support for `@Bundle:Controller:action` syntax in `{link}` and `n:href`
- support for `@Bundle:Resources/views/file.html.latte` syntax in `{extends}`
- form macros
- cache macros
- `{ifCurrent}` support
- `{contentType}` and `{status}` support
