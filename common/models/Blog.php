<?php

namespace common\models;

use common\components\behaviours\StatusBehaviour;
use vova07\imperavi\actions\UploadAction;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\image\drivers\Image;
use yii\image\drivers\Image_GD;
use yii\image\drivers\Image_Imagick;
use yii\web\UploadedFile;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $image
 * @property integer $status
 * @property User $author
 * @property Tag[] $tags
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Blog extends ActiveRecord
{
    public $file;

    public $tags_array;

    const STATUSES = ['Неопубликовано', 'Опубликовано'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'statusBehaviour' => [
                'class' => StatusBehaviour::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content', 'image'], 'string'],
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['file'], 'image'],
            ['tags_array', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'image' => 'Изображение',
            'file' => 'Изображение',
            'status' => 'Статус',
            'user_id' => 'User ID',
            'tags_array' => 'Теги',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getThumbnail()
    {
        $url = Url::home(true) . 'uploads/images/blog/';
        return $url . '50x50/' . $this->image;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->tags_array = $this->tags;
    }

    public function beforeSave($insert)
    {
        if ($file = UploadedFile::getInstance($this, 'file')) {
            $dir = Yii::getAlias('@images') . '/blog/';
            if (!file_exists($dir)){
                FileHelper::createDirectory($dir);
            }
            if (!file_exists($dir . '50x50')){
                FileHelper::createDirectory($dir . '50x50');
            }
            if (!file_exists($dir . '800x')){
                FileHelper::createDirectory($dir . '800x');
            }
            $this->image = time() . '_' . Yii::$app->getSecurity()->generateRandomString(4) . '.' . $file->getExtension();
            $file->saveAs($dir . $this->image);
            /** @var Image_GD $img */
            $img = Yii::$app->image->load($dir . $this->image);
            $img->background('#fff', 0)
                ->resize('50', 50, Image::INVERSE)
                ->crop('50', '50')
                ->save($dir . '50x50/' . $this->image, 90);
            $img = Yii::$app->image->load($dir . $this->image);
            $img->background('#fff', 0)
                ->resize('800', null, Image::INVERSE)
                ->save($dir . '800x/' . $this->image, 90);
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $blogTagIds = ArrayHelper::map($this->tags, 'id', 'id');
        if (empty($this->tags_array)) {
            $this->tags_array = [];
        }

        foreach ($this->tags_array as $tagId) {
            if (!in_array($tagId, $blogTagIds)) {
                $blogTag = new BlogTag();
                $blogTag->blog_id = $this->id;
                $blogTag->tag_id = $tagId;
                $blogTag->save();
            }
        }
        foreach ($blogTagIds as $blogTagId) {
            if (!in_array($blogTagId, $this->tags_array)) {
                BlogTag::deleteAll(['tag_id' => $blogTagId]);
            }
        }
    }

    public function getTagTitles()
    {
        return array_map(function ($tag) {
            return $tag->title;
        }, $this->tags);
    }

    public function getUsername()
    {
        return $this->author->username;
    }


    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getBlogTags()
    {
        return $this->hasMany(BlogTag::className(), ['blog_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('blogTags');
    }


}
