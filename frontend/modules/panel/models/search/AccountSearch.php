<?php

namespace app\modules\panel\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\panel\models\Account;

/**
 * AccountSearch represents the model behind the search form about `app\modules\panel\models\Account`.
 */
class AccountSearch extends Account
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'host_id', 'remmenber_me'], 'integer'],
            [['tb_account', 'tb_pwd', 'tb_user_id', 'tb_nick_name', 'access_token', 'refresh_token'], 'safe'],
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
        $query = Account::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'host_id' => $this->host_id,
            'remmenber_me' => $this->remmenber_me,
        ]);

        $query->andFilterWhere(['like', 'tb_account', $this->tb_account])
            ->andFilterWhere(['like', 'tb_pwd', $this->tb_pwd])
            ->andFilterWhere(['like', 'tb_user_id', $this->tb_user_id])
            ->andFilterWhere(['like', 'tb_nick_name', $this->tb_nick_name])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'refresh_token', $this->refresh_token]);

        return $dataProvider;
    }
}
