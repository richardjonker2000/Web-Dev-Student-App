<?php

namespace app\models;

use amnah\yii2\user\models\Role;
use amnah\yii2\user\models\User;
use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $program_id
 *
 * @property User $user
 * @property Program $program
 * @property StudentSubject[] $studentSubjects
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_id', 'program_id'], 'required'],
            [['user_id', 'program_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['name'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Program::className(), 'targetAttribute' => ['program_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
            'program_id' => 'Program ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Program]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }

    /**
     * Gets query for [[StudentSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSubjects()
    {
        return $this->hasMany(StudentSubject::className(), ['student_id' => 'id']);
    }

    public static function findByUserOrNew($user_id){
        $model = self::find()->joinWith('user')->andWhere(['user.id' => $user_id])->one();
        if (!$model) {
            $model = new Student();
            $model->user_id = $user_id;
        }
        return $model;
    }

    public function enroll(){
        $res = false;
        if($this->save()) {
            $student_role = Role::findOne(['name' => 'Student']);
            $user = User::findOne($this->user_id);
            if($student_role && $user) {
                $user->role_id = $student_role->id;
                $res = $user->save();

            }
        }
        return($res);
    }
}
