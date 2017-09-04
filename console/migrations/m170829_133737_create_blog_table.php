<?php

use yii\db\Schema;
use yii\db\Migration;

class m170829_133737_create_blog_table extends Migration
{
    public function up()
    {
        $this->createTable('blog', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull()->unique(),
            'description' => $this->string(255),
            'content' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_blog_user_id', 'blog', 'user_id', 'user', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_blog_user_id', 'blog');
        $this->dropTable('blog');
    }
}
