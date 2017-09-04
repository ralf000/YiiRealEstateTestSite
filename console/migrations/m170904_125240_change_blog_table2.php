<?php

use yii\db\Migration;

class m170904_125240_change_blog_table2 extends Migration
{
    public function safeUp()
    {
        $this->addColumn('blog', 'image', $this->string()->after('content'));
    }

    public function safeDown()
    {
        $this->dropColumn('blog', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170904_125240_change_blog_table2 cannot be reverted.\n";

        return false;
    }
    */
}
