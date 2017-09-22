<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Blog;
use yii\helpers\ArrayHelper;

/**
 * BlogSearch represents the model behind the search form about `common\models\Blog`.
 */
class BlogSearch extends Blog
{
    public $author;
    public $tags;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'updated_at'], 'integer'],
            [['title', 'description', 'content', 'author', 'tags', 'status', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Blog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);


        $dataProvider->setSort([
            'attributes' => array_merge(
                $dataProvider->getSort()->attributes,
                [
                    'author' => [
                        'asc' => ['user.username' => SORT_ASC],
                        'desc' => ['user.username' => SORT_DESC],
                    ]
                ])
        ]);

        $this->load($params['BlogSearch']);
        $this->created_at = Yii::$app->request->get('created_at');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['tags', 'author'])
            ->andFilterWhere([
                'blog.id' => $this->id,
                'user_id' => $this->user_id,
                'tag.id' => $this->tags,
                'blog.status' => $this->status
            ]);

        $query->andFilterWhere(['like', 'blog.title', $this->title])
            ->andFilterWhere(['like', 'blog.description', $this->description])
            //->andFilterWhere(['>', 'blog.created_at', $this->created_at])
            //или можно искать диапазон дат больше входной даты и меньше входной + 1 день
            /*->andFilterWhere([
                'and',
                ['>', 'blog.created_at', $this->created_at],
                ['<', 'blog.created_at', $this->created_at + (60 * 60 * 24)]
            ])*/
            ->andFilterWhere(['like', 'username', $this->author]);

        if ($this->created_at) {
            $created_at = explode(' -', $this->created_at);
            $query->andWhere([
                'and',
                ['>', 'blog.created_at', strtotime($created_at[0])],
                ['<', 'blog.created_at', strtotime($created_at[1])]
            ]);
        }
        return $dataProvider;
    }
}
