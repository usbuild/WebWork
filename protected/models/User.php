<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $avatar
 *
 * The followings are the available model relations:
 * @property Blog[] $blogs
 */
class User extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
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
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password, salt', 'required'),
            array('name, email, avatar', 'length', 'max' => 255),
            array('password, salt', 'length', 'max' => 64),
            array('email', 'email'),
            array('email,name', 'unique', 'className' => 'User'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, email, password, salt, avatar', 'safe', 'on' => 'search'),
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
            'blogs' => array(self::HAS_MANY, 'Blog', 'owner'),
            'follow_blogs' => array(self::HAS_MANY, 'FollowBlog', 'user_id'),
            'follow_tags' => array(self::HAS_MANY, 'FollowTag', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'salt' => 'Salt',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('avatar', $this->avatar, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getPosts($count = 10)
    {
        foreach ($this->follow_blogs as $blog_id) {
            $blogs[] = $blog_id->blog_id;
        }
        foreach ($this->follow_tags as $tag) {
            $tags[] = CJSON::encode($tag->tag);
        }
        $criteria = new CDbCriteria();
        if (isset($blogs))
            $criteria->compare('poster', $blogs, false, 'OR');
        foreach($tags as $tag) {
                $criteria->addSearchCondition('tag', $tag, true, 'OR');
        }

        if (isset($tags) || isset($posts))
            $posts = Post::model()->findAll($criteria);
        else
            $posts = array();
        return $posts;
    }
}