# Symfony
Install prepared 4.* skeleton with `composer create-project`.

> **Note:**
You can apply all the actions described in there by applying
patches from [SymfonyChanges](../SymfonyChanges)
´git am path/to/patches/*.patch´


## Default skeleton
Symfony skeleton come (actually Symfony recipes deploy) with
non layered structure where entity's, controllers, etc are in
`src/Entity/*`  and  `src/Controller/*`  , doctrine and routes
are configured trough annotations and all custom service
definitions lay in  `config/services.yaml`.
When building bigger applications, recommended way is to use modular
structure.
## Annotations to Yaml & ORM-XML
Annotations are very good for making applications with maker bundle,
but for scalable long term applications, holding configuration
separately from functionality is a must.
## Doctrine
Configure doctrine ORM XML files under `config/orm`, for example
`config/orm/Product.ProductEntity.orm.xml`. The name depends from
your class name, for  `Product/Entity/ProductEntity`  it is
`config/doctrine/Product.Entity.ProductEntity.orm.xml.`

This itself is configured in config/packages/doctrine.yaml which
after changes should look like
```
# ...
doctrine:
    # ...
    orm:
        # ...
        mappings:
        App:
            is_bundle: false
            type: xml
            dir: '%kernel.project_dir%/config/orm'
            prefix: 'App'
            alias: App
            mapping: true
```
See strait forward example from
[https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/xml-mapping.html#example](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/xml-mapping.html#example)

## Routes
Configure routes in `config/routes`, for example
`config/routes/Product.yaml`.
Remove  `config/routes/annotations.yaml`.
Route definition in config/routes/module_name.yaml could look like
```
module_route:
    path:       /module/route
    controller: App\ModuleName\ControllerName::methodName
    methods:    GET
```
## Modular structure
Put separate business logic to separate (sub) folders:
`Product/ProductEntity`,  `Product/ProductAdmin`,
`Product/ProductApiController`. Product prefix for all them
is optional but makes you application more navigable when you
have many modules - it's easier to Navigate to  `ProductEntity`
rather that choose from 20 different Entities.

Also you must keep you  `src/ModuleName`  folder clean, so use
nesting when needed:  `Product/Entity/ProductEntity`,
`Product/Admin/ProductAdmin`,
`Product/Controller/ProductApiController`. You can nest as much as
you see fit. The choice is always yours with Symfony.

### Remove non modular structure and configuration

`rm -rf src/Controller`, `src/Entity`, `src/Repository` and
```
App\Controller\:
resource: '../src/Controller'
tags: ['controller.service_arguments']
```
from `config/services.yaml` or you get error
`'The file "../src/Controller" does not exist
(in: /path/to/your/project/config).'` when you have removed
`src/Controller`.
### Configure module structure configuration

Run  `mkdir config/modules/`  and add to  `app/Kernel.php`
`configureContainer`  method this line to include module configurations:
`$loader->load($confDir.'/{modules}/*'.self::CONFIG_EXTS, 'glob');`
### controllers
Downside of using modular structure is that you have to define
controllers by hand in module_name.yaml:
```
App\ModuleName\ControllerName:
    tags: ['controller.service_arguments']
```
## .env
Commit the default  `.env`  file, and make  `.env.local` for your needs.
## Migrations
Migrations is to make changes to database, migrations will be generated
to src/Migrations folder by command  `doctrine:migrations:diff`.
See also [https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html](https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html) and [https://dev.to/alphpkeemik/testing-doctrine-migration-in-symfony-project-3n42](https://dev.to/alphpkeemik/testing-doctrine-migration-in-symfony-project-3n42).
## Unit testing
For testing different Doctrine related functionality (complex queries,
event listeners) sometimes easier way is to use Doctrine directly.
For that add
`<env name="DATABASE_URL" value="sqlite:///%kernel.project_dir%/var/test-data.db" />`
`phpunit.xml.dist php`  section and use [DoctrineTestTrait](DoctrineTestTrait.php)
for setting up and cleaning database before and after tests.