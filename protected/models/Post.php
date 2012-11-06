<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property string $id
 * @property integer $poster
 * @property string $content
 * @property string $type
 * @property string $time
 * @property string $tag
 *
 * The followings are the available model relations:
 * @property Blog $poster0
 */
class Post extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
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
        return 'post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('time', 'required'),
            array('poster', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 5),
            array('content, tag', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, poster, content, type, time, tag', 'safe', 'on' => 'search'),
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
            'blog' => array(self::BELONGS_TO, 'Blog', 'poster'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'poster' => 'Poster',
            'content' => 'Content',
            'type' => 'Type',
            'time' => 'Time',
            'tag' => 'Tag',
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
        $criteria->compare('poster', $this->poster);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('tag', $this->tag, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function __get($name)
    {
        if ($name == 'content' || $name == 'tag')
            return CJSON::decode(parent::__get($name));
        else
            return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (is_array($value) || is_object($value)) {
            $value = CJSON::encode($value);
        }
        parent::__set($name, $value);
    }


}