<div class="">
<?

use frontend\components\Common;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
 use demogorgorn\ajax\AjaxSubmitButton;
?>

    <div id="slider" class="sl-slider-wrapper">

        <div class="sl-slider">

            <?
             foreach ($result_general as $row):
                 ?>
                 <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                     <div class="sl-slide-inner">
                         <div class="bg-img" style="background-image: url('<?= Common::getImageAdvert($row)[0] ?>')"></div>
                         <h2><a href="<?=  Common::getUrlAdvert($row)?>"><?= Common::getTitleAdvert($row) ?></a></h2>
                         <blockquote>
                             <p class="location"><span class="glyphicon glyphicon-map-marker"></span> <?= $row['address'] ?></p>
                             <p><?= Common::substr($row['description']) ?></p>
                             <cite>$ <?= $row['price'] ?></cite>
                         </blockquote>
                     </div>
                 </div>

                 <?
             endforeach;
            ?>

        </div><!-- /sl-slider -->



        <nav id="nav-dots" class="nav-dots">
            <?
             if ($count_general >= 1):
                 ?>
                 <span class="nav-dot-current"></span>
                 <?
             endif;
            ?>

            <?
             if ($count_general > 1):
                 foreach (range(2, $count_general) as $line):
                     ?>
                     <span></span>
                     <?
                 endforeach;
             endif;
            ?>
        </nav>

    </div><!-- /slider-wrapper -->
</div>



<div class="banner-search">
    <div class="container">
        <!-- banner -->
        <h3>Buy, Sale & Rent</h3>
        <div class="searchbar">
            <div class="row">
                <?=Html::beginForm(Url::to('main/main/find/'),'get') ?>
                <div class="col-lg-6 col-sm-6">
                    <?=Html::textInput('propert', '', ['class' => 'form-control']) ?>
                    <div class="row">
                        <div class="col-lg-3 col-sm-4">
                            <?=Html::dropDownList('price', '',[
                                '150000-200000' => '$150,000 - $200,000',
                                '200000-250000' => '$200,000 - $250,000',
                                '250000-300000' => '$250,000 - $300,000',
                                '300000' =>'$300,000 - above',
                            ],['class' => 'form-control', 'prompt' => 'Price']) ?>
                        </div>
                        <div class="col-lg-3 col-sm-4">

                            <?=Html::dropDownList('apartment', '',[
                                'Apartment',
                                'Building',
                                'Office Space',
//                                prompt - значение по умолчанию
                            ],['class' => 'form-control', 'prompt' => 'Property']) ?>
                        </div>
                        <div class="col-lg-3 col-sm-4">
                            <?//=Html::submitButton('Find Now', ['class' => 'btn btn-success']) ?>
                            
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
                            
                        </div>
                    </div>
                    <?=Html::endForm() ?>

                </div>
                <?
                if(Yii::$app->user->isGuest):
                    ?>
                    <div class="col-lg-5 col-lg-offset-1 col-sm-6 ">
                        <p>Join now and get updated with all the properties deals.</p>
                        <button class="btn btn-info"   data-toggle="modal" data-target="#loginpop">Login</button>        </div>
                <?
                endif;
                ?>
            </div>
        </div>
        <div id="output"></div>
    </div>  
</div>
<!-- banner -->
<div class="container">
    <div class="properties-listing spacer"> <a href="buysalerent.html"  class="pull-right viewall">View All Listing</a>
        <h2>Featured Properties</h2>
        <div id="owl-example" class="owl-carousel">
            <? foreach ($featured as $row): ?>
                 <div class="properties">
                     <div class="image-holder"><img src="<?= Common::getImageAdvert($row)[0] ?>"  class="img-responsive" alt="properties"/>
                         <div class="status <?= ($row['sold']) ? 'sold' : 'new' ?>"><?= Common::getType($row) ?></div>
                     </div>
                     <h4><a href="<?=  Common::getUrlAdvert($row)?>" ><?= Common::getTitleAdvert($row) ?></a></h4>
                     <p class="price">Price: $<?= $row['price'] ?></p>
                     <div class="listing-detail"><span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room"><?= $row['bedroom'] ?></span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room"><?= $row['livingroom'] ?></span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Parking"><?= $row['parking'] ?></span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Kitchen"><?= $row['kitchen'] ?></span> </div>
                     <a class="btn btn-primary" href="<?=  Common::getUrlAdvert($row)?>">View Details</a>
                 </div>
             <? endforeach; ?>
        </div>
    </div>
    <div class="spacer">
        <div class="row">
            <div class="col-lg-6 col-sm-9 recent-view">
                <h3>About Us</h3>
                <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.<br><a href="about.html" >Learn More</a></p>

            </div>
            <div class="col-lg-5 col-lg-offset-1 col-sm-3 recommended">
                <h3>Recommended Properties</h3>
                <div id="myCarousel" class="carousel slide">
                    <ol class="carousel-indicators">
                        <?
                         if ($recommend_count >= 1):
                             ?>
                             <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                             <?
                         endif;
                        ?>

                        <?
                         if ($recommend_count > 1):
                             foreach (range(1, $recommend_count - 1) as $count):
                                 ?>
                                 <li data-target="#myCarousel" data-slide-to="<?= $count ?>"></li>
                                 <?
                             endforeach;
                         endif;
                        ?>
                    </ol>
                    <!-- Carousel items -->
                    <div class="carousel-inner">

                        <?
                         $i = 0;
                         foreach ($recommend as $rec):
                             ?>
                             <div class="item <?= ($i == 0) ? 'active' : '' ?>">
                                 <div class="row">
                                     <div class="col-lg-4"><img src="<?= Common::getImageAdvert($rec)[0] ?>"  class="img-responsive" alt="properties"/></div>
                                     <div class="col-lg-8">
                                         <h5><a href="<?=  Common::getUrlAdvert($rec)?>" ><?= Common::getTitleAdvert($rec) ?></a></h5>
                                         <p class="price">$<?= $rec['price'] ?></p>
                                         <a href="<?=  Common::getUrlAdvert($rec)?>"  class="more">More Detail</a> </div>
                                 </div>
                             </div>
                             <?
                             $i++;
                         endforeach;
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>