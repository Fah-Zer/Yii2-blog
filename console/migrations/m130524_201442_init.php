<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ], $tableOptions);

        $this->insert('{{%role}}', [
            'name' => 'admin'
        ]);
        
        $this->insert('{{%role}}', [
            'name' => 'user'
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'image' => $this->string(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-user-role_id',
            'user',
            'role_id'
        );

        $this->addForeignKey(
            'fk-user-role_id',
            'user',
            'role_id',
            'role',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(0),
            'name' => $this->string()->notNull()->unique(),
        ], $tableOptions);

        $this->insert('{{%category}}', [
            'name' => 'category 1'
        ]);

        $this->insert('{{%category}}', [
            'name' => 'category 2'
        ]);

        $this->insert('{{%category}}', [
            'name' => 'category 3'
        ]);

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'image' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-article-user_id',
            'article',
            'user_id'
        );

        $this->addForeignKey(
            'fk-article-user_id',
            'article',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-article-category_id',
            'article',
            'category_id'
        );

        $this->addForeignKey(
            'fk-article-category_id',
            'article',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%commentary}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'addressee_id' => $this->integer(),
            'sender_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-commentary-article_id',
            'commentary',
            'article_id'
        );

        $this->addForeignKey(
            'fk-commentary-article_id',
            'commentary',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-commentary-addressee_id',
            'commentary',
            'addressee_id'
        );

        $this->addForeignKey(
            'fk-commentary-addressee_id',
            'commentary',
            'addressee_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-commentary-sender_id',
            'commentary',
            'sender_id'
        );

        $this->addForeignKey(
            'fk-commentary-sender_id',
            'commentary',
            'sender_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%commentary}}');
        $this->dropTable('{{%article}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%role}}');
        $this->dropTable('{{%category}}');
    }
}
