<?php

use Phinx\Migration\AbstractMigration;

class CreateBannerTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
//    public function change()
//    {
//
//    }

    /**
     * Migrate Up.
     */
    public function up()
    {
//        $this->execute("
//           CREATE TABLE IF NOT EXISTS `active_list` (
//            `id` int(11) NOT NULL AUTO_INCREMENT,
//            `status`  enum('ACTIVEING','ACTIVENOTBEGIN','ACTIVEOVER') NOT NULL DEFAULT 'ACTIVENOTBEGIN' COMMENT 'ACTIVEING进行活动ACTIVENOTBEGIN还未开始的活动ACTIVEOVER已结束的活动',
//            `types`   enum('NEWUSER','RECORD','ORDINARY','OTHER') NOT NULL  DEFAULT 'OTHER'  COMMENT 'NEWUSER新手活动，RECORD投资活动，ORDINARY常规活动，other其它活动',
//            `imglink` varchar(255) NOT NULL   COMMENT '标题',
//            `alink`   varchar(255) NOT NULL COMMENT '活动链接',
//            `title`   varchar(255) NOT NULL COMMENT '标题',
//            `remarks` varchar(255)  COMMENT '活动备注',
//            `start_time`  int(11) NOT NULL,
//            `end_time`    int(11) NOT NULL,
//            `create_time` int(11) NOT NULL,
//            `update_time` int(11) NOT NULL,
//            `is_remove` int(11) NOT NULL  DEFAULT 0,
//            PRIMARY KEY (`id`)
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题活动列表' AUTO_INCREMENT=1;
//        ");


        $exists = $this->hasTable('banner');
        if (!$exists) {
            $banner = $this->table('banner');
//            $banner->rename('banners');
            $banner->addColumn('id', 'integer')
                ->addColumn('image_url', 'string',array('limit' => 200))
                ->addColumn('redirect_url', 'string',array('default'=>'#'))
                ->addColumn('created', 'datetime')
                ->addColumn('updated', 'datetime', array('null' => true))
                ->create();
//                ->save();
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
//        $this->execute('DROP table  IF EXISTS banner');

        $exists = $this->hasTable('banner');
        if ($exists) {
            $this->dropTable('banner');
        }
    }
}
