<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "guestbook".
 *
 * @property int $id
 * @property string $username
 * @property int $art_id
 * @property string $content
 * @property string $intime
 * @property int $flag
 */
class Guestbook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guestbook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'flag'], 'integer'],
            [['content'], 'string'],
            [['intime'], 'safe'],
            [['username'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'article_id' => 'Art ID',
            'content' => 'Content',
            'intime' => 'Intime',
            'flag' => 'Flag',
        ];
    }
}
