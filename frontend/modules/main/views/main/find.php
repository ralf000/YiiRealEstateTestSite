<?

 use demogorgorn\ajax\AjaxSubmitButton;
 use frontend\widgets\HotWidget;
 use yii\helpers\Html;
 use yii\helpers\Url;
 use yii\web\JsExpression;
?>

<div class="properties-listing spacer">

    <div class="row">
        <div class="col-lg-3 col-sm-4 ">
            <?= Html::beginForm(Url::to('/main/main/find/'), 'get') ?>
            <div class="search-form"><h4><span class="glyphicon glyphicon-search"></span> Search for</h4>
                <?= Html::textInput('propert', $request->get('propert'), ['class' => 'form-control', 'placeholder' => 'Search of Properties']) ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?=
                         Html::dropDownList('price', $request->get('price'), [
                             '150000-200000' => '$150,000 - $200,000',
                             '200000-250000' => '$200,000 - $250,000',
                             '250000-300000' => '$250,000 - $300,000',
                             '300000'        => '$300,000 - above',
                                 ], ['class' => 'form-control', 'prompt' => 'Price'])
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?=
                         Html::dropDownList('apartment', $request->get('apartment'), [
                             'Apartment',
                             'Building',
                             'Office Space',
                                 ], ['class' => 'form-control', 'prompt' => 'Property'])
                        ?>
                    </div>
                </div>
                <!--<button class="btn btn-primary">Find Now</button>-->
                <?php
                 AjaxSubmitButton::begin([
                     'label'       => 'Поиск',
                     'ajaxOptions' => [
                         'type'    => 'get',
                         'url'     => '/main/main/find-result',
                         /* 'cache' => false, */
                         'success' => new JsExpression('function(html){
            $("#output").html(html);
            }'),
                     ],
                     'options'     => ['class' => 'btn btn-success', 'type' => 'submit'],
                 ]);
                 AjaxSubmitButton::end();
                ?>
<?= Html::endForm() ?>

            </div>


            <div class="hot-properties hidden-xs">

<? echo HotWidget::widget() ?>

            </div>


        </div>


        <div class="col-lg-9 col-sm-8">
            <div class="row">
                <div id="output"></div>


            </div>
        </div>
    </div>
</div>