# Bitrix cli

Командная строка для bitrix

```bash
    composer global require alex19pov31/bitrix-cli
```

### Вывод списка команд

```bash
    bxcli list
```

* helper - вспомогательные функции
    * **helper:1c-import** - ручной запуск импорта с 1С из фалов (в разработке)
    * **helper:translate** - автоматический перевод сообщений из локальной папки lang
* new - создание новых сущностей bitrix
    * **new:component** - создать компонент
    * **new:component-template** - создать шаблон компонента
    * **new:module** - создать модуль
    * **new:project** - создать проект
    * **new:site-template** - создать шаблон сайта
* server - команды администрирования
    * **server:backup** - создание бэкапа проекта
    * **server:db-dump** - создание дампа БД

...