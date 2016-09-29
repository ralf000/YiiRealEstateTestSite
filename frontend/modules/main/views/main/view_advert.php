<div class="row">
    <div class="col-lg-3 col-sm-4 hidden-xs">

        <? echo \frontend\widgets\HotWidget::widget() ?>

    </div>

    <div class="col-lg-9 col-sm-8 ">

        <h2><?=\frontend\components\Common::getTitleAdvert($model) ?></h2>
        <div class="row">
            <div class="col-lg-8">
                <div class="property-images">
                    <!-- Slider Starts -->
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators hidden-xs">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <?
                            foreach(range(1,count($images) - 1) as $s):
                                ?>
                                <li data-target="#myCarousel" data-slide-to="<?=$s ?>" class=""></li>
                            <?
                            endforeach;
                            ?>
                        </ol>
                        <div class="carousel-inner">
                            <!-- Item 1 -->

                            <div class="item active">
                                <img src="<?=\frontend\components\Common::getImageAdvert($model)[0] ?>"  class="properties" alt="properties" />
                            </div>
                            <?
                            foreach($images as $image):
                                ?>
                                <div class="item">
                                    <img src="<?=$image ?>"  class="properties" alt="properties" />
                                </div>
                            <?
                            endforeach
                            ?>
                        </div>
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <!-- #Slider Ends -->

                </div>




                <div class="spacer"><h4><span class="glyphicon glyphicon-th-list"></span> Properties Detail</h4>
                    <p> <?=$model->description ?></p>
                </div>
                <div><h4><span class="glyphicon glyphicon-map-marker"></span> Location</h4>
                    <div class="well">
                        <?=$map->display()?>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="col-lg-12  col-sm-6">
                    <div class="property-info">
                        <p class="price">$ <?=$model->price ?></p>
                        <p class="area"><span class="glyphicon glyphicon-map-marker"></span> <?=$model->address ?></p>

                        <div class="profile">
                            <span class="glyphicon glyphicon-user"></span> Agent Details
                            <p><?=$model->user->email ?><br><?=$model->user->username ?></p>
                        </div>
                    </div>

                    <h6><span class="glyphicon glyphicon-home"></span> Availabilty</h6>
                    <div class="listing-detail">
                        <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room"><?=$model->bedroom ?></span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room"><?=$model->livingroom ?></span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Parking"><?=$model->parking ?></span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Kitchen"><?=$model->kitchen ?></span> </div>

                </div>
                <div class="col-lg-12 col-sm-6 ">
                    
                        <?= frontend\widgets\FeedBackWidget::widget()?>

                </div>
            </div>
        </div>
    </div>
</div>