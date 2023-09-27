<?php
global $section;

$left_content = $section['left_content']; //wysiwyg

$right_content = $section['right_content']; //wysiwyg

$title = $section['title']; //text

$faq = $section['faq']; //repeater
?>
<div id="contact">
    <div class="container-fluid">
        <div id="contact-top">
            <div class="row row-spaced">
                <div class="col-sm-5" data-delay="100" id="contact-left">
                    <?php echo $left_content ?>
                </div>
                <div class="col-sm-7" data-delay="200" >
                    <?php echo $right_content ?>
                </div>
            </div>
        </div>
        <a id="faq"></a>
        <div id="contact-bottom">
            <div class="row row-spaced">
                <div class="col-sm-5" data-delay="100" >
                    <h2>
                        <?php echo $title ?>
                    </h2>
                </div>
                <div class="col-sm-7" data-delay="200" >
                    <?php if (!empty($faq)): ?>
                        <div class="faq-wrapper">
                            <?php
                            foreach ($faq as $key => $single_faq) {

                                $question = $single_faq['question']; //text

                                $answer = $single_faq['answer']; //textarea
                                ?>
                                <div class="one-faq">
                                    <div class="one-faq-question">
                                        <?php echo $question ?>
                                        <?php echo loadSvg('faq.svg'); ?>
                                    </div>
                                    <div class="one-faq-answer">
                                        <p><?php echo nl2br($answer) ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>