<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property string $id
 * @property integer $blog_id
 * @property integer $reply_id
 * @property string $content
 * @property string $post_id
 * @property string $time
 *
 * The followings are the available model relations:
 * @property Blog $reply
 * @property Blog $blog
 * @property Post $post
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('blog_id, content, post_id', 'required'),
			array('blog_id, reply_id', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>255),
			array('post_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, blog_id, reply_id, content, post_id, time', 'safe', 'on'=>'search'),
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
			'reply' => array(self::BELONGS_TO, 'Blog', 'reply_id'),
			'blog' => array(self::BELONGS_TO, 'Blog', 'blog_id'),
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
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
			'reply_id' => 'Reply',
			'content' => 'Content',
			'post_id' => 'Post',
			'time' => 'Time',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('blog_id',$this->blog_id);
		$criteria->compare('reply_id',$this->reply_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}