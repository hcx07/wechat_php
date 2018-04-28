<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property int $cate_id
 * @property string $author
 * @property string $content
 * @property string $intime
 * @property int $views
 */
class Article extends \yii\db\ActiveRecord
{
    public $username;
    public $guest_count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'views','is_top','author_id'], 'integer'],
            [['content','img'], 'string'],
            [['update_time'], 'default','value'=>time()],
            [['is_top'], 'default','value'=>0],
            [['views'], 'default','value'=>0],
            [['title'], 'string', 'max' => 50],
            [['title'], 'required'],
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
            'cate_id' => 'Cate ID',
            'author' => 'Author',
            'content' => 'Content',
            'created_time' => 'Intime',
            'views' => 'Views',
        ];
    }
}
