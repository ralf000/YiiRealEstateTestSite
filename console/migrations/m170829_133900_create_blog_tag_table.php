<?php

use yii\db\Schema;
use yii\db\Migration;

class m170829_133900_create_blog_tag_table extends Migration
{
    public function up()
    {
        $this->createTable('blog_tag', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull()
        ]);
        $this->addForeignKey('fk_blog_tag_blog_id', 'blog_tag', 'blog_id', 'blog', 'id');
        $this->addForeignKey('fk_blog_tag_tag_id', 'blog_tag', 'tag_id', 'tag', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_blog_tag_blog_id', 'blog_tag');
        $this->dropForeignKey('fk_blog_tag_tag_id', 'blog_tag');
        $this->dropTable('blog_tag');
    }
}
