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
 * @property Blog $blog
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
            array('blog', 'numerical', 'integerOnly' => true),
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
            'myblog' => array(self::BELONGS_TO, 'Blog', 'blog'),
            'blogs' => array(self::HAS_MANY, 'Blog', 'owner'),
            'follow_blogs' => array(self::HAS_MANY, 'FollowBlog', 'user_id'),
            'follow_tags' => array(self::HAS_MANY, 'FollowTag', 'user_id'),
            'writer' => array(self::HAS_MANY, 'Cowriter', 'user_id'),
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
            'blog' => 'Blog',
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
        $criteria->compare('blog', $this->blog);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getPosts($offset = 0)
    {
        foreach ($this->follow_blogs as $blog_id) {
            $blogs[] = $blog_id->blog_id;
        }

        $tags = array();
        foreach ($this->follow_tags as $tag) {
            $tags[] = CJSON::encode($tag->tag);
        }
        $criteria = new CDbCriteria();
        $criteria->order = 'time DESC';
        $criteria->limit = 10;
        $criteria->offset = $offset;
        if (isset($blogs))
            $criteria->compare('blog_id', $blogs, false, 'OR');
        foreach ($tags as $tag) {
            $criteria->addSearchCondition('tag', $tag, true, 'OR');
        }
        $criteria->compare('isdel', 0);
        if (!empty($tags) || isset($blogs)) {
            $posts = Post::model()->findAll($criteria);
        } else
            $posts = array();
        return $posts;
    }

    public function likes($start)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('isdel', 0);
        $criteria->join = 'JOIN `like` ON t.id = like.post_id AND like.blog_id = ' . $this->blog;
        $criteria->limit = 10;
        $criteria->offset = $start;
        $criteria->order = 'like.time DESC';
        return Post::model()->findAll($criteria);
    }

    public function followBlogs()
    {
        $criteria = new CDbCriteria();
        $criteria->join = "JOIN follow_blog as f ON t.id = f.blog_id AND f.user_id = " . $this->id;
        return Blog::model()->findAll($criteria);
    }


    public function likeCount()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('isdel', 0);
        $criteria->join = 'JOIN `like` ON t.id = like.post_id AND like.blog_id = ' . $this->blog;

        return Post::model()->count($criteria);
    }

    public function followBlogCount()
    {
        return FollowBlog::model()->countByAttributes(array('user_id' => $this->id));
    }

    public function writerCount()
    {
        return Cowriter::model()->countByAttributes(array('user_id' => $this->id));
    }

    public function writers()
    {
        $c = new CDbCriteria();
        $c->join = "JOIN cowriter ON cowriter.blog_id = t.id AND cowriter.user_id=" . $this->id;
        return Blog::model()->findAll($c);
    }


}
