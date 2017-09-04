<?php

use yii\db\Migration;

class m170831_074452_change_blog_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('blog', 'status', $this->integer()->after('content')->notNull()->defaultValue('0'));
    }

    public function safeDown()
    {
        $this->dropColumn('blog', 'status');
    }
}
