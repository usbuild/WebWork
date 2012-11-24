<?php

/**
 * This is the model class for table "request".
 *
 * The followings are the available columns in table 'request':
 * @property string $id
 * @property integer $blog_id
 * @property string $head
 * @property string $content
 * @property string $tag
 * @property string $time
 * @property integer $sender
 * @property string $state
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Blog $blog
 * @property User $sender0
 */
class Request extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Request the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'request';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('blog_id, head, sender', 'required'),
            array('blog_id, sender', 'numerical', 'integerOnly' => true),
            array('state', 'length', 'max' => 7),
            array('type', 'length', 'max' => 5),
            array('content, tag', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, blog_id, head, content, tag, time, sender, state, type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'blog' => array(self::BELONGS_TO, 'Blog', 'blog_id'),
            'sender0' => array(self::BELONGS_TO, 'User', 'sender'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'blog_id' => 'Blog',
            'head' => 'Head',
            'content' => 'Content',
            'tag' => 'Tag',
            'time' => 'Time',
            'sender' => 'Sender',
            'state' => 'State',
            'type' => 'Type',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('blog_id', $this->blog_id);
        $criteria->compare('head', $this->head, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('tag', $this->tag, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('sender', $this->sender);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('type', $this->type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}