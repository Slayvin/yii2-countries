Yii2 Countries
==============

1. Introduction
----------------------------

**Yii2 Countries** --- Multilingual extension for the Yii2 framework, which provides a list of all countries and their demonym, plus a migration file and an AR model.
- Requires `yeesoft/yii2-multilingual` ([Github](https://github.com/yeesoft/yii2-multilingual))
- Multilanguage support


2. Dependencies
----------------------------

- php >= 7.0
- composer
- MySql >= 5.5
- yeesoft/yii2-multilingual


3. Installation
----------------------------

Via composer:

```composer require "slayvin/yii2-countries": "^1.0.0"```

or add the following in section **require** of composer.json:
```
"require": {
    "slayvin/yii2-countries": "^1.0.0"
}
```
and run command ```composer install```,

or command ```composer update```, if all yii2 project extensions are already installed.

4. Usage
----------------------------

### Main properties

The **namespace** for classes: ```slayvin\countries```.


### Application config

To add the tables to the database, run the provided migration:

```php
'controllerMap' => [
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationNamespaces' => [
                'slayvin\countries\migrations'
            ],
        ]
    ],
```

### Database tables


Country table "countries"


|  iso  | selectable |  default  |
|-------|------------|-----------|
|  AD   |      0     |     0     |
|  AE   |      0     |     0     |
|  ...  |     ...    |    ...    |
|  ZW   |      0     |     0     |


Translation table "countries_lang"


| country_iso |  language |         name         |    demonym    |
|-------------|-----------|----------------------|---------------|
|     AD      |    en     | Andorra              | Andorran      |
|     AE      |    en     | United Arab Emirates | Emirati       |
|     ...     |    ...    | ...                  |      ...      |
|     ZW      |    fr     | Zimbabwe             | Zimbabwéen-ne |
   

Here, we have:
* non-multilingual fields: **iso**, **selectable**, **default**
* multilingual fields: **name**, **demonym**
    

License
----------------------------

Licensed under the [MIT license](http://opensource.org/licenses/MIT).
