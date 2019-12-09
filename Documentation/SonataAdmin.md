# Installing
`composer require sonata-project/admin-bundle`
# Configuring
* Service
```
App\ModuleName\SonataAdminName:
    arguments: [~, App\ModuleName\ModelName, ~]
    tags:
        - { name: sonata.admin, manager_type: orm, label: Module name }

```
* [List](https://sonata-project.org/bundles/doctrine-orm-admin/master/doc/reference/list_field_definition.html)
* [Form](https://sonata-project.org/bundles/doctrine-orm-admin/master/doc/reference/form_field_definition.html)