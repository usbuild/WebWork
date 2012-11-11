<?php

/**
 * This is the model class for table "blog".
 *
 * The followings are the available columns in table 'blog':
 * @property integer $id
 * @property string $domain
 * @property string $name
 * @property integer $owner
 * @property string $avatar
 *
 * The followings are the available model relations:
 * @property User $owner0
 * @property FollowBlog[] $followBlogs
 * @property Post[] $posts
 * @property User[] $users
 */
class Blog extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Blog the static model class
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
        return 'blog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('owner', 'required'),
            array('owner', 'numerical', 'integerOnly' => true),
            array('domain', 'unique'),
            array('domain', 'length', 'min' => 5, 'max' => 30),
            array('name, avatar', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, domain, name, owner, avatar', 'safe', 'on' => 'search'),
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
            'owner0' => array(self::BELONGS_TO, 'User', 'owner'),
            'followBlogs' => array(self::HAS_MANY, 'FollowBlog', 'blog_id'),
            'posts' => array(self::HAS_MANY, 'Post', 'poster'),
            'users' => array(self::HAS_MANY, 'User', 'blog'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'domain' => '域名',
            'name' => '博客名',
            'owner' => 'Owner',
            'avatar' => 'Avatar',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('domain', $this->domain, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('owner', $this->owner);
        $criteria->compare('avatar', $this->avatar, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}