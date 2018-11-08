# jQuery TreeGrid Extension for Yii 2

This extension inspired by [leandrogehlen/yii2-treegrid](https://github.com/leandrogehlen/yii2-treegrid) but with some improves and bug fixes.
TreeGridView extend `yii\grid\GridView` so you can use all it behaviors like column width options or filtering.

Also this extension include `table-responsive`-version of standard Yii2 GridView(use class `\karakum\grid\GridView`).
To disable this feature just set `'tableWrapperOptions' => false` property.

This is the [jQuery TreeGrid](https://github.com/maxazan/jquery-treegrid) extension for Yii 2. It encapsulates TreeGridView component in terms of Yii widgets,
and thus makes using TreeGridView component in Yii applications extremely easy.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist karakum/yii2-grid "*"
```

or add

```
"karakum/yii2-grid": "*"
```

to the require section of your `composer.json` file.

## How to use

**Model**

```php

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 */
class Tree extends ActiveRecord 
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }  
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name', 'description'], 'string'],
            [['parent_id'], 'integer']
        ];
    }
}
```

**Controller**

```php
use yii\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;

class TreeController extends Controller
{

    /**
     * Lists all Tree models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Tree::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
```

**View**

```php
use karakum\grid\TreeGridView;
  
<?= TreeGridView::widget([
        'dataProvider' => $dataProvider,
//        'keyColumnName' => 'id',                         // these are defaults
//        'parentColumnName' => 'parent_id',
//        'parentRootValue' => null,
        'pluginOptions' => [
			'treeColumn' => 3,                             // name
        ],
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width: 40px;']],
			['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width: 40px;']],
			['attribute' => 'id', 'options' => ['style' => 'width: 100px;']],
            'name',
            'description',
            'parent_id',
            ['class' => 'yii\grid\ActionColumn']
        ]     
      ]); ?>
```

