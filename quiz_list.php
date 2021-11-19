<?php
    require_once "classes/Quiz.php";
    require_once "classes/Question.php";
    require_once "classes/Answer.php";

    // közös
    //$response_quizes = file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=quiz");

    // saját
    $response_quizes = file_get_contents("http://localhost/backend.quizion.hu/?method=get&table=quiz");

    $quizes = json_decode($response_quizes);

    for ($i = 0; $i < count($quizes->data); $i++) {
        $quizes_list[$i] = new Quiz($quizes->data[$i]->id, $quizes->data[$i]->header, $quizes->data[$i]->description, $quizes->data[$i]->active);
    }
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once "require_once/head.html"; ?>
        <link rel="stylesheet" href="style/css/quiz_list.css">
        <title>Quizion Quiz Lista</title>
    </head>
    <body>
        <?php require_once "require_once/header_logo.html"; ?>

        <div class="container">
            <?php for ($i = 0; $i < count($quizes->data); $i++) { ?>
                <!--JAVÍT-->
                <!-- közös -->
                <?php //$questions = json_decode(file_get_contents("http://backend.quizion.hu/adatok/?method=get&table=question&quiz_id=" . $quizes_list[$i]->getId())); ?>
                
                <!-- saját -->
                <?php $questions = json_decode(file_get_contents("http://localhost/backend.quizion.hu/?method=get&table=question&quiz_id=" . $quizes_list[$i]->getId())); ?>

                <?php $questions_list[$i] = new Question($questions->data[$i]->id, $questions->data[$i]->quiz_id, $questions->data[$i]->content, $questions->data[$i]->no_right_answers, $questions->data[$i]->point); ?>
                <div class="quiz_list_div">
                    <h2 class="quiz_list_header"><?php echo $quizes_list[$i]->getHeader(); ?></h2>
                    <p class="quiz_list_description"><?php echo $quizes_list[$i]->getDescription(); ?></p>
                    <!--<a href="quiz.php?quiz_id=<?php //echo $quizes_list[$i]->getId(); ?>&question_id=<?php //echo 1; ?>">Játék</a>-->
                    <!--JAVÍT-->
                    <a href="quiz.php?quiz_id=<?php echo $quizes_list[$i]->getId(); ?>&question_id=<?php echo $questions_list[$i]->getId(); ?>">Játék</a>
                </div>
            <?php } ?>
        </div>

        <?php require_once "require_once/footer.html"; ?>
    </body>
</html>
