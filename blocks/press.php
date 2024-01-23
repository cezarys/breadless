<?php
global $section;

$title = $section['title']; //text

$press = $section['press']; //repeater

$columns = [[], []];

/*
  foreach ($press as $key => $single_press) {



  $columns[$key % 2][] = $single_press;
  } */
?>
<div id="press">
    <div class="container-fluid">
     

        <div class="faq-wrapper">
            <div class="row row-spaced">
                <?php
                foreach ($press as $key => $single_press) {
                    ?>
                    <div class="col-sm-6" data-delay="100|100|6">
                        <?php
                        $magazine_name = $single_press['magazine_name']; //text
                        $article_title = $single_press['article_title']; //text
                        $url = $single_press['url']; //text
                        ?>
                        <div class="one-press">
                            <a href="<?php echo $url ?>" target="_blank">
                                <span class="op-top">
                                    <span>
                                        <?php echo $magazine_name ?>
                                    </span>
                                    <span>
                                        <?php
                                        echo loadSvg('arrows-top.svg');
                                        ?>
                                    </span>
                                </span>
                                <span class="op-bottom">
                                    <?php echo $article_title ?>
                                </span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
