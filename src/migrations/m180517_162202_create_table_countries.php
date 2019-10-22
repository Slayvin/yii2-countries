<?php

namespace slayvin\countries\migrations;

use yii\db\Migration;

class m180517_162202_create_table_countries extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName == 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        /**
         * @property string $iso (3)
         * @property string $name (32)
         * @property string $nationality (32)
         */
        $this->createTable('{{%countries}}', [
            'iso' => $this->char(3)->notNull(),
            'selectable' => $this->boolean()->defaultValue(false),
            'default' => $this->boolean()->defaultValue(false),
            // translatable fields
            'name' => $this->string(63)->defaultValue(''),
            'demonym' => $this->string(63)->defaultValue(null),
            ], $tableOptions);

        $this->addPrimaryKey('pk-country', '{{%countries}}', 'iso');

        $this->createTable('{{%countries_lang}}', [
            'country_iso' => $this->char(3)->notNull(),
            'language' => $this->string(6)->notNull(),
            // translatable fields
            'name' => $this->string(63)->notNull()->defaultValue(''),
            'demonym' => $this->string(63)->defaultValue(null),
            ], $tableOptions);

        $this->addForeignKey('fk-country_iso', '{{%countries_lang}}', 'country_iso', '{{%countries}}', 'iso', 'CASCADE', 'CASCADE');
        $this->createIndex('unique-country-lang', '{{%countries_lang}}', ['language', 'country_iso'], true);
        $this->createIndex('idx-country-lang', '{{%countries_lang}}', 'language');

        $countriesData = require(__DIR__ . '/../data/countries.php');
        $countries     = [];
        foreach ($countriesData as $iso => $translations) {
            $countries[] = [
                $iso,
                $translations['en'][0] ?? '',
                $translations['en'][1] ?? null,
            ];
        }
        $countriesTranslations = [];
        foreach ($countriesData as $iso => $translations) {
            foreach ($translations as $language => $translation) {
                $countriesTranslations[] = [
                    $iso,
                    $language,
                    isset($translation[0]) ? $translation[0] : '',
                    isset($translation[1]) ? $translation[1] : null
                ];
            }
        }
        try {
            $this->batchInsert('{{%countries}}', ['iso', 'name', 'demonym'], $countries);
            $this->batchInsert('{{%countries_lang}}', ['country_iso', 'language', 'name', 'demonym'], $countriesTranslations);
        } catch (\Exception $e) {
            echo print_r($e->getMessage());
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk-country_iso', '{{%countries_lang}}');
        $this->dropIndex('unique-country-lang', '{{%countries_lang}}');
        $this->dropIndex('idx-country-lang', '{{%countries_lang}}');
        $this->dropTable('{{%countries_lang}}');

        $this->dropPrimaryKey('pk-country', '{{%countries}}');
        $this->dropTable('{{%countries}}');
    }
}
